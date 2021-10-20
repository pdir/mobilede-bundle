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
$GLOBALS['TL_LANG'][$strTable]['sync_legend'] = 'Automatischer Abgleich';

$GLOBALS['TL_LANG'][$strTable]['description'] = ['Name', 'Gib hier bitte einen Namen zu Unterscheidung der Konten an.'];
$GLOBALS['TL_LANG'][$strTable]['apiType'] = ['API Typ', 'Wähle hier bitte den API Typ der für den Import genutzt werden soll.'];
$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions']['man'] = 'Manuell';
$GLOBALS['TL_LANG'][$strTable]['apiTypeOptions']['mobilede'] = 'MobileDe API Sync';
