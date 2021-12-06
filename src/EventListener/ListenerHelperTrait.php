<?php

declare(strict_types=1);

/*
 * gzm bundle for Contao Open Source CMS
 *
 * Copyright (c) 2021 Markenzoo UG
 * Copyright (c) 2021 pdir / digital agentur // pdir GmbH
 *
 * @package    gzm-bundle
 * @link       https://markenzoo.de
 * @license    proprietary
 * @author     Mathias Arzberger <mathias@markenzoo.de>
 * @author     Christian Mette <christian@markenzoo.de>
 * @author     Markenzoo UG <https://markenzoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\EventListener;

use Markenzoo\GzmBundle\MarkenzooGzmUtils;
use Markenzoo\GzmBundle\Model\AssociationContactModel;
use Pdir\MobileDeBundle\Model\VehicleAccountModel;

trait ListenerHelperTrait
{
    private function buildVehicleAccountOptions():array
    {
        $options = [];
        $options[0] = $GLOBALS['TL_LANG']['pdirMobileDe']['vehicleAccountDefault'];

        $accounts = VehicleAccountModel::findAll();

        if (null !== $accounts) {
            foreach ($accounts as $account) {
                $options[$account->id] = $account->description;
            }
        }

        return $options;
    }
}
