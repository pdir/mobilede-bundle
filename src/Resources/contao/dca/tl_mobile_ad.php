<?php

$GLOBALS['TL_DCA']['tl_mobile_ad'] = [
    'config' => [
        'dataContainer' => 'Table',
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ]
        ]
    ],
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['name'],
            'headerFields' => ['name'],
            'flag' => 1,
            'panelLayout' => 'debug;filter;sort,search,limit',
        ],
        'label' => [
            'fields' => ['name'],
            'format' => '%s',
            'showColumns' => true,
        ],
        'global_operations' => [
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['edit'],
                'href' => 'table=tl_mobile_ad',
                'icon' => 'edit.gif'
            ],
            'editheader' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['editheader'],
                'href' => 'act=edit',
                'icon' => 'header.gif',
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif',
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif'
            ]
        ]
    ],
    'palettes' => [
        '__selector__' => [],
        'default' => 'name,alias,type,price,brand'
    ],
    'subpalettes' => [
        '' => ''
    ],
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'name' => [
            'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['name'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'flag' => 1,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'brand' => [
            'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['brand'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'flag' => 1,
            'inputType' => 'text',
            'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql' => "varchar(255) NOT NULL default ''"
        ],
        'alias' => [
            'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['alias'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['rgxp' => 'alias', 'unique' => true, 'maxlength' => 128, 'tl_class' => 'w50'],
            'save_callback' => [
                function ($varValue, DataContainer $dataContainer) {
                    return \System::getContainer()->get('pdir.mobile_de.ad_service')->generateAlias($varValue, $dataContainer);
                }
            ],
            'sql' => "varchar(128) COLLATE utf8_bin NOT NULL default ''"
        ],
        'price' => array
        (
            'label'  => &$GLOBALS['TL_LANG']['tl_mobile_ad']['price'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => array('maxlength'=>13, 'rgxp'=>'digit', 'tl_class' => 'w50'),
            'sql' => "float(10,2) NOT NULL default '0.00'"
        ),
        'type' => [
            'label' => &$GLOBALS['TL_LANG']['tl_mobile_ad']['type'],
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'inputType' => 'select',
            'options' => $GLOBALS['TL_LANG']['tl_mobile_ad']['type']['options'],
            'eval' => array(
                'includeBlankOption'=>false,
                'tl_class'=>'w50',
                'readonly'=> true
            ),
            'save_callback' => [
                function ($varValue, DataContainer $dataContainer) {
                    return \System::getContainer()->get('pdir.mobile_de.ad_service')->generateAlias($varValue, $dataContainer);
                }
            ],
            'sql' => "varchar(4) NOT NULL default 'man'"
        ],
    ]
];
