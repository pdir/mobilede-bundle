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
 * Add frontend module.
 */

use Contao\ArrayUtil;
use Contao\Combiner;
use Contao\System;
use Pdir\MobileDeBundle\Elements\ListingElement;
use Pdir\MobileDeBundle\Elements\ReaderElement;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Symfony\Component\HttpFoundation\Request;

$assetsDir = 'bundles/pdirmobilede';

/*
 * Add content element.
 */
$GLOBALS['TL_CTE']['includes']['mobileDeList'] = ListingElement::class;
$GLOBALS['TL_CTE']['includes']['mobileDeReader'] = ReaderElement::class;

/*
* Backend modules
*/
if (true !== array_key_exists('pdir', $GLOBALS['BE_MOD'])) {
    ArrayUtil::arrayInsert($GLOBALS['BE_MOD'], 1, ['pdir' => []]);
}

ArrayUtil::arrayInsert($GLOBALS['BE_MOD']['pdir'], 0, [
    'vehicleSetup' => [
        'callback' => MobileDeSetup::class,
    ],
]);

ArrayUtil::arrayInsert($GLOBALS['BE_MOD']['pdir'], 1, [
    'vehicle_show' => [
        'tables' => ['tl_vehicle'],
        'icon' => $assetsDir.'/img/icon.png',
    ],
    'vehicle_accounts' => [
        'tables' => ['tl_vehicle_account'],
        'icon' => $assetsDir.'/img/icon.png',
    ],
]);

ArrayUtil::arrayInsert($GLOBALS['BE_MOD']['pdir'], 0, []);

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_vehicle'] = 'Pdir\MobileDeBundle\Model\VehicleModel';
$GLOBALS['TL_MODELS']['tl_vehicle_account'] = 'Pdir\MobileDeBundle\Model\VehicleAccountModel';

/*
 * Register auto_item
 */
$GLOBALS['TL_AUTO_ITEM'][] = 'ad';

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = ['pdir.mobileDe.listener.hooks', 'parseFrontendTemplate'];
$GLOBALS['TL_HOOKS']['replaceInsertTags'][] = ['pdir.mobileDe.listener.hooks', 'onReplaceInsertTags'];
$GLOBALS['TL_HOOKS']['getSearchablePages'][] = ['pdir.mobileDe.listener.hooks', 'addVehiclesToSearchIndex'];

/*
 * Back end styles & css
 */

if (System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest() ?? Request::create(''))) {
    if (!isset($GLOBALS['TL_JAVASCRIPT'])) {
        $GLOBALS['TL_JAVASCRIPT'] = [];
    }

    $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir.'/js/vehicle_backend.js|static';

    $combiner = new Combiner();
    $combiner->add($assetsDir.'/css/vehicle_backend.scss');
    $GLOBALS['TL_CSS'][] = str_replace('TL_ASSETS_URL', '', $combiner->getCombinedFile());
}
