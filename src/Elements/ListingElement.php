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
use Pdir\MobileDeBundle\Module\MobileDeSetup;

class ListingElement extends \ContentElement
{
    const PARAMETER_KEY = 'ad';

    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'ce_mobilede_list';
    protected $strItemTemplate = 'ce_mobilede_item';

    /**
     * @var \PageModel
     */
    private $readerPage;

    private $ads = [];
    private $filters = [];
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
            $objTemplate->wildcard = '### MobileDe LIST ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id='.$this->id;

            return $objTemplate->parse();
        }

        // load language file
        $this->lang = \System::loadLanguageFile('tl_mobile_ad');

        // Get reader page model
        if(!$this->pdir_md_readerPage || $this->pdir_md_readerPage == 0) {
            throw new \Exception('Please select a reader page in element.');
        }

        $pageModel = \PageModel::findPublishedByIdOrAlias($this->pdir_md_readerPage);
        if($pageModel !== null) {
            $this->readerPage = $pageModel->current()->row();
        }

        // Return if there is no customer id
        if (!$this->pdir_md_customer_id && !$this->pdir_md_customer_number) {
            return '';
        }

        // set custom list template
        if ($this->pdir_md_listTemplate && $this->strTemplate !== $this->pdir_md_listTemplate) {
            $this->strTemplate = $this->pdir_md_listTemplate;
        }

        // set custom item template
        if ($this->pdir_md_itemTemplate && $this->strItemTemplate !== $this->pdir_md_itemTemplate) {
            $this->strItemTemplate = $this->pdir_md_itemTemplate;
        }

        $objAds = $this->Database->prepare('SELECT * FROM tl_mobile_ad ORDER BY name')->execute();

        while ($objAds->next()) {
            $this->ads['searchResultItems'][] = $objAds->row();
        }

        // Return if there are no ads
        if (!is_array($this->ads) || count($this->ads) < 1) {
            throw new PageNotFoundException('Page not found: '.\Environment::get('uri'));
        }

        return parent::generate();
    }

    /**
     * Generate module.
     */
    protected function compile()
    {
        $assetsDir = 'system/modules/pdirMobileDe/assets';

        if (VERSION >= 4.0) {
            $assetsDir = 'web/bundles/pdirmobilede';
        }

        if (!$this->pdir_md_removeModuleJs) {
            $GLOBALS['TL_JAVASCRIPT']['md_js_1'] = $assetsDir.'/js/mobilede_module.js|static';
            $GLOBALS['TL_JAVASCRIPT']['md_js_2'] = '//unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js|satic';
            $GLOBALS['TL_JAVASCRIPT']['md_js_3'] = $assetsDir.'/js/URI.min.js|static';
        }
        if (!$this->pdir_md_removeModuleCss) {
            $GLOBALS['TL_CSS']['md_css_1'] = $assetsDir.'/vendor/fontello/css/fontello.css||static';
            $GLOBALS['TL_CSS']['md_css_2'] = $assetsDir.'/vendor/fontello/css/animation.css||static';
            $GLOBALS['TL_CSS']['md_css_3'] = $assetsDir.'/css/mobilede_module.css||static';
        }

        // Ordering

        // Pagination

        // Limit

        // Promotion
        if (1 === $this->pdir_md_promotion_corner_shadow) {
            $this->pdir_md_promotion_corner_shadow = 'shadow';
        }

        if (1 !== $this->pdir_md_hidePromotionBox and isset($this->ads['prominent'])) {
            $arrFeaturedCss = [
                $this->pdir_md_promotion_corner_color,
                $this->pdir_md_promotion_corner_position,
                $this->pdir_md_promotion_corner_sticky,
                $this->pdir_md_promotion_corner_shadow,
            ];
            $this->featureCss = implode(' ', $arrFeaturedCss);
            $this->Template->promotion = $this->renderAdItem([$this->ads['prominent']])[0];
        }

        // Shuffle
        $this->Template->listShuffle = ($this->pdir_md_list_shuffle) ? true : false;

        // Price Slider
        $this->Template->priceSlider = ($this->pdir_md_priceSlider) ? true : false;
        $this->Template->powerSlider = ($this->pdir_md_powerSlider) ? true : false;
        $this->Template->mileageSlider = ($this->pdir_md_mileageSlider) ? true : false;

        // Featured corner
        if (1 === $this->pdir_md_corner_shadow) {
            $this->pdir_md_corner_shadow = 'shadow';
        }

        $arrFeaturedCss = [
            $this->pdir_md_corner_color,
            $this->pdir_md_corner_position,
            $this->pdir_md_corner_shadow,
        ];
        $this->featureCss = implode(' ', $arrFeaturedCss);

        // Add ads to template
        $this->Template->ads = $this->renderAdItem($this->ads['searchResultItems']);

        // Filters
        $this->Template->filters = $this->filters;

        if ($this->pdir_md_hideFilters) {
            $this->Template->hideFilters = true;
        }

        // Price Slider
        $this->Template->priceSlider = $this->pdir_md_priceSlider;

        // No result message
        $this->Template->noResultMessage = $GLOBALS['TL_LANG']['pdirMobileDe']['field_keys']['noResultMessage'];

        // Debug mode
        if ($this->pdir_md_enableDebugMode) {
            $this->Template->debug = true;
            $this->Template->version = MobileDeSetup::VERSION;
            $this->Template->customerId = $this->pdir_md_customer_id;
            $this->Template->customerNumber = $this->pdir_md_customer_number;
            $this->Template->rawData = $this->ads;
        }
    }

    /**
     * Return the ads as html string.
     *
     * @param array
     * @param mixed $arrAds
     *
     * @return array
     */
    protected function renderAdItem($arrAds)
    {
        $arrReturn = [];

        foreach ($arrAds as $ad) {
            $objFilterTemplate = new \FrontendTemplate($this->strItemTemplate);

            $objFilterTemplate->desc = $ad['name'];
            $images = deserialize($ad['api_images']);
            if (is_array($images) && count($images) > 0) {
                $objFilterTemplate->imageSrc_S = $images[0]['@url'];
                $objFilterTemplate->imageSrc_XL = $images[1]['@url'];
                $objFilterTemplate->imageSrc_L = $images[3]['@url'];
                $objFilterTemplate->imageSrc_M = $images[4]['@url'];
                $objFilterTemplate->imageSrc_ICON = $images[2]['@url'];
            }

            if ('man' === $ad['type']) {
                $manImages = unserialize($ad['images']);

                $objFile = \FilesModel::findByUuid($manImages[0]);

                if ($objFile) {
                    $imageObj = new \Image(new \File($objFile->path));
                    $objFilterTemplate->imageSrc_S = $imageObj->setTargetWidth(200)->setTargetHeight(150)->setResizeMode('center_center')->executeResize()->getResizedPath();
                    $objFilterTemplate->imageSrc_XL = $imageObj->setTargetWidth(640)->setTargetHeight(480)->setResizeMode('center_center')->executeResize()->getResizedPath();
                    $objFilterTemplate->imageSrc_L = $imageObj->setTargetWidth(400)->setTargetHeight(300)->setResizeMode('center_center')->executeResize()->getResizedPath();
                    $objFilterTemplate->imageSrc_M = $imageObj->setTargetWidth(298)->setTargetHeight(224)->setResizeMode('center_center')->executeResize()->getResizedPath();
                    $objFilterTemplate->imageSrc_ICON = $imageObj->setTargetWidth(80)->setTargetHeight(60)->setResizeMode('center_center')->executeResize()->getResizedPath();
                    $objFilterTemplate->imageSrc_ORIGINAL = $objFile->path;
                }
            }

            // image fallback
            if (!$objFilterTemplate->imageSrc_S && !$objFilterTemplate->imageSrc_XL && !$objFilterTemplate->imageSrc_L &&
                !$objFilterTemplate->imageSrc_M) {
                $objFilterTemplate->imageSrc_S = $objFilterTemplate->imageSrc_XL = $objFilterTemplate->imageSrc_L =
                $objFilterTemplate->imageSrc_M = str_replace('http://', 'https://', $ad['image']['src']);
            }

            $objFilterTemplate->plainPrice = $ad['consumer_price_amount']; // rand(1, 20000); //
            $objFilterTemplate->plainPower = $ad['specifics_power'];
            $objFilterTemplate->price = \System::getFormattedNumber($ad['consumer_price_amount'], 2).' '.$ad['price_currency'];
            $objFilterTemplate->link = $this->getReaderPageLink($ad['alias']);
            $objFilterTemplate->fuelType = $ad['specifics_fuel'];
            $objFilterTemplate->transmission = $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_gearbox']['options'][$ad['specifics_gearbox']];
            $objFilterTemplate->power = $ad['specifics_power'] ? $ad['specifics_power'].' KW ('.number_format((float) ($ad['specifics_power'] * 1.35962), 0, ',', '.').' PS)' : 'Keine Angabe';
            $objFilterTemplate->bodyType = $ad['vehicle_class'];
            $objFilterTemplate->vehicleCategory = $ad['vehicle_category'];
            $objFilterTemplate->usageType = $ad['specifics_usage_type'];
            $objFilterTemplate->fuelConsumption = [
                0 => [
                    'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_combined_power_consumption'][0],
                    'value' => $ad['emission_fuel_consumption_combined'],
                ],
                1 => [
                    'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['emission_fuel_consumption_co2_emission'][0],
                    'value' => $ad['emission_fuel_consumption_co2_emission'],
                ],
            ];
            $objFilterTemplate->featured = ('NONE' === $ad['newnessMarker']) ? false : true;
            $objFilterTemplate->firstRegistration = ($ad['specifics_first_registration']) ? $ad['specifics_first_registration'] : 'keine Angabe';
            $objFilterTemplate->mileage = $ad['specifics_mileage'] ? $ad['specifics_mileage'] : 0;
            $objFilterTemplate->filterClasses = $this->getFilterClasses($ad);

            if (!$this->pdir_md_hidePromotionBox) {
                $objFilterTemplate->promotion = true;
            }

            if ($this->featureCss) {
                $objFilterTemplate->featureCss = $this->featureCss;
            }

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

        if (\Config::get('useAutoItem')) {
            $paramString = sprintf('/%s',
                $pageId
            );
        }

        return $this->generateFrontendUrl($this->readerPage, $paramString);
    }

    protected function getFilterClasses($ad)
    {
        $filter = [];
        $filter[] = str_replace(' ', '_', $ad['vehicle_make']);
        $filter[] = $ad['specifics_exterior_color'];
        $filter[] = $ad['vehicle_category'];
        $filter[] = $ad['specifics_fuel'];
        $filter[] = $ad['specifics_gearbox'];
        $filter[] = $ad['specifics_usage_type'];

        $filter = array_filter($filter,'strlen'); // remove empty fields

        if ($ad['vehicle_make']) {
            $this->filters['make'][$ad['vehicle_make']] = [
                'label' => $ad['vehicle_make'],
                'key' => str_replace(' ', '_', $ad['vehicle_make']),
                'count' => (isset($this->filters['make'][$ad['vehicle_make']]['count']) ? ($this->filters['usageType'][$ad['vehicle_make']]['count'] + 1) : 2),
            ];
        }

        if ($ad['specifics_exterior_color']) {
            $this->filters['colors'][$ad['specifics_exterior_color']] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_exterior_color']['options'][$ad['specifics_exterior_color']],
                'key' => $ad['specifics_exterior_color'],
                'count' => (isset($this->filters['colors'][$ad['specifics_exterior_color']]['count']) ? $this->filters['usageType'][$ad['specifics_exterior_color']]['count'] + 1 : 1),
            ];
        }

        if ($ad['vehicle_category']) {
            $this->filters['categories'][$ad['vehicle_category']] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['vehicle_category']['options'][$ad['vehicle_category']],
                'key' => $ad['vehicle_category'],
                'count' => (isset($this->filters['categories'][$ad['vehicle_category']]['count']) ? $this->filters['usageType'][$ad['vehicle_category']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_fuel']) {
            $this->filters['fuelType'][$ad['specifics_fuel']] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_fuel']['options'][$ad['specifics_fuel']],
                'key' => $ad['specifics_fuel'],
                'count' => (isset($this->filters['fuelType'][$ad['specifics_fuel']]['count']) ? $this->filters['usageType'][$ad['specifics_fuel']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_gearbox']) {
            $this->filters['gearbox'][$ad['specifics_gearbox']] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_gearbox']['options'][$ad['specifics_gearbox']],
                'key' => $ad['specifics_gearbox'],
                'count' => (isset($this->filters['gearbox'][$ad['specifics_gearbox']]['count']) ? $this->filters['usageType'][$ad['specifics_gearbox']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_usage_type']) {
            $this->filters['usageType'][$ad['specifics_usage_type']] = [
                'label' => $GLOBALS['TL_LANG']['tl_mobile_ad']['specifics_usage_type']['options'][$ad['specifics_usage_type']],
                'key' => $ad['specifics_usage_type'],
                'count' => (isset($this->filters['usageType'][$ad['specifics_usage_type']]['count']) ? $this->filters['usageType'][$ad['specifics_usage_type']]['count'] + 1 : 1),
            ];
        }

        return implode(' ', $filter);
    }
}
