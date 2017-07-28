<?php

/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2017 pdir / digital agentur <develop@pdir.de>
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

array_insert($GLOBALS['BE_MOD']['pdir'], 0, array
(
	'mobileDeSetup' => array
	(
		'callback'          => 'Pdir\MobileDe\MobileDeSetup',
		'icon'              => 'system/modules/pdirMobileDe/assets/img/icon.png',
		//'javascript'        => 'system/modules/pdirMobileDe/assets/js/backend.min.js',
		'stylesheet'		=> 'system/modules/pdirMobileDe/assets/css/backend.css'
	),
));

if (TL_MODE == 'BE')
{
	$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/pdirMobileDe/assets/js/backend.js';
}

/**
 * Register auto_item
 */
$GLOBALS['TL_AUTO_ITEM'][] = 'ad';