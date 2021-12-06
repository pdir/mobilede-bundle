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

$strTable = 'tl_vehicle_account';

$GLOBALS['TL_LANG'][$strTable]['title_legend'] = 'Name und Typ';
$GLOBALS['TL_LANG'][$strTable]['credentials_legend'] = 'Anmeldeinformationen';
$GLOBALS['TL_LANG'][$strTable]['sync_legend'] = 'Automatischer Abgleich';

$GLOBALS['TL_LANG'][$strTable]['description'] = ['Name', 'Gib hier bitte einen Namen zu Unterscheidung der Konten an.'];
$GLOBALS['TL_LANG'][$strTable]['apiType'] = ['API Typ', 'Wähle hier bitte den API Typ der für den Import genutzt werden soll.'];
$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions']['man'] = 'Manuell';
$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions']['mobilede'] = 'MobileDe API Sync';
$GLOBALS['TL_LANG'][$strTable]['api_user_key'] = ['Benutzername','Gib hier den Benutzernamen von deinem API-Konto ein.'];
$GLOBALS['TL_LANG'][$strTable]['api_user_secret'] = ['Passwort','Gib hier das Passwort für dein API-Konto ein.'];
$GLOBALS['TL_LANG'][$strTable]['api_mobilede_customer_number'] = ['Kunden ID','Gib hier deine mobile.de Kunden ID ein.'];
$GLOBALS['TL_LANG'][$strTable]['api_explanation'] = 'Für den mobile.de API Sync benötigst du die <a href="https://pdir.de/contao-produkte/fahrzeugmanager-f%C3%BCr-contao-cms.html">Vollversion des Fahrzeugmanager</a> und die Zugangsdaten der mobile.de API und deine Kunden ID. Du kannst die Kunden ID aus dem Quellcode deiner mobile.de Anbieterseite entnehmen. (Beispiel: https://home.mobile.de/MEINE-FIRMA, Drücke F12 und Suche nach "customerId" im Quellcode).';
$GLOBALS['TL_LANG'][$strTable]['man_explanation'] = 'Für diesen Modus benötigst du keine weiteren Einstellungen, du kannst deine Fahrzeuge einfach über den Fahrzeugmanager manuell pflegen.';
$GLOBALS['TL_LANG'][$strTable]['enabled'] = ['Aktivieren', 'Wenn aktiv, wird dieses Konto im Poor-Man-Cron von Contao automatisch synchronisiert.'];
