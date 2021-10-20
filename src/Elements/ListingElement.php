<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2021 pdir / digital agentur // pdir GmbH
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
use Contao\Database;
use Contao\StringUtil;
use Contao\System;
use Pdir\MobileDeBundle\Module\MobileDeSetup;

/**
 * Provide methods to render content element "vehicle listing".
 *
 * @property string $pdirVehicleFilterFields
 * @property string $pdirVehicleFilterSort
 * @property string $pdirVehicleFilterWhere
 * @property string $pdirVehicleFilterSearch
 * @property string $pdirVehicleFilterByAccount
 * @property string $pdirVehicleFilterByType
 * @property string $pdirVehicleFilterMaxItems
 */
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
    protected $strTable = 'tl_vehicle';

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
        $this->lang = System::loadLanguageFile($this->strTable);

        // Get reader page model
        $this->readerPage = \PageModel::findPublishedByIdOrAlias($this->pdir_md_readerPage)->current()->row();

        // Return if there is no customer id
        if (!$this->pdir_md_customer_id) {
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

        $this->pdirVehicleFilterWhere = $this->replaceInsertTags($this->pdirVehicleFilterWhere, false);

        // prepare data for sql
        $strWhere = '';
        $arrFields = StringUtil::trimsplit(',', $this->pdirVehicleFilterFields);

        if (!\is_array($arrFields) && \count($arrFields)) {
            $arrFields[] = '*';
        }

        // Get the selected records
        $strQuery = 'SELECT '.implode(', ', array_map('Database::quoteIdentifier', $arrFields));

        $strQuery .= ' FROM '.$this->strTable;

        if ($this->pdirVehicleFilterWhere) {
            $strWhere .= ' WHERE '.$this->pdirVehicleFilterWhere;
        }

        if ($this->pdirVehicleFilterByType) {
            if ('' !== $strWhere) {
                $strWhere .= " AND type='".$this->pdirVehicleFilterByType."'";
            }

            if ('' === $strWhere) {
                $strWhere .= " WHERE type='".$this->pdirVehicleFilterByType."'";
            }
        }

        if (0 !== $this->pdirVehicleFilterByAccount) {
            if ('' !== $strWhere) {
                $strWhere .= ' AND account='.$this->pdirVehicleFilterByAccount;
            }

            if ('' === $strWhere) {
                $strWhere .= ' WHERE account='.$this->pdirVehicleFilterByAccount;
            }
        }

        $strQuery .= $strWhere;

        // Order by
        if ($this->pdirVehicleFilterSort) {
            $strQuery .= ' ORDER BY '.Database::quoteIdentifier($this->pdirVehicleFilterSort);
        }

        // Limit
        if ($this->pdirVehicleFilterMaxItems) {
            $strQuery .= ' LIMIT '.$this->pdirVehicleFilterMaxItems;
        }

        $objAds = $this->Database->prepare($strQuery)->execute();

        while ($objAds->next()) {
            $this->ads['searchResultItems'][] = $objAds->row();
        }

        // Return if there are no ads
        if (!\is_array($this->ads) || \count($this->ads) < 1) {
            throw new PageNotFoundException('Page not found: '.\Environment::get('uri'));
        }

        return parent::generate();
    }

    public function formatDate($str)
    {
        // validate date
        if($str) {
            if (strpos($str, '-') !== false) {
                // if date is string
                return \Date::parse($GLOBALS['TL_CONFIG']['dateFormat'], strtotime($str));
            } else if(is_numeric($str)) {
                // if date is timestamp
                return \Date::parse($GLOBALS['TL_CONFIG']['dateFormat'], $str);
            } else {
                return $str;
            }
        } else {
            return $GLOBALS['TL_LANG']['pdirMobileDe']['field_keys']['first-registration-no-value'];
        }
    }

    /**
     * Generate module.
     */
    protected function compile()
    {
        $assetsDir = 'web/bundles/pdirmobilede';

        if (!$this->pdir_md_removeModuleJs) {
            $GLOBALS['TL_JAVASCRIPT']['md_js_1'] = $assetsDir.'/js/vehicle_module.min.js|static';
            $GLOBALS['TL_JAVASCRIPT']['md_js_2'] = $assetsDir.'/vendor/isotope/dist/isotope.pkgd.min.js|static';
            $GLOBALS['TL_JAVASCRIPT']['md_js_3'] = $assetsDir.'/js/URI.min.js|static';
        }

        if (!$this->pdir_md_removeModuleCss) {
            $GLOBALS['TL_CSS']['md_css_1'] = $assetsDir.'/vendor/fontello/css/fontello.css||static';
            $GLOBALS['TL_CSS']['md_css_2'] = $assetsDir.'/vendor/fontello/css/animation.css||static';
            $GLOBALS['TL_CSS']['md_css_3'] = $assetsDir.'/css/mobilede_module.css||static';
        }

        // Pagination

        // Limit

        // Promotion
        if (1 === $this->pdir_md_promotion_corner_shadow) {
            $this->pdir_md_promotion_corner_shadow = 'shadow';
        }

        if (1 !== $this->pdir_md_hidePromotionBox && isset($this->ads['prominent'])) {
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
        $this->Template->onlyFilter = $this->pdir_md_only_filter;
        $this->Template->listingPage = $this->pdir_md_listingPage;

        // Filters
        $this->Template->filters = $this->filters;

        if ($this->pdir_md_hideFilters) $this->Template->hideFilters = true;
        if ($this->pdir_open_filter) $this->Template->openFilters = true;

        // Price Slider
        $this->Template->priceSlider = $this->pdir_md_priceSlider;

        // No result message
        $this->Template->noResultMessage = $GLOBALS['TL_LANG']['pdirMobileDe']['field_keys']['noResultMessage'];

        // Debug mode
        if ($this->pdir_md_enableDebugMode) {
            $this->Template->debug = true;
            $this->Template->version = MobileDeSetup::VERSION;
            $this->Template->customer = $this->pdir_md_customer_id;
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
            $images = StringUtil::deserialize($ad['api_images'])['image']['representation'];
            if (\is_array($images) && \count($images) > 0) {
                $objFilterTemplate->imageSrc_S = $images[0]['@url'];
                $objFilterTemplate->imageSrc_XL = $images[1]['@url'];
                $objFilterTemplate->imageSrc_L = $images[3]['@url'];
                $objFilterTemplate->imageSrc_M = $images[4]['@url'];
                $objFilterTemplate->imageSrc_ICON = $images[2]['@url'];
            }

            if ('man' === $ad['type'] || 'sysc' === $ad['type']) {
                $manImages = unserialize($ad['orderSRC']);

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

            if($ad['pseudo_price'] != '' && $ad['pseudo_price'] != 0) {
                $objFilterTemplate->pseudoPrice = \System::getFormattedNumber($ad['pseudo_price'], 2).' '.$ad['price_currency'];
            }

            $objFilterTemplate->link = $this->getReaderPageLink($ad['alias']);
            $objFilterTemplate->fuelType = $GLOBALS['TL_LANG'][$this->strTable]['specifics_fuel']['options'][$ad['specifics_fuel']];
            $objFilterTemplate->transmission = $GLOBALS['TL_LANG'][$this->strTable]['specifics_gearbox']['options'][$ad['specifics_gearbox']];
            $objFilterTemplate->power = $ad['specifics_power'] ? $ad['specifics_power'].' KW ('.number_format((float) ($ad['specifics_power'] * 1.35962), 0, ',', '.').' PS)' : 'Keine Angabe';
            $objFilterTemplate->bodyType = $ad['vehicle_class'];
            $objFilterTemplate->vehicleCategory = $ad['vehicle_category'];
            $objFilterTemplate->vehicle_model = $ad['vehicle_model'];
            $objFilterTemplate->specifics_licensed_weight = $ad['specifics_licensed_weight'];
            $objFilterTemplate->usageType = $GLOBALS['TL_LANG'][$this->strTable]['specifics_usage_type']['options'][$ad['specifics_usage_type']] ?: $ad['specifics_usage_type'];
            $objFilterTemplate->specifics_condition = $GLOBALS['TL_LANG'][$this->strTable]['specifics_condition']['options'][$ad['specifics_condition']];
            $objFilterTemplate->specifics_gearbox = $GLOBALS['TL_LANG'][$this->strTable]['specifics_gearbox']['options'][$ad['specifics_gearbox']];

            $fuelConsumption = [];

            if ($ad['emission_fuel_consumption_co2_emission']) {
                $fuelConsumption[] = [
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_co2_emission'][0],
                    'value' => System::getFormattedNumber($ad['emission_fuel_consumption_co2_emission'], 1),
                ];
            }

            if ($ad['emission_fuel_consumption_inner']) {
                $fuelConsumption[] = [
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_inner'][0],
                    'value' => System::getFormattedNumber($ad['emission_fuel_consumption_inner'], 1),
                ];
            }

            if ($ad['emission_fuel_consumption_outer']) {
                $fuelConsumption[] = [
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_outer'][0],
                    'value' => System::getFormattedNumber($ad['emission_fuel_consumption_outer'], 1),
                ];
            }

            if ($ad['emission_fuel_consumption_combined']) {
                $fuelConsumption[] = [
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_combined'][0],
                    'value' => System::getFormattedNumber($ad['emission_fuel_consumption_combined'], 1),
                ];
            }

            if ($ad['emission_fuel_consumption_petrol_type'] && 'DIESEL' === $ad['emission_fuel_consumption_petrol_type']) {
                $fuelConsumption[] = [
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_petrol_type'][0],
                    'value' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_petrol_type_options'][$ad['emission_fuel_consumption_petrol_type']],
                ];
            }

            if ($ad['emission_fuel_consumption_combined_power_consumption']) {
                $fuelConsumption[] = [
                    'label' => $GLOBALS['TL_LANG'][$this->strTable]['emission_fuel_consumption_combined_power_consumption'][0],
                    'value' => System::getFormattedNumber($ad['emission_fuel_consumption_combined_power_consumption'], 1),
                ];
            }

            $objFilterTemplate->fuelConsumption = $fuelConsumption;

            $objFilterTemplate->featured = ('NONE' === $ad['newnessMarker']) ? false : true;
            $objFilterTemplate->onlyFilter = $this->pdir_md_only_filter;
            $objFilterTemplate->firstRegistration = $this->formatDate($ad['specifics_first_registration']);
            $objFilterTemplate->mileage = $ad['specifics_mileage'] ? System::getFormattedNumber($ad['specifics_mileage'], 0) : 0;
            $objFilterTemplate->filterClasses = $this->getFilterClasses($ad);

            if (!$this->pdir_md_hidePromotionBox) {
                $objFilterTemplate->promotion = true;
            }

            if ($this->featureCss) {
                $objFilterTemplate->featureCss = $this->featureCss;
            }

            // add account
            $objFilterTemplate->account = $ad['account'];

            $objFilterTemplate->rawData = $ad;

            if ($ad['syscara_images_layout']) {
                $groundPlan = unserialize($ad['syscara_images_layout']);
                $objFile = \FilesModel::findByUuid($groundPlan[0]);
                $objFilterTemplate->groundPlan = $objFile->path;
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
        $filter[] = $ad['vehicle_class'];
        $filter[] = str_replace(' ', '_', $ad['vehicle_model']);
        $filter[] = $ad['vehicle_category'];
        $filter[] = $ad['specifics_fuel'];
        $filter[] = $ad['specifics_gearbox'];
        $filter[] = $ad['specifics_usage_type'];
        $filter[] = $ad['specifics_condition'];
        $filter[] = $ad['consumer_price_amount'];
        $filter[] = $ad['syscara_typeof'];
        $filter[] = $ad['specifics_num_seats'];

        $filter = array_filter($filter, 'strlen'); // remove empty fields

        if ($ad['vehicle_make']) {
            $this->filters['make'][$ad['vehicle_make']] = [
                'label' => $ad['vehicle_make'],
                'key' => str_replace(' ', '_', $ad['vehicle_make']),
                'count' => (isset($this->filters['make'][$ad['vehicle_make']]['count']) ? ($this->filters['make'][$ad['vehicle_make']]['count'] + 1) : 2),
            ];
        }

        if ($ad['specifics_exterior_color']) {
            $this->filters['colors'][$ad['specifics_exterior_color']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_exterior_color']['options'][$ad['specifics_exterior_color']],
                'key' => $ad['specifics_exterior_color'],
                'count' => (isset($this->filters['colors'][$ad['specifics_exterior_color']]['count']) ? $this->filters['colors'][$ad['specifics_exterior_color']]['count'] + 1 : 1),
            ];
        }

        if ($ad['vehicle_class']) {
            $this->filters['class'][$ad['vehicle_class']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['vehicle_class']['options'][$ad['vehicle_class']],
                'key' => $ad['vehicle_class'],
                'count' => (isset($this->filters['class'][$ad['vehicle_class']]['count']) ? $this->filters['class'][$ad['vehicle_class']]['count'] + 1 : 1),
            ];
        }

        if ($ad['vehicle_model']) {
            $this->filters['vehicle_model'][$ad['vehicle_model']] = [
                'label' => $ad['vehicle_model'],
                'key' => str_replace(' ', '_', $ad['vehicle_model']),
                'count' => (isset($this->filters['vehicle_model'][$ad['vehicle_model']]['count']) ? $this->filters['vehicle_model'][$ad['vehicle_model']]['count'] + 1 : 1),
            ];
        }

        if ($ad['vehicle_category']) {
            $this->filters['categories'][$ad['vehicle_category']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['vehicle_category']['options'][$ad['vehicle_category']],
                'key' => $ad['vehicle_category'],
                'count' => (isset($this->filters['categories'][$ad['vehicle_category']]['count']) ? $this->filters['categories'][$ad['vehicle_category']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_fuel']) {
            $this->filters['fuelType'][$ad['specifics_fuel']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_fuel']['options'][$ad['specifics_fuel']],
                'key' => $ad['specifics_fuel'],
                'count' => (isset($this->filters['fuelType'][$ad['specifics_fuel']]['count']) ? $this->filters['fuelType'][$ad['specifics_fuel']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_gearbox']) {
            $this->filters['gearbox'][$ad['specifics_gearbox']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_gearbox']['options'][$ad['specifics_gearbox']],
                'key' => $ad['specifics_gearbox'],
                'count' => (isset($this->filters['gearbox'][$ad['specifics_gearbox']]['count']) ? $this->filters['gearbox'][$ad['specifics_gearbox']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_usage_type']) {
            $this->filters['usageType'][$ad['specifics_usage_type']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_usage_type']['options'][$ad['specifics_usage_type']],
                'key' => $ad['specifics_usage_type'],
                'count' => (isset($this->filters['usageType'][$ad['specifics_usage_type']]['count']) ? $this->filters['usageType'][$ad['specifics_usage_type']]['count'] + 1 : 1),
            ];
        }

        if ($ad['specifics_condition']) {
            $this->filters['specifics_condition'][$ad['specifics_condition']] = [
                'label' => $GLOBALS['TL_LANG'][$this->strTable]['specifics_condition']['options'][$ad['specifics_condition']],
                'key' => $ad['specifics_condition'],
                'count' => (isset($this->filters['specifics_condition'][$ad['specifics_condition']]['count']) ? $this->filters['specifics_condition'][$ad['specifics_condition']]['count'] + 1 : 1),
            ];
        }

        if ($ad['consumer_price_amount']) {
            $this->filters['consumer_price_amount'][$ad['consumer_price_amount']] = [
                'label' => $ad['consumer_price_amount'],
                'key' => $ad['consumer_price_amount'],
                'count' => (isset($this->filters['consumer_price_amount'][$ad['consumer_price_amount']]['count']) ? $this->filters['consumer_price_amount'][$ad['consumer_price_amount']]['count'] + 1 : 1),
            ];
        }

        if ($ad['syscara_typeof']) {
            $this->filters['syscara_typeof'][$ad['syscara_typeof']] = [
                'label' => $ad['syscara_typeof'],
                'key' => str_replace(' ', '_', $ad['syscara_typeof']),
            ];
        }

        if ($ad['specifics_num_seats']) {
            $this->filters['specifics_num_seats'][$ad['specifics_num_seats']] = [
                'label' => $ad['specifics_num_seats'],
                'key' => $ad['specifics_num_seats'],
                'count' => (isset($this->filters['specifics_num_seats'][$ad['specifics_num_seats']]['count']) ? $this->filters['specifics_num_seats'][$ad['specifics_num_seats']]['count'] + 1 : 1),
            ];
        }

        return implode(' ', $filter);
    }
}
