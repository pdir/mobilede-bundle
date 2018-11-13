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
        'PdirMobileDeList'    => '\Pdir\MobileDe\Listing',
        'PdirMobileDeReader'  => '\Pdir\MobileDe\Reader',
    )
));*/

/**
 * Add content element
 */
$GLOBALS['TL_CTE']['includes']['mobileDeList'] = 'Pdir\\MobileDe\\ListingElement';
$GLOBALS['TL_CTE']['includes']['mobileDeReader'] = 'Pdir\\MobileDe\\ReaderElement';

/**
* Backend modules
*/
if (!is_array($GLOBALS['BE_MOD']['pdir']))
{
	array_insert($GLOBALS['BE_MOD'], 1, array('pdir' => array()));
}

$assetsDir = 'bundles/pdirmobilede';

array_insert($GLOBALS['BE_MOD']['pdir'], 0, array
(
	'mobileDeSetup' => array
	(
		'callback'          => 'Pdir\MobileDe\MobileDeSetup',
		'icon'              => $assetsDir . '/img/icon.png',
		//'javascript'        =>  $assetsDir . '/js/backend.min.js',
		'stylesheet'		=>  $assetsDir . '/css/backend.css'
	),
));

array_insert($GLOBALS['BE_MOD']['pdir'], 1 ,[
    'mobileDeAds'  => [
        'tables'    => ['tl_mobile_ad'],
        'icon'      => $assetsDir . '/img/icon.png',
        'table'     => ['TableWizard', 'importTable'],
        'list'      => ['ListWizard', 'importList']
    ]
]);

if (TL_MODE == 'BE')
{
	$GLOBALS['TL_JAVASCRIPT'][] =  $assetsDir . '/js/backend.js';
}

/**
 * Register auto_item
 */
$GLOBALS['TL_AUTO_ITEM'][] = 'ad';
