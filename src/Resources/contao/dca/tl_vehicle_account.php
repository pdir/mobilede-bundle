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

use Contao\DataContainer;
use Pdir\MobileDeBundle\EventListener\DataContainerListener;

$strTable = 'tl_vehicle_account';

$GLOBALS['TL_DCA'][$strTable] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],

    // List
    'list' => [
        'sorting' => [
            'mode' => 2,
            'fields' => ['description'],
            'flag' => 1,
            'panelLayout' => 'sort,search,limit',
        ],
        'label' => [
            'fields' => ['description', 'id'],
        ],
        'global_operations' => [],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.svg',
            ],
            'toggle' => [
                'label' => &$GLOBALS['TL_LANG'][$strTable]['enable'],
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'icon' => 'visible.svg',
                'showInHeader' => true,
            ],
        ],
    ],

    // Select
    'select' => [
        'buttons_callback' => [],
    ],

    // Edit
    'edit' => [
        'buttons_callback' => [],
    ],

    // Palettes
    'palettes' => [
        '__selector__' => ['apiType'],
        'default' => '{title_legend},description,apiType',
    ],

    // Subpalettes
    'subpalettes' => [
        'apiType_man' => 'man_explanation',
        'apiType_mobilede' => '{credentials_legend},api_explanation,api_user_key,api_user_secret,api_mobilede_customer_number;'.
            '{sync_legend},enabled;',
        'apiType_convertTo' => '{convertTo_legend};',
    ],

    // Fields
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'description' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'unique' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'apiType' => [
            'exclude' => true,
            'inputType' => 'select',
            'options' => &$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions'],
            'eval' => ['includeBlankOption' => true, 'tl_class' => 'w50'],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'api_explanation' => [
            'exclude' => true,
            'input_field_callback' => static function (DataContainer $dc) {
                return sprintf(
                    '<div class="widget" style="margin-top:15px;"><p class="tl_info">%s</p></div>',
                    $GLOBALS['TL_LANG']['tl_vehicle_account']['api_explanation']
                );
            },
        ],
        'man_explanation' => [
            'exclude' => true,
            'input_field_callback' => static function (DataContainer $dce) {
                return sprintf(
                    '<div class="widget" style="margin-top:15px;"><p class="tl_info">%s</p></div>',
                    $GLOBALS['TL_LANG']['tl_vehicle_account']['man_explanation']
                );
            },
        ],
        'api_user_key' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'preserveTags' => true],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'api_user_secret' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'preserveTags' => true],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'api_mobilede_customer_number' => [
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50', 'preserveTags' => true],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'enabled' => [
            'exclude' => true,
            'toggle' => true,
            'filter' => true,
            'inputType' => 'checkbox',
            'eval' => ['doNotCopy' => true],
            'sql' => "char(1) NOT NULL default ''"
        ],
    ],
];
