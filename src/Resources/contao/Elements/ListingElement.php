<?php

/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2017 pdir / digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDe;

use Contao\CoreBundle\Exception\PageNotFoundException;

class ListingElement extends \ContentElement
{
	const PARAMETER_KEY = 'ad';

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_mobilede_list';
    protected $strItemTemplate = 'ce_mobilede_item';

	/**
	 * @var \PageModel
	 */
	private $readerPage;

	private $ads = array();

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### MobileDe LIST ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            return $objTemplate->parse();
        }

        // Get reader page model
		$this->readerPage = \PageModel::findPublishedByIdOrAlias($this->pdir_md_readerPage)->current()->row();

        // Return if there is no customer id
        if (!$this->pdir_md_customer_id) {
            return '';
        }

        // set custom list template
		if($this->pdir_md_listTemplate && $this->strTemplate != $this->pdir_md_listTemplate)
			$this->strTemplate = $this->pdir_md_listTemplate;
		// set custom item template
		if($this->pdir_md_itemTemplate && $this->strItemTemplate != $this->pdir_md_itemTemplate)
			$this->strItemTemplate = $this->pdir_md_itemTemplate;

        $helper = new Helper($this->pdir_md_customer_username, $this->pdir_md_customer_password, $this->pdir_md_customer_id);
        $this->ads = $helper->getAds();

        // Return if there are no ads
        if (!is_array($this->ads) || count($this->ads) < 1) {
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
            $GLOBALS['TL_JAVASCRIPT']['md_js_1'] = $assetsDir . '/js/ads.js|static';
			$GLOBALS['TL_JAVASCRIPT']['md_js_2'] = '//unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js|satic';
        }
        if(!$this->pdir_md_removeModuleCss)
        {
			$GLOBALS['TL_CSS']['md_css_1'] = $assetsDir . '/vendor/fontello/css/fontello.css||static';
			$GLOBALS['TL_CSS']['md_css_2'] = $assetsDir . '/vendor/fontello/css/animation.css||static';
            $GLOBALS['TL_CSS']['md_css_3'] = $assetsDir . '/css/ads.css||static';
        }

        // Filters
		$this->Template->filters = $this->ads['searchReferenceData'];

		if($this->pdir_md_hideFilters)
			$this->Template->hideFilters = true;

		// Ordering

        // Pagination

        // Limit

        // Promotion
        if( $this->pdir_md_hidePromotionBox != 1 AND isset($this->ads['prominent']) ){
			$arrFeaturedCss = array(
				$this->pdir_md_promotion_corner_color,
				$this->pdir_md_promotion_corner_position,
				$this->pdir_md_promotion_corner_sticky,
				$this->pdir_md_promotion_corner_shadow
			);
        	$this->featureCss =  implode( ' ', $arrFeaturedCss);
			$this->Template->promotion = $this->renderAdItem(array($this->ads['prominent']))[0];
		}

		// Shuffle
        $this->Template->listShuffle = ($this->pdir_md_list_shuffle) ? true : false;

		// Price Slider
        $this->Template->priceSlider = ($this->pdir_md_priceSlider) ? true : false;

        // Featured corner
		$arrFeaturedCss = array(
			$this->pdir_md_corner_color,
			$this->pdir_md_corner_position,
			$this->pdir_md_corner_shadow
		);
		$this->featureCss =  implode( ' ', $arrFeaturedCss);

		// Add ads to template
        $this->Template->ads = $this->renderAdItem($this->ads['searchResultItems']);

        // Debug mode
		if($this->pdir_md_enableDebugMode)
		{
			$this->Template->debug = true;
			$this->Template->version = Helper::VERSION;
			$this->Template->customer = $this->pdir_md_customer_id;
			$this->Template->rawData = $this->ads;
		}
    }

	/**
	 * Return the ads as html string
	 *
	 * @param array
	 * @return array
	 */
    protected function renderAdItem($arrAds)
	{
		$arrReturn = array();
		foreach($arrAds as $ad)
		{
			$objFilterTemplate = new \FrontendTemplate($this->strItemTemplate);

			$objFilterTemplate->desc = $ad['makeModelDescription']['value'];
			$objFilterTemplate->imageSrc = $ad['image']['src'];
            $objFilterTemplate->plainPrice = $ad['priceModel']['plainPrice']['value'];
			$objFilterTemplate->price = $ad['priceModel']['primaryPrice']['countryOfSale']['value'];
			$objFilterTemplate->link = $this->getReaderPageLink($ad['adId']);
			$objFilterTemplate->fuelType = $ad['fuelType']['value'];
			$objFilterTemplate->transmission = $ad['transmission']['value'];
			$objFilterTemplate->power = $ad['power']['value'];
			$objFilterTemplate->bodyType = $ad['bodyType']['value'];
			$objFilterTemplate->usageType = $ad['usageType']['value'];
			$objFilterTemplate->fuelConsumption = $ad['fuelConsumption'];
			$objFilterTemplate->featured = ($ad['newnessMarker'] == 'NONE') ? false : true;
			$objFilterTemplate->firstRegistration = ($ad['firstRegistration']['value']) ? $ad['firstRegistration']['value'] : 'keine Angabe';
			$objFilterTemplate->mileage = $ad['mileage']['value'];
			if( isset($ad['filterClasses']) )
				$objFilterTemplate->filterClasses = strtolower( implode( ' ', $ad['filterClasses'] ) );

			if(!$this->pdir_md_hidePromotionBox)
				$objFilterTemplate->promotion = true;

			if($this->featureCss)
				$objFilterTemplate->featureCss = $this->featureCss;

			$arrReturn[] = $objFilterTemplate->parse();
		}
		return $arrReturn;
	}

	protected function getReaderPageLink($pageId)
	{
		$paramString = sprintf('/%s/%s',
		self::PARAMETER_KEY,
				$pageId
		);

		if(\Config::get('useAutoItem'))
		{
			$paramString = sprintf('/%s',
				$pageId
			);
		}

		return $this->generateFrontendUrl($this->readerPage, $paramString);
	}
}
