<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 pdir / digital agentur // pdir GmbH
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

use Contao\BackendTemplate;
use Contao\Config;
use Contao\ContentElement;
use Contao\CoreBundle\Exception\PageNotFoundException;
use Contao\Environment;
use Contao\File;
use Contao\FilesModel;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Pdir\MobileDeSyncBundle\Api\MobileDe;

class ReaderElement extends ContentElement
{
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_mobilede_reader';
    protected $strTable = 'tl_vehicle';

    protected $ad = [];
    private $lang = [];
    private $image;

    /**
     * Display a wildcard in the back end.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### MobileDe READER ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        // load language file
        System::loadLanguageFile($this->strTable);

        // Set auto item
        if (!isset($_GET['ad']) && Config::get('useAutoItem') && isset($_GET['auto_item'])) {
            Input::setGet('ad', Input::get('auto_item'));
        }

        // get alias from auto item
        $strAlias = Input::get('ad');

        $objAd = $this->Database->prepare('SELECT * FROM '.$this->strTable.' WHERE alias=?')->execute($strAlias);
        $this->ad = $objAd->fetchAssoc();

        // Return if there are no ad / do not index or cache
        if (!\is_array($this->ad) || \count($this->ad) < 1) {
            throw new PageNotFoundException('Page not found: '.Environment::get('uri'));
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
        $featuresArr = StringUtil::deserialize($this->ad['features']);
        if ($featuresArr) {
            $newFeatures = [];
            foreach ($featuresArr as $feature) {
                if (!$feature) {
                    continue;
                }

                $newFeatures[] = [
                    'value' => $GLOBALS['TL_LANG'][$this->strTable]['features']['options'][$feature],
                    'key' => $feature,
                ];
            }
            $this->ad['features'] = $newFeatures;
        }

        // specifics
        $specificsArr = \preg_filter('/^specifics_(.*)/', '$1', \array_keys($this->ad));
        $newSpecifics = [];
        foreach ($specificsArr as $specific) {
            if (!$this->ad['specifics_'.$specific]) {
                continue;
            }

            if ('exhaust_inspection' !== $specific && 'general_inspection' !== $specific && 'construction_date' !== $specific && 'first_registration' !== $specific && 'delivery_date' !== $specific && 'first_models_production_date' !== $specific && 'mileage' !== $specific) {
                $newSpecifics[] = [
                    'key' => $specific,
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific][0],
                    'value' => isset($GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific]['options']) ? $GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific]['options'][$this->ad['specifics_'.$specific]] : $this->ad['specifics_'.$specific],
                    'plainValue' => $this->ad['specifics_'.$specific],
                ];
            } elseif ('mileage' === $specific) {
                $newSpecifics[] = [
                    'key' => $specific,
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific][0],
                    'value' => $this->ad['specifics_'.$specific] ? System::getFormattedNumber($this->ad['specifics_'.$specific], 0) : 0,
                    'plainValue' => $this->ad['specifics_'.$specific],
                ];
            } else {
                $newSpecifics[] = [
                    'key' => $specific,
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific][0],
                    'value' => isset($GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific]['options']) ? $GLOBALS['TL_LANG'][$this->strTable]['specifics_'.$specific]['options'][$this->ad['specifics_'.$specific]] : ListingElement::formatDate($this->ad['specifics_'.$specific]),
                    'plainValue' => $this->ad['specifics_'.$specific],
                ];
            }
        }
        $this->ad['specifics'] = $newSpecifics;

        if ($this->ad['specifics_general_inspection']) {
            $this->ad['specifics_general_inspection'] = ListingElement::formatDate($this->ad['specifics_general_inspection']);
        }

        if ($this->ad['specifics_exhaust_inspection']) {
            $this->ad['specifics_exhaust_inspection'] = ListingElement::formatDate($this->ad['specifics_exhaust_inspection']);
        }

        if ($this->ad['specifics_delivery_date']) {
            $this->ad['specifics_delivery_date'] = ListingElement::formatDate($this->ad['specifics_delivery_date']);
        }

        if ($this->ad['specifics_first_registration']) {
            $this->ad['specifics_first_registration'] = ListingElement::formatDate($this->ad['specifics_first_registration']);
        }

        if ($this->ad['specifics_construction_date']) {
            $this->ad['specifics_construction_date'] = ListingElement::formatDate($this->ad['specifics_construction_date']);
        }

        if ($this->ad['specifics_first_models_production_date']) {
            $this->ad['specifics_first_models_production_date'] = \date($GLOBALS['TL_CONFIG']['dateFormat'], $this->ad['specifics_first_models_production_date']);
        }

        if ($this->ad['specifics_power']) {
            $this->ad['specifics_power'] = $this->ad['specifics_power'].' kW ('.System::getFormattedNumber(($this->ad['specifics_power'] * 1.35962), 0).' PS)';
        }

        // images
        $newGallery = [];

        if (null !== $this->ad['api_images']) {
            $images = StringUtil::deserialize($this->ad['api_images'])['images']['image'];

            if (\is_array($images) && 0 < \count($images)) {
                foreach ($images as $row) {
                    foreach ($row['representation'] as $image) {
                        $newGallery[$image['@size']][] = $image['@url'];

                        // fix for xxl image which is not included in xml response
                        if ('XL' === $image['@size']) {
                            $newGallery['XXL'][] = \str_replace('$_27.JPG', '$_57.JPG', $image['@url']);
                        }
                    }
                }
            }

            $this->ad['htmlDescription'] = $this->ad['vehicle_free_text'];
            $this->ad['makeModelDescription'] = $this->ad['name'];
        }

        if (isset($this->ad['images'])) {
            $manImages = \unserialize($this->ad['images']);

            foreach ($manImages as $uuid) {
                $objFile = FilesModel::findByUuid($uuid);
                if ($objFile) {
                    if (!isset($newGallery['XXL'])) {
                        $newGallery['XXL'] = [];
                    }

                    $newGallery['XXL'][] = $this->getImageByPath($objFile->path, 'XXL');

                    if (!isset($newGallery['original'])) {
                        $newGallery['original'] = [];
                    }

                    $newGallery['original'][] = [
                        'path' => $objFile->path,
                        'uuid' => $uuid,
                    ];
                }
            }
        }

        if (isset($this->ad['syscara_images_layout'])) {
            $groundPlan = \unserialize($this->ad['syscara_images_layout']);
            $objFile = FilesModel::findByUuid($groundPlan[0]);
            $this->ad['groundPlan'] = $objFile->path;
        }

        $fuelConsumption = [];

        if ($this->ad['emission_fuel_consumption_co2_emission']) {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_co2_emission'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_co2_emission'], 1),
            ];
        }

        if ($this->ad['emission_fuel_consumption_inner']) {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_inner'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_inner'], 1),
            ];
        }

        if ($this->ad['emission_fuel_consumption_outer']) {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_outer'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_outer'], 1),
            ];
        }

        if ($this->ad['emission_fuel_consumption_combined']) {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_combined'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_combined'], 1),
            ];
        }

        if ($this->ad['emission_fuel_consumption_petrol_type']) {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_petrol_type'][0],
                'value' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_petrol_type_options'][$this->ad['emission_fuel_consumption_petrol_type']],
            ];
        }

        if ($this->ad['emission_fuel_consumption_combined_power_consumption']) {
            $fuelConsumption[] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_combined_power_consumption'][0],
                'value' => System::getFormattedNumber($this->ad['emission_fuel_consumption_combined_power_consumption'], 1),
            ];
        }

        $this->ad['fuelConsumption'] = $fuelConsumption;

        if ($this->ad['sellerInfo']) {
            $this->ad['seller'] = \json_decode($this->ad['sellerInfo'], true);
        }

        $this->ad['bodyType'] = $this->ad['vehicle_class'];

        // use placeholder if no image exists
        if (\is_array($newGallery) && 0 === \count($newGallery)) {
            $newGallery[] = $this->getImageByPath('web/bundles/pdirmobilede/img/pdir_mobilemodul_platzhalterbild_XL.jpg');
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

    protected function getImageByPath($str, $type = 'allSizes')
    {
        $this->image = new Image(new File($str));

        switch ($type) {
            case 'S':
                $this->getImagePath(200, 150);
                break;
            case 'M':
                return $this->getImagePath(298, 224);
            case 'L':
                return $this->getImagePath(400, 300);
            case 'XL':
                return $this->getImagePath(640, 480);
            case 'XXL':
                return $this->getImagePath(1200, 800);
            case 'ICON':
                return $this->getImagePath(80, 60);
            case 'ORIGINAL':
                return $str;
            default:
                return [
                    ['@size' => 'S', '@url' => $this->getImagePath(200, 150)],
                    ['@size' => 'XL', '@url' => $this->getImagePath(640, 480)],
                    ['@size' => 'XXL', '@url' => $this->getImagePath(1200, 800)],
                    ['@size' => 'L', '@url' => $this->getImagePath(400, 300)],
                    ['@size' => 'M', '@url' => $this->getImagePath(298, 224)],
                    ['@size' => 'ICON', '@url' => $this->getImagePath(80, 60)],
                    ['@size' => 'ORIGINAL', '@url' => $str],
                ];
        }
    }

    protected function getImagePath($width, $height, $mode = 'center_center')
    {
        return $this->image->setTargetWidth($width)->setTargetHeight($height)->setResizeMode($mode)->executeResize()->getResizedPath();
    }
}
