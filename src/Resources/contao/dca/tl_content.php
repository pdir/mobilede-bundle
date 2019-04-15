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

/**
 * Add palette to tl_content.
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['mobileDeList'] = '{type_legend},type,headline;{md_settings_legend},pdir_md_customer_username,pdir_md_customer_password,pdir_md_customer_id,pdir_md_cronPoorMan,pdir_md_hidePromotionBox,pdir_md_listTemplate,pdir_md_itemTemplate,pdir_md_readerPage;{md_filters_legend},pdir_md_hideFilters,pdir_md_list_shuffle,pdir_md_priceSlider,pdir_md_powerSlider,pdir_md_mileageSlider;{md_template_legend},pdir_md_promotion_corner_position,pdir_md_promotion_corner_color,pdir_md_promotion_corner_shadow,pdir_md_corner_position,pdir_md_corner_color,pdir_md_corner_shadow,pdir_md_removeModuleCss,pdir_md_removeModuleJs;{md_debug_legend},pdir_md_forceRefresh,pdir_md_cacheTime,pdir_md_enableDebugMode;{expert_legend:hide},cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['mobileDeReader'] = '{type_legend},type,headline;{md_settings_legend},pdir_md_customer_username,pdir_md_customer_password,pdir_md_customer_id,pdir_md_hidePromotionBox,pdir_md_corner_position,pdir_md_corner_color,pdir_md_corner_shadow,pdir_md_removeModuleCss,pdir_md_removeModuleJs;{md_debug_legend},pdir_md_enableDebugMode;{expert_legend:hide},cssID,space';

/*
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_readerPage'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_readerPage'],
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

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_listTemplate'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_listTemplate'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['pdir_md_content', 'getListTemplates'],
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50 clr',
    ],
    'sql' => "varchar(32) NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_itemTemplate'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_itemTemplate'],
    'exclude' => true,
    'inputType' => 'select',
    'options_callback' => ['pdir_md_content', 'getItemTemplates'],
    'reference' => &$GLOBALS['TL_LANG']['tl_module'],
    'eval' => [
        'includeBlankOption' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(32) NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_customer_id'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_customer_id'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50',
        'decodeEntities' => true,
    ],
    'sql' => "varchar(64) NOT NULL default 'demo'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_hidePromotionBox'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_hidePromotionBox'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_hideFilters'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_hideFilters'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_list_shuffle'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_list_shuffle'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_corner_color'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => [
        'white' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_white'],
        'black' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_black'],
        'grey' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_grey'],
        'blue' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_blue'],
        'green' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_green'],
        'turquoise' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_turquoise'],
        'purple' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_purple'],
        'red' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_red'],
        'orange' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_orange'],
        'yellow' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_color_yellow'],
    ],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_promotion_corner_color'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_promotion_corner_color'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_corner_color']['options'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_corner_position'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_position'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => [
        'top-left' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_position_top_left'],
        'top-right' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_position_top_right'],
        'bottom-left' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_position_bottom_left'],
        'bottom-right' => $GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_position_bottom_right'],
    ],
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_promotion_corner_position'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_promotion_corner_position'],
    'exclude' => true,
    'inputType' => 'select',
    'options' => $GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_corner_position']['options'],
    'eval' => ['tl_class' => 'w50 clr'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_promotion_corner_shadow'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_promotion_corner_shadow'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_corner_shadow'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_corner_shadow'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'm12 clr',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_removeModuleJs'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_removeModuleJs'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_removeModuleCss'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_removeModuleCss'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_forceRefresh'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_forceRefresh'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_cacheTime'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_cacheTime'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "int(10) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_enableDebugMode'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_enableDebugMode'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_customer_username'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_customer_username'],
    'exclude' => true,
    'search' => true,
    'sorting' => true,
    'flag' => 1,
    'inputType' => 'text',
    'eval' => [
        'mandatory' => true,
        'rgxp' => 'extnd',
        'nospace' => true,
        'maxlength' => 64,
        'tl_class' => 'w50 m12', ],
    'sql' => "varchar(64) NOT NULL default 'demo'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_customer_password'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_customer_password'],
    'exclude' => true,
    'inputType' => 'text',
    'eval' => [
        'mandatory' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "varchar(128) NOT NULL default 'demo'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_priceSlider'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_priceSlider'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_powerSlider'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_powerSlider'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_mileageSlider'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_mileageSlider'],
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'submitOnChange' => true,
        'tl_class' => 'w50',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['pdir_md_cronPoorMan'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['pdir_md_cronPoorMan'],
    'exclude' => true,
    'filter' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'doNotCopy' => true,
        'tl_class' => 'w50 m12',
    ],
    'sql' => "char(1) NOT NULL default ''",
];

class pdir_md_content extends Backend
{
    public function getListTemplates(DataContainer $dc)
    {
        return $this->getElementsTemplates($dc);
    }

    public function getItemTemplates(DataContainer $dc)
    {
        return $this->getElementsTemplates($dc, 'item');
    }

    private function getElementsTemplates(DataContainer $dc, $strTmpl = 'list')
    {
        return $this->getTemplateGroup('ce_mobilede_'.$strTmpl);
        if (version_compare(VERSION.BUILD, '2.9.0', '>=')) {
            return $this->getTemplateGroup('ce_mobilede_'.$strTmpl, $dc->activeRecord->pid);
        }
    }
}
