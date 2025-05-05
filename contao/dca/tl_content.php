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

$strTable = 'tl_content';

/*
 * Add palette to tl_content.
 */

$GLOBALS['TL_DCA'][$strTable]['palettes']['mobileDeList'] = '{type_legend},type,headline;{md_settings_legend},pdirVehicleFilterByAccount,pdir_md_listTemplate,pdir_md_itemTemplate,pdir_md_readerPage,pdir_md_listingPage,pdir_md_show_gross_price,pdir_md_show_net_price;{md_filters_legend},pdirVehicleFilterFields,pdirVehicleFilterWhere,pdirVehicleFilterMaxItems,pdirVehicleFilterSort,pdir_md_hideFilters,pdir_open_filter,pdir_md_combine_filter,pdir_md_list_shuffle,pdir_md_priceSlider,pdir_md_powerSlider,pdir_md_mileageSlider,pdir_md_only_filter;{md_template_legend},pdir_md_removeModuleCss,pdir_md_removeModuleJs;{md_debug_legend},pdir_md_enableDebugMode,pdir_md_forceRefresh,pdir_md_cacheTime;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA'][$strTable]['palettes']['mobileDeReader'] = '{type_legend},type,headline;{md_settings_legend},pdirVehicleFilterByAccount,pdir_md_removeModuleCss,pdir_md_removeModuleJs;{md_debug_legend},pdir_md_enableDebugMode;{expert_legend:hide},cssID,space';

/*
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_readerPage'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_readerPage'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => [
        'includeBlankOption' => true,
        'mandatory' => true,
        'tl_class' => 'w50',
        'fieldType' => 'radio',
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_listingPage'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_listingPage'],
    'exclude' => true,
    'inputType' => 'pageTree',
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50',
        'fieldType' => 'radio',
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_listTemplate'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_listTemplate'],
    'exclude' => true,
    'inputType' => 'select',
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50 clr',
    ],
    'sql' => "varchar(32) NOT NULL default '0'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_itemTemplate'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_itemTemplate'],
    'exclude' => true,
    'inputType' => 'select',
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(32) NOT NULL default '0'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_hideFilters'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_hideFilters'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_list_shuffle'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_list_shuffle'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_removeModuleJs'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_removeModuleJs'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_removeModuleCss'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_removeModuleCss'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_forceRefresh'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_forceRefresh'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_cacheTime'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_cacheTime'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_enableDebugMode'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_enableDebugMode'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_priceSlider'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_priceSlider'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_powerSlider'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_powerSlider'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_mileageSlider'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_mileageSlider'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_only_filter'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_only_filter'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default '0'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_open_filter'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_open_filter'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_combine_filter'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_combine_filter'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default '1'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_show_net_price'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_show_net_price'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdir_md_show_gross_price'] = [
    'label' => &$GLOBALS['TL_LANG'][$strTable]['pdir_md_show_gross_price'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 clr',
    ],
    'sql' => "char(1) NOT NULL default '1'",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdirVehicleFilterByAccount'] = [
    'inputType' => 'select',
    'sorting' => true,
    'foreignKey' => 'tl_vehicle_account.description',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => 'int(10) unsigned',
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdirVehicleFilterFields'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdirVehicleFilterWhere'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['preserveTags' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdirVehicleFilterSearch'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdirVehicleFilterSort'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA'][$strTable]['fields']['pdirVehicleFilterMaxItems'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
    'sql' => "varchar(255) NOT NULL default ''",
];
