<?php

/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2018 pdir/ digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Elements;

use Contao\CoreBundle\Exception\PageNotFoundException;
use Pdir\MobileDeBundle\Module\MobileDeSetup;

class ReaderElement extends  \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_mobilede_reader';

    protected $ad = [];
    private $lang = [];

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### MobileDe READER ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
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

        $objAd = $this->Database->prepare("SELECT * FROM tl_mobile_ad WHERE alias=?")->execute($strAlias);
        $this->ad = $objAd->fetchAssoc();

        // Return if there are no ad / do not index or cache
        if (!is_array($this->ad) || count($this->ad) < 1)
        {
			throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
        }
        return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
		$assetsDir = 'web/bundles/pdirmobilede';

		if(!$this->pdir_md_removeModuleJs)
		{
			// not used yet $GLOBALS['TL_JAVASCRIPT']['md_js_1'] = '/bundles/pdirmobilede/js/ads.js|static';
		}
		if(!$this->pdir_md_removeModuleCss)
		{
			$GLOBALS['TL_CSS']['md_css_1'] = $assetsDir . '/vendor/fontello/css/fontello.css||static';
			$GLOBALS['TL_CSS']['md_css_2'] = $assetsDir . '/vendor/fontello/css/animation.css||static';
			$GLOBALS['TL_CSS']['md_css_3'] = $assetsDir . '/css/ads.css||static';
		}

		// features
        $featuresArr = deserialize($this->ad['features']);
        $newFeatures = [];
		foreach($featuresArr as $feature)
        {
            if(!$feature)
                continue;

            $newFeatures[] = [
                'value' => $GLOBALS['TL_LANG']['tl_mobile_ad']['features']['options'][$feature],
                'key' => $feature
            ];
        }
        $this->ad['features'] = $newFeatures;

		// specifics
        $specificsArr = preg_filter('/^specifics_(.*)/', '$1', array_keys( $this->ad ));
        $newSpecifics = [];
        foreach($specificsArr as $specific)
        {
            if(!$this->ad['specifics_' . $specific])
                continue;

            $newSpecifics[] = [
                'key' => $specific,
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_' . $specific][0],
                'value' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_' . $specific]['options'][$this->ad['specifics_' . $specific]] ? : $this->ad['specifics_' . $specific],
                'plainValue' => $this->ad['specifics_' . $specific]
            ];
        }
        $this->ad['specifics'] = $newSpecifics;

        // images
        $newGallery = [];
        if($this->ad['type'] == 'man')
        {
            $manImages = unserialize($this->ad['images']);
            foreach($manImages as $uuid) {
                $objFile = \FilesModel::findByUuid($uuid);
                if ($objFile) {
                    $imageObj = new \Image(new \File($objFile->path));
                    $newGallery[] = [
                        ['@size' => 'S','@url' => $imageObj->setTargetWidth(200)->setTargetHeight(150)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'XL','@url' => $imageObj->setTargetWidth(640)->setTargetHeight(480)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'L','@url' => $imageObj->setTargetWidth(400)->setTargetHeight(300)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'M','@url' => $imageObj->setTargetWidth(298)->setTargetHeight(224)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                        ['@size' => 'ICON','@url' => $imageObj->setTargetWidth(80)->setTargetHeight(60)->setResizeMode('center_center')->executeResize()->getResizedPath()],
                    ];
                }
            }
        }

        if($this->pdir_md_customer_username != 'demo' && $this->ad['type'] != 'man')
        {
            $objRequest = new \Request();
            $strAuthorization = 'Basic ' . base64_encode("{$this->pdir_md_customer_username}:{$this->pdir_md_customer_password}");
            $objRequest->setHeader('Accept-Language', 'de');
            $objRequest->setHeader('Accept', 'application/json');
            $objRequest->setHeader('Authorization', $strAuthorization);
            $objRequest->send( 'https://services.mobile.de/search-api/ad/' . $this->ad['ad_id'] . '/' );

            $tmpArr = (array) json_decode( $objRequest->response, true );

            if ( !$objRequest->hasError() )
            {
                foreach($tmpArr['ad']['images']['image'] as $key => $group)
                {
                    $newGallery[] = $group['representation'];
                }

                $this->ad['description'] = $tmpArr['ad']['description'];
                $this->ad['enrichedDescription'] = $tmpArr['ad']['enrichedDescription'];
                $this->ad['htmlDescription']['value'] = $this->htmlString($tmpArr['ad']['enrichedDescription']);
                $this->ad['highlights'] = $tmpArr['ad']['highlights'];
            }
        }
        $this->ad['images'] = $newGallery;

        $this->Template->ad = $this->ad;

		// Debug mode
		if($this->pdir_md_enableDebugMode)
		{
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
