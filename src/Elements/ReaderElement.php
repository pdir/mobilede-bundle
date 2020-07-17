<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2019 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://pdir.de/mobilede.html
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Elements;

use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\System;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Pdir\MobileDeSyncBundle\Api\MobileDe;

class ReaderElement extends \ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_mobilede_reader';

    protected $ad = [];
    private $lang = [];

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### MobileDe READER ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        // load language file
        \System::loadLanguageFile('tl_mobile_ad');

        // Set auto item
        if (!isset($_GET['ad']) && \Config::get('useAutoItem') && isset($_GET['auto_item'])) {
            \Input::setGet('ad', \Input::get('auto_item'));
        }

        // get alias from auto item
        $strAlias = \Input::get('ad');

        $objAd = $this->Database->prepare('SELECT * FROM tl_mobile_ad WHERE alias=?')->execute($strAlias);
        $this->ad = $objAd->fetchAssoc();

        // Return if there are no ad / do not index or cache
        if (!is_array($this->ad) || count($this->ad) < 1) {
            throw new PageNotFoundException('Page not found: '.\Environment::get('uri'));
        }

        return parent::generate();
    }

    /**
     * Generate module.
     */
    protected function compile()
    {
        $assetsDir = 'web/bundles/pdirmobilede';

        if (!$this->pdir_md_removeModuleJs) {
            // not used yet $GLOBALS['TL_JAVASCRIPT']['md_js_1'] = '/bundles/pdirmobilede/js/mobilede_module.js|static';
        }
        if (!$this->pdir_md_removeModuleCss) {
            $GLOBALS['TL_CSS']['md_css_1'] = $assetsDir.'/vendor/fontello/css/fontello.css||static';
            $GLOBALS['TL_CSS']['md_css_2'] = $assetsDir.'/vendor/fontello/css/animation.css||static';
            $GLOBALS['TL_CSS']['md_css_3'] = $assetsDir.'/css/mobilede_module.css||static';
        }

        // features
        $featuresArr = deserialize($this->ad['features']);
        $newFeatures = [];
        foreach ($featuresArr as $feature) {
            if (!$feature) {
                continue;
            }

            $newFeatures[] = [
                'value' => $GLOBALS['TL_LANG']['tl_mobile_ad']['features']['options'][$feature],
                'key' => $feature,
            ];
        }
        $this->ad['features'] = $newFeatures;

        // specifics
        $specificsArr = preg_filter('/^specifics_(.*)/', '$1', array_keys($this->ad));
        $newSpecifics = [];
        foreach ($specificsArr as $specific) {
            if (!$this->ad['specifics_'.$specific]) {
                continue;
            }

            if($specific != "exhaust_inspection" && $specific != "general_inspection" && $specific != "construction_date" && $specific != "first_registration" && $specific != "delivery_date" && $specific != "first_models_production_date" && $specific != "mileage") {
                $newSpecifics[] = [
                    'key' => $specific,
                    'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_' . $specific][0],
                    'value' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_' . $specific]['options'][$this->ad['specifics_' . $specific]] ?: $this->ad['specifics_' . $specific],
                    'plainValue' => $this->ad['specifics_' . $specific],
                ];
            } elseif($specific == "mileage") {
                $newSpecifics[] = [
                    'key' => $specific,
                    'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_' . $specific][0],
                    'value' => $this->ad['specifics_' . $specific] ? System::getFormattedNumber($this->ad['specifics_' . $specific], 0) : 0,
                    'plainValue' => $this->ad['specifics_' . $specific],
                ];

            } else {
                $newSpecifics[] = [
                    'key' => $specific,
                    'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_'.$specific][0],
                    'value' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_'.$specific]['options'][$this->ad['specifics_'.$specific]] ?: ListingElement::formatDate($this->ad['specifics_'.$specific]),
                    'plainValue' => $this->ad['specifics_'.$specific],
                ];
            }

        }
        $this->ad['specifics'] = $newSpecifics;

        if($this->ad['specifics_general_inspection']) $this->ad['specifics_general_inspection'] = ListingElement::formatDate($this->ad['specifics_general_inspection']);

        if($this->ad['specifics_exhaust_inspection']) $this->ad['specifics_exhaust_inspection'] = ListingElement::formatDate($this->ad['specifics_exhaust_inspection']);

        if($this->ad['specifics_delivery_date']) $this->ad['specifics_delivery_date'] = ListingElement::formatDate($this->ad['specifics_delivery_date']);

        if($this->ad['specifics_first_registration']) $this->ad['specifics_first_registration'] = ListingElement::formatDate($this->ad['specifics_first_registration']);

        if($this->ad['specifics_construction_date']) $this->ad['specifics_construction_date'] = ListingElement::formatDate($this->ad['specifics_construction_date']);

        if($this->ad['specifics_first_models_production_date']) $this->ad['specifics_first_models_production_date'] = date($GLOBALS['TL_CONFIG']['dateFormat'], $this->ad['specifics_first_models_production_date']);

        if($this->ad['specifics_power']) $this->ad['specifics_power'] ? $this->ad['specifics_power'].' kW ('.System::getFormattedNumber(($this->ad['specifics_power'] * 1.35962), 0).' PS)' : 'Keine Angabe';


        // images
        $newGallery = [];
        $apiImages = deserialize($this->ad['api_images']);

        if ('demo' !== $this->pdir_md_customer_username)
        {
            $mobileDe = new MobileDe($this->pdir_md_customer_username, $this->pdir_md_customer_password, $this->pdir_md_customer_id, $this->pdir_md_customer_number);
            $newImages = $mobileDe->getGalleryImages($apiImages['@url']);

            foreach ($newImages['images']['image'] as $item) {
                $image = $item['representation'];

                $newGallery[] = [
                    ['@size' => 'S', '@url' => $image[0]['@url']],
                    ['@size' => 'XL', '@url' => $image[1]['@url']],
                    ['@size' => 'L', '@url' => $image[3]['@url']],
                    ['@size' => 'M', '@url' => $image[4]['@url']],
                    ['@size' => 'ICON', '@url' => $image[2]['@url']],
                ];
            }
        }

        if ('man' === $this->ad['type']) {
            $manImages = unserialize($this->ad['images']);
            foreach ($manImages as $uuid) {
                $objFile = \FilesModel::findByUuid($uuid);
                if ($objFile) {
                    $imageObj = new \Image(new \File($objFile->path));
                    $newGallery[] = [
                        ['@size' => 'S', '@url' => $imageObj->setTargetWidth(200)->setTargetHeight(150)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'XL', '@url' => $imageObj->setTargetWidth(640)->setTargetHeight(480)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'L', '@url' => $imageObj->setTargetWidth(400)->setTargetHeight(300)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'M', '@url' => $imageObj->setTargetWidth(298)->setTargetHeight(224)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'ICON', '@url' => $imageObj->setTargetWidth(80)->setTargetHeight(60)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                    ];
                }
            }

            $this->ad['htmlDescription']['value'] = $this->ad['vehicle_free_text'];
            $this->ad['makeModelDescription']['value'] = $this->ad['name'];
        }

        $fuelConsumption = [];

        if($this->ad['emission_fuel_consumption_co2_emission'])
        {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_co2_emission'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_co2_emission'], 1),
            ];
        }

        if($this->ad['emission_fuel_consumption_inner'])
        {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_inner'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_inner'], 1),
            ];
        }

        if($this->ad['emission_fuel_consumption_outer'])
        {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_outer'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_outer'], 1),
            ];
        }

        if($this->ad['emission_fuel_consumption_combined'])
        {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_combined'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_combined'], 1),
            ];
        }

        if($this->ad['emission_fuel_consumption_petrol_type'])
        {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_petrol_type'][0],
                'value' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_petrol_type_options'][$this->ad['emission_fuel_consumption_petrol_type']],
            ];
        }

        if($this->ad['emission_fuel_consumption_combined_power_consumption'])
        {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_combined_power_consumption'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_combined_power_consumption'], 1),
            ];
        }

        $this->ad['fuelConsumption'] = $fuelConsumption;

        if ('demo' !== $this->pdir_md_customer_username && 'man' !== $this->ad['type']) {
            $objRequest = new \Request();
            $strAuthorization = 'Basic '.base64_encode("{$this->pdir_md_customer_username}:{$this->pdir_md_customer_password}");
            $objRequest->setHeader('Accept-Language', 'de');
            $objRequest->setHeader('Accept', 'application/json');
            $objRequest->setHeader('Authorization', $strAuthorization);
            $objRequest->send('https://services.mobile.de/search-api/ad/'.$this->ad['ad_id'].'/');

            $tmpArr = (array) json_decode($objRequest->response, true);

            if (!$objRequest->hasError()) {
                if(0 == count($newGallery)) {
                    foreach ($tmpArr['ad']['images']['image'] as $key => $group) {
                        $newGallery[] = $group['representation'];
                    }
                }

                $this->ad['description'] = $tmpArr['ad']['description'];
                $this->ad['enrichedDescription'] = $tmpArr['ad']['enrichedDescription'];
                $this->ad['htmlDescription']['value'] = $this->htmlString($tmpArr['ad']['enrichedDescription']);
                $this->ad['highlights'] = $tmpArr['ad']['highlights'];
                $this->ad['makeModelDescription']['value'] = $tmpArr['ad']['vehicle']['make']['@key'].' '.$tmpArr['ad']['vehicle']['model-description']['@value'];
                $this->ad['makeModelDescription']['value'] = $tmpArr['ad']['vehicle']['make']['@key'].' '.$tmpArr['ad']['vehicle']['model-description']['@value'];
                $this->ad['seller']['company-name']['value'] = $tmpArr['ad']['seller']['company-name']['@value'];
                if ($tmpArr['ad']['seller']['logo-image']) {
                    $this->ad['seller']['logo-image'][0]['url'] = $tmpArr['ad']['seller']['logo-image']['representation'][0]['@url'];
                    $this->ad['seller']['logo-image'][1]['url'] = $tmpArr['ad']['seller']['logo-image']['representation'][1]['@url'];
                    $this->ad['seller']['logo-image'][2]['url'] = $tmpArr['ad']['seller']['logo-image']['representation'][2]['@url'];
                    $this->ad['seller']['logo-image'][3]['url'] = $tmpArr['ad']['seller']['logo-image']['representation'][3]['@url'];
                    $this->ad['seller']['logo-image'][4]['url'] = $tmpArr['ad']['seller']['logo-image']['representation'][4]['@url'];
                }
                $this->ad['seller']['address']['street']['value'] = $tmpArr['ad']['seller']['address']['street']['@value'];
                $this->ad['seller']['address']['zipcode']['value'] = $tmpArr['ad']['seller']['address']['zipcode']['@value'];
                $this->ad['seller']['address']['city']['value'] = $tmpArr['ad']['seller']['address']['city']['@value'];
                if ($tmpArr['ad']['seller']['phone']) {
                    $this->ad['seller']['phone']['value'] = '+'.$tmpArr['ad']['seller']['phone'][0]['@country-calling-code'].' '.$tmpArr['ad']['seller']['phone'][0]['@area-code'].' '.$tmpArr['ad']['seller']['phone'][0]['@number'];
                }
                $this->ad['seller']['email']['value'] = $tmpArr['ad']['seller']['email']['@value'];
                $this->ad['seller']['homepage']['value'] = $tmpArr['ad']['seller']['homepage']['@value'];
                $this->ad['seller']['mobile-seller-since']['value'] = $tmpArr['ad']['seller']['mobile-seller-since']['@value'];
            }
        }
        $this->ad['images'] = $newGallery;

        $this->Template->ad = $this->ad;

        // Debug mode
        if ($this->pdir_md_enableDebugMode) {
            $this->Template->debug = true;
            $this->Template->version = MobileDeSetup::VERSION;
            $this->Template->customer = $this->pdir_md_customer_id;
            $this->Template->rawData = $this->ad;
        }
    }

    protected function htmlString($str)
    {
        $str = trim($str);

        $str = str_replace('**Sicherheitsausstattung:**', '<h3>Sicherheitsausstattung</h3>', $str);
        $str = str_replace('**Technologie:**', '<h3>Technologie</h3>', $str);
        $str = str_replace('Sicherheit &amp; Umwelt:', '<h3>Sicherheit & Umwelt</h3>', $str);
        $str = str_replace('**Sonstiges:**', '<h3>Sonstiges</h3>', $str);
        $str = str_replace('**Außenausstattung:**', '<h3>Außenausstattung</h3>', $str);
        $str = str_replace('**Innenausstattung:**', '<h3>Innenausstattung</h3>', $str);
        $str = str_replace('**Ausstattungspakete (optional)**', '<h3>Ausstattungspakete (optional)</h3>', $str);
        $str = str_replace('**Touring-Paket enthalten**', '<h3>Touring-Paket enthalten</h3>', $str);
        $str = str_replace('**I-ACTIVESENSE-PAKET enthalten**', '<h3>I-ACTIVESENSE-PAKET enthalten</h3>', $str);

        $str = str_replace('\\\\* ', '<br> - ', $str);
        $str = str_replace('\\\\\\\\**', '<br> - ', $str);

        $str = str_replace('\\\\&nbsp;\\\\', '<p>&nbsp;</p>', $str);
        $str = str_replace('\\\\**&nbsp;**', '<p>&nbsp;</p>', $str);
        $str = str_replace('**\\\\**', '<br />', $str);

        $str = str_replace('\\\\\\\\\\', '<br />', $str);
        $str = str_replace('\\\\', '', $str);
        $str = str_replace('&nbsp;**', '', $str);
        $str = str_replace('**', '', $str);

        return $str;
    }
}
