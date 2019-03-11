<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2018 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://pdir.de/mobilede.html
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Add frontend module.
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
 * Add content element.
 */
$GLOBALS['TL_CTE']['includes']['mobileDeList'] = 'Pdir\\MobileDeBundle\\Elements\\ListingElement';
$GLOBALS['TL_CTE']['includes']['mobileDeReader'] = 'Pdir\\MobileDeBundle\\Elements\\ReaderElement';

/*
* Backend modules
*/
if (!is_array($GLOBALS['BE_MOD']['pdir'])) {
    array_insert($GLOBALS['BE_MOD'], 1, ['pdir' => []]);
}

$assetsDir = 'bundles/pdirmobilede';

array_insert($GLOBALS['BE_MOD']['pdir'], 1, [
    'mobileDeAds' => [
        'tables' => ['tl_mobile_ad'],
        'icon' => $assetsDir.'/img/icon.png',
        'table' => ['TableWizard', 'importTable'],
        'list' => ['ListWizard', 'importList'],
    ],
    'mobileDeSetup' => [
        'callback' => 'Pdir\\MobileDeBundle\\Module\\MobileDeSetup',
        'icon' => $assetsDir.'/img/icon.png',
    ],
]);

array_insert($GLOBALS['BE_MOD']['pdir'], 0, [
]);

if (TL_MODE === 'BE') {
    $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir.'/js/mobilede_backend.js';
    $GLOBALS['TL_CSS'][] = $assetsDir.'/css/mobilede_backend.css';
}

/*
 * Register auto_item
 */
$GLOBALS['TL_AUTO_ITEM'][] = 'ad';

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = ['pdir.mobileDe.listener.hooks', 'parseFrontendTemplate'];
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['pdir.mobileDe.listener.hooks', 'onReplaceInsertTags'];
