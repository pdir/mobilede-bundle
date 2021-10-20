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

/*
 * Module translation.
 */
$GLOBALS['TL_LANG']['MOD']['pdir'][0] = 'pdir Apps';
$GLOBALS['TL_LANG']['MOD']['mobileDeSetup'][0] = 'Mobile.de Setup';
$GLOBALS['TL_LANG']['MOD']['mobileDeSetup'][1] = 'Here you can manage the Mobile.de App';
$GLOBALS['TL_LANG']['CTE']['mobileDeList'][0] = 'Mobile.de List View';
$GLOBALS['TL_LANG']['CTE']['mobileDeList'][1] = 'Content element to place the Mobile.de list view on the desired page.';
$GLOBALS['TL_LANG']['CTE']['mobileDeReader'][0] = 'Mobile.de Detail View';
$GLOBALS['TL_LANG']['CTE']['mobileDeReader'][1] = 'Content element to place the Mobile.de detail view on the desired page.';
$GLOBALS['TL_LANG']['MOD']['mobileDeAds'] = ['Mobile.de Ads', 'Manage Mobile.de Ads'];

$GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runImport'] = 'Run import';
$GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runDownload'] = 'Import demo data';

$GLOBALS['TL_LANG']['MOD']['vehicle'] = $GLOBALS['TL_LANG']['MOD']['vehicle_show'];
$GLOBALS['TL_LANG']['MOD']['vehicle']['greeting'] = 'Willkommen beim %s Bundle für Contao';
$GLOBALS['TL_LANG']['MOD']['vehicle']['text'] = 'Eine Erweiterung mit Filtern und Funktionen um deinen Fahrzeugbestand auf der eigenen Website anzuzeigen. <br> Die Daten können manuell gepflegt oder aus mobile.de oder SysCara automatisch importiert werden.';
$GLOBALS['TL_LANG']['MOD']['vehicle']['tools'] = 'Tools';
$GLOBALS['TL_LANG']['MOD']['vehicle']['help_h2'] = 'Hilfe & Links';
$GLOBALS['TL_LANG']['MOD']['vehicle']['optionalBundles'] = 'Optionale Erweiterungen';

$GLOBALS['TL_LANG']['MOD']['vehicle']['buttons'] = [
    ['href' => 'contao/main.php?do=vehicleSetup&act=import&ref='.System::getContainer()->get('request_stack')->getCurrentRequest()->get('_contao_referer_id'), 'target' => '_blank', 'alt' => $GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runImport'], 'image' => 'bundles/pdirmobilede/img/icon_index.png'],
    ['href' => 'contao/main.php?do=vehicleSetup&act=download&ref='.System::getContainer()->get('request_stack')->getCurrentRequest()->get('_contao_referer_id'), 'target' => '_blank', 'alt' => $GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runDownload'], 'image' => 'bundles/pdirmobilede/img/icon_download.png'],
];

$GLOBALS['TL_LANG']['MOD']['vehicle']['setupLinks'] = [
    ['href' => 'https://pdir.de/docs/de/contao/extensions/mobilede/', 'target' => '_blank', 'html' => 'Dokumentation'],
    ['href' => 'https://github.com/pdir/mobilede-bundle/issues', 'target' => '_blank', 'html' => 'Probleme melden'],
    ['href' => 'https://github.com/pdir/mobilede-bundle/', 'target' => '_blank', 'html' => 'Github'],
    ['href' => 'https://pdir.de/mobilede.html', 'target' => '_blank', 'html' => 'Demo'],
];

$GLOBALS['TL_LANG']['MOD']['vehicle']['editions']['free'] = [
    'payment' => 'free',
    'product' => 'Free',
    'teaser' => 'All vehicles can be managed directly in the backend',
    //'button_text' => 'jetzt herunterladen',
    'features' => [
        '+list view',
        '+detail view',
        '+image slider',
        '+filter and sort functions',
    ],
];
$GLOBALS['TL_LANG']['MOD']['vehicle']['editions']['mobileDeSync'] = [
    'payment' => 'once, plus VAT',
    'product' => 'mobile.de Sync',
    'teaser' => 'Automate! Import your vehicles via mobile.de API fully automatically.',
    'button_text' => 'buy',
    'features' => [
        '+All functions of the free version',
        '-',
        '*Automatic import',
    ],
];
$GLOBALS['TL_LANG']['MOD']['vehicle']['editions']['sysCaraSync'] = [
    'payment' => 'once, plus VAT',
    'product' => 'SysCara&reg; Sync',
    'teaser' => 'Automate! Import your vehicles from SysCara&reg; API fully automatically.',
    'button_text' => 'buy',
    'features' => [
        '+All functions of the free version',
        '-',
        '*Automatic import',
    ],
];
