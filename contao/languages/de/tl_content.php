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
$GLOBALS['TL_LANG']['tl_content']['md_settings_legend'] = 'Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['md_filters_legend'] = 'Filter-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['md_template_legend'] = 'Template-Einstellungen';
$GLOBALS['TL_LANG']['tl_content']['md_debug_legend'] = 'Cache & Debugging';

$GLOBALS['TL_LANG']['tl_content']['pdir_md_readerPage'] = ['Detailansicht', 'Bitte wählen Sie hier die Seite für die Detailansicht aus.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_listingPage'] = ['Listenansicht', 'Wählen Sie hier die Seite für die Listenansicht aus, wenn Sie die Option <strong>Nur Filter</strong> aktiviert haben.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_listTemplate'] = ['Listenansicht Template', 'Bitte wählen Sie hier ein Template für die Listenansicht aus.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_itemTemplate'] = ['Inserat Template', 'Bitte wählen Sie hier das Template für die Darstellung der Inserate.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_hideFilters'] = ['Filter ausblenden', 'Wenn aktiv werden die Filter nicht angezeigt.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_combine_filter'] = ['Filter kombinieren', 'Wenn aktiv werden die Filter miteinander kombiniert, z. B. nur die Fahrzeugmodelle einer Marke angezeigt.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_show_net_price'] = ['Nettopreis anzeigen', 'Wenn aktiv wird der Nettopreis in der Listen- und Detailansicht ausgegeben.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_show_gross_price'] = ['Bruttopreis anzeigen', 'Wenn aktiv wird der Bruttopreis in der Listen- und Detailansicht ausgegeben.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_list_shuffle'] = ['Zufällig anordnen', 'Wenn aktiv werden die Inserate in zufälliger Reihenfolge ausgegeben.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_removeModuleJs'] = ['Javascript auslassen', 'Wenn aktiv wird das moduleigene Javascript ausgelassen.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_removeModuleCss'] = ['Stylesheet auslassen', 'Wenn aktiv wird das moduleigene Stylesheet ausgelassen.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_forceRefresh'] = ['Cache übergehen', 'Inserate direkt von der Mobile.de API laden. (nicht empfohlen)'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_cacheTime'] = ['Cache Zeit', 'Hier kann die Cache Zeit in Minuten angegeben werden. Mobile.de empfiehlt keine Cache Zeiten über 60 min zu verwenden.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_enableDebugMode'] = ['Debug', 'Debug Modus aktivieren, es werden alle verfügbaren Feldschlüssel ausgegeben.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_priceSlider'] = ['Preis-Slider aktivieren', 'Wenn aktiv können Sie den Preis über einen Range Slider filtern lassen.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_powerSlider'] = ['PS-Slider aktivieren', 'Wenn aktiv können Sie den PS-Wert über einen Range Slider filtern lassen.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_mileageSlider'] = ['Kilometerstand-Slider aktivieren', 'Wenn aktiv können Sie den Kilometerstand über einen Range Slider filtern lassen.'];
$GLOBALS['TL_LANG']['tl_content']['pdir_md_only_filter'] = ['Nur Filter', 'Wenn Sie diese Option aktivieren, werden die Objekte ausgeblendet und nur die Filter dargestellt, z. B. um ein Filterformular auf der Startseite zu platzieren.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterByAccount'] = ['Konto der Fahrzeuge', 'Nach welchem Konto soll vorgefiltert werden? (Default: 0 = Alle Konten)'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterFields'] = ['Felder', 'Bitte gib hier eine kommagetrennte Liste der Felder ein, die Sie auflisten möchten oder benutze "*".'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterWhere'] = ['Bedingung', 'Hier kannst du eine Bedingung eingeben, um die Ergebnisse zu filtern (z.B. &lt;em&gt;specifics_gearbox=MANUAL_GEAR&lt;/em&gt; oder &lt;em&gt;vehicle_class!=&quot;Car&quot;&lt;/em&gt;).'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterSearch'] = ['Durchsuchbare Felder', 'Hier können Sie eine kommagetrennte Liste der Felder eingeben, die durchsuchbar sein sollen.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterSort'] = ['Sortieren nach', 'Hier kannst du eine kommagetrennte Liste der Felder eingeben, nach denen die Ergebnisse sortiert werden sollen.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleFilterMaxItems'] = ['Maximale Anzahl', 'Hier kannst du eine maximale Anzahl eingeben, nur so viele Fahrzeuge werden angezeigt. [Verwende "10" für die ersten 10 Fahrzeuge oder "10, 10" für die Fahrzeuge 11-20].'];
$GLOBALS['TL_LANG']['tl_content']['pdir_open_filter'] = ['Filter ausgeklappt anzeigen', 'Aktiviere die Checkbox um alle Filter standardmäßig ausgeklappt anzuzeigen.'];
$GLOBALS['TL_LANG']['tl_content']['pdirVehicleReaderForm'] = ['Kontaktformular', 'Hier können Sie ein Kontaktformular auswählen, was auf der Detailansicht angezeigt wird.'];
