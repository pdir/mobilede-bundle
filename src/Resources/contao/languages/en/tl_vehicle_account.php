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

$GLOBALS['TL_LANG'][$strTable]['title_legend'] = 'Name and type';
$GLOBALS['TL_LANG'][$strTable]['credentials_legend'] = 'Credentials';
$GLOBALS['TL_LANG'][$strTable]['sync_legend'] = 'Automatic sync';

$GLOBALS['TL_LANG'][$strTable]['description'] = ['name', 'Please provide a name here to distinguish accounts.'];
$GLOBALS['TL_LANG'][$strTable]['apiType'] = ['API Type', 'Please select the API type to be used for the import.'];
$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions']['man'] = 'Manual';
$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions']['mobilede'] = 'MobileDe API Sync';
$GLOBALS['TL_LANG'][$strTable]['api_user_key'] = ['username','Enter the username from your API account here.'];
$GLOBALS['TL_LANG'][$strTable]['api_user_secret'] = ['Password','Enter the password for your API account here.'];
$GLOBALS['TL_LANG'][$strTable]['api_mobilede_customer_number'] = ['Customer ID','Enter your mobile.de customer ID here.'];
$GLOBALS['TL_LANG'][$strTable]['api_explanation'] = 'For the mobile.de API Sync you need the <a href="https://pdir.de/contao-produkte/fahrzeugmanager-f%C3%BCr-contao-cms.html">full version of the vehicle manager</a> and the access data of the mobile.de API and your customer ID. You can get the customer ID from the source code of your mobile.de provider page. (Example: https://home.mobile.de/MEINE-FIRMA, press F12 and search for "customerId" in the source code).';
$GLOBALS['TL_LANG'][$strTable]['man_explanation'] = 'For this mode you don\'t need any further settings, you can simply maintain your vehicles manually via the vehicle manager.';
$GLOBALS['TL_LANG'][$strTable]['enabled'] = ['Enable', 'When active, this account will be automatically synchronized in Contao\'s poor-man cron.'];
