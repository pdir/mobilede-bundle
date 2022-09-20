<?php

declare(strict_types=1);

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

/*
 * Module translation.
 */
$GLOBALS['TL_LANG']['tl_content']['md_settings_legend'] = 'Settings';
$GLOBALS['TL_LANG']['tl_content']['md_filters_legend'] = 'Filter Settings';
$GLOBALS['TL_LANG']['tl_content']['md_template_legend'] = 'Template Settings';
$GLOBALS['TL_LANG']['tl_content']['md_debug_legend'] = 'Cache & Debugging';

$GLOBALS['TL_LANG']['tl_content']['pdir_md_readerPage'] = ['Detail View', 'Please choose here the page for the detail view.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_listingPage'] = ['Listing View', 'Please choose here the page for the listing view, if the <strong>Only Filter</strong> option is active.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_listTemplate'] = ['List View Template', 'Please choose here the template for the list view.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_itemTemplate'] = ['Advertisement Template', 'Please choose here the template for the presentation of the advertisements.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_hideFilters'] = ['Hide Filters', 'If active the filters will not be shown.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_list_shuffle'] = ['Randomly Order', 'If active the advertisements will be shown in an randomly order.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_removeModuleJs'] = ['Skip JavaScript', 'If active the module javascript is not included.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_removeModuleCss'] = ['Skip Stylesheets', 'If active the module stylesheets will not included.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_forceRefresh'] = ['Skip Cache', 'Load advertisements directly from the Mobile.de API (not recommended)'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_cacheTime'] = ['Cache Time', 'Here you can choose the cache time in minutes. Mobile.de does not recommend times under 60 minutes.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_enableDebugMode'] = ['Debug', 'If active, all available field keys are shown.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_priceSlider'] = ['Activate Price Slider', 'If active you can filter the price with a range slider.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_powerSlider'] = ['Activate Power Slider', 'If active you can filter the power with a range slider.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_mileageSlider'] = ['Activate Mileage Slider', 'If active you can filter the mileage with a range slider.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_only_filter'] = ['Only Filter', 'If active the objects are not shown and only the filter form is displayed.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleAccount'] = ['Vehicle import account', 'Here you can assign an ID for the import account. Default: 0 (only necessary for several import accounts)'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_cronPoorMan'] = ['Activate poor man cron', 'Here you can enable the import via Contao poor man cron. (hourly)'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterByAccount'] = ['Vehicle account', 'Which account should be pre-filtered for? (Default: 0 = all accounts)'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterByTypeOptions']['man'] = 'manually';
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterByTypeOptions']['sync'] = 'API';
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterFields'] = ['Fields', 'Please enter a comma separated list of the fields you want to list or use "*".'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterWhere'] = ['Condition', 'Hier können Sie eine Bedingung eingeben, um die Ergebnisse zu filtern (z.B. &lt;em&gt;specifics_gearbox=MANUAL_GEAR&lt;/em&gt; oder &lt;em&gt;vehicle_class!=&quot;Car&quot;&lt;/em&gt;).'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterSearch'] = ['Searchable fields', 'Here you can enter a comma separated list of fields that you want to be searchable.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterSort'] = ['Order by', 'Here you can enter a comma separated list of fields to sort the results by.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterMaxItems'] = ['Maximum number', 'Here you can enter a maximum number, only so many vehicles will be displayed. [Use "10" for the first 10 vehicles or "10, 10" for vehicle 11-20.]'];
$GLOBALS['TL_LANG']['tl_content']['pdir_open_filter'] = ['Show filter unfolded', 'Activate the checkbox to show all filters expanded by default.'];
