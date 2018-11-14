<?php

/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2018 pdir/ digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Add frontend module
 */
/*
array_insert($GLOBALS['FE_MOD'], 2, array
(
    'pdirMobileDe' => array
    (
        'PdirMobileDeList'    => '\Pdir\MobileDeBundle\Listing',
        'PdirMobileDeReader'  => '\Pdir\MobileDeBundle\Reader',
    )
));*/

/**
 * Add content element
 */
$GLOBALS['TL_CTE']['includes']['mobileDeList'] = 'Pdir\\MobileDeBundle\\Elements\\ListingElement';
$GLOBALS['TL_CTE']['includes']['mobileDeReader'] = 'Pdir\\MobileDeBundle\\Elements\\ReaderElement';

/**
* Backend modules
*/
if (!is_array($GLOBALS['BE_MOD']['pdir']))
{
	array_insert($GLOBALS['BE_MOD'], 1, array('pdir' => array()));
}

$assetsDir = 'bundles/pdirmobilede';

array_insert($GLOBALS['BE_MOD']['pdir'], 1, array
(
    'mobileDeAds'  => [
        'tables'    => ['tl_mobile_ad'],
        'icon'      => $assetsDir . '/img/icon.png',
        'table'     => ['TableWizard', 'importTable'],
        'list'      => ['ListWizard', 'importList']
    ],
    'mobileDeSetup' => array
	(
		'callback'          => 'Pdir\\MobileDeBundle\\Modules\\MobileDeSetup',
		'icon'              => $assetsDir . '/img/icon.png',
	),
));

array_insert($GLOBALS['BE_MOD']['pdir'], 0 ,[

]);

if (TL_MODE == 'BE')
{
	$GLOBALS['TL_JAVASCRIPT'][] =  $assetsDir . '/js/backend.js';
    $GLOBALS['TL_CSS'][] = $assetsDir . '/css/backend.css';
}

/**
 * Register auto_item
 */
$GLOBALS['TL_AUTO_ITEM'][] = 'ad';
