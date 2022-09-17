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
$GLOBALS['TL_LANG']['MOD']['pdir'][0] = 'pdir Apps';

$GLOBALS['TL_LANG']['CTE']['mobileDeList'][0] = 'Fahrzeugmanager Listenansicht';
$GLOBALS['TL_LANG']['CTE']['mobileDeList'][1] = 'Inhaltelement um die Mobile.de Listenansicht auf der gewünschten Seite zu platzieren.';
$GLOBALS['TL_LANG']['CTE']['mobileDeReader'][0] = 'Fahrzeugmanager Detailansicht';
$GLOBALS['TL_LANG']['CTE']['mobileDeReader'][1] = 'Inhaltselement um die Mobile.de Detailansicht auf der gewünschten Seite zu platzieren.';

$GLOBALS['TL_LANG']['MOD']['vehicle_show'] = ['Fahrzeugmanager', 'Fahrzeuge verwalten'];
$GLOBALS['TL_LANG']['MOD']['vehicle_accounts'] = ['Konten', 'Verwalten der Fahrzeugmanager Konten'];

$GLOBALS['TL_LANG']['MOD']['vehicleSetup'] = ['Fahrzeugmanager Setup', 'Informationen zum Fahrzeugmanager'];
$GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runImport'] = 'Import starten';
$GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runDownload'] = 'Demo Daten importieren';

$GLOBALS['TL_LANG']['MOD']['vehicle'] = $GLOBALS['TL_LANG']['MOD']['vehicle_show'];
$GLOBALS['TL_LANG']['MOD']['vehicle']['greeting'] = 'Willkommen beim %s Bundle für Contao';
$GLOBALS['TL_LANG']['MOD']['vehicle']['text'] = 'Eine Erweiterung mit Filtern und Funktionen um deinen Fahrzeugbestand auf der eigenen Website anzuzeigen. <br> Die Daten können manuell gepflegt oder aus mobile.de oder SysCara&reg; automatisch importiert werden.';
$GLOBALS['TL_LANG']['MOD']['vehicle']['tools'] = 'Tools';
$GLOBALS['TL_LANG']['MOD']['vehicle']['help_h2'] = 'Hilfe & Links';
$GLOBALS['TL_LANG']['MOD']['vehicle']['optionalBundles'] = 'Optionale Erweiterungen';

$GLOBALS['TL_LANG']['MOD']['vehicle']['buttons'] = [
    ['href' => 'contao/main.php?do=vehicleSetup&act=import', 'target' => '_blank', 'alt' => $GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runImport'], 'image' => 'bundles/pdirmobilede/img/icon_index.png'],
    ['href' => 'contao/main.php?do=vehicleSetup&act=download', 'onclick' => "if(!confirm('Should the table really be emptied?'))return false;Backend.getScrollOffset()", 'target' => '_blank', 'alt' => $GLOBALS['TL_LANG']['MOD']['vehicleSetup']['label']['runDownload'], 'image' => 'bundles/pdirmobilede/img/icon_download.png'],
];

$GLOBALS['TL_LANG']['MOD']['vehicle']['setupLinks'] = [
    ['href' => 'https://pdir.de/docs/de/contao/extensions/mobilede/', 'target' => '_blank', 'html' => 'Dokumentation'],
    ['href' => 'https://github.com/pdir/mobilede-bundle/issues', 'target' => '_blank', 'html' => 'Probleme melden'],
    ['href' => 'https://github.com/pdir/mobilede-bundle/', 'target' => '_blank', 'html' => 'Github'],
    ['href' => 'https://pdir.de/mobilede.html', 'target' => '_blank', 'html' => 'Demo'],
];

$GLOBALS['TL_LANG']['MOD']['vehicle']['editions']['free'] = [
    'payment' => 'kostenlos',
    'product' => 'Kostenlos',
    'teaser' => 'Alle Fahrzeuge können im Backend direkt verwaltet werden.',
    //'button_text' => 'jetzt herunterladen',
    'features' => [
        '+Listenansicht',
        '+Detailansicht',
        '+Bildslider',
        '+Filter- und Sortierungsfunktionen',
    ],
];
$GLOBALS['TL_LANG']['MOD']['vehicle']['editions']['mobileDeSync'] = [
    'payment' => 'einmalig, plus MwSt.',
    'product' => 'mobile.de Sync',
    'teaser' => 'Automatischer Abgleich der Fahrzeuge über mobile.de Plattform via API.',
    'button_text' => 'Kaufen',
    'features' => [
        '+Alle funktionen der kostenlosen Version',
        '-',
        '*Automatischer Import',
    ],
];
$GLOBALS['TL_LANG']['MOD']['vehicle']['editions']['sysCaraSync'] = [
    'payment' => 'einmalig, plus MwSt.',
    'product' => 'SysCara&reg; Sync',
    'teaser' => "Automatischer Abgleich der Fahrzeuge aus SysCara&reg; Plattform per XML Import'.",
    'button_text' => 'Kaufen',
    'features' => [
        '+Alle funktionen der kostenlosen Version',
        '-',
        '*Automatischer Import',
    ],
];
