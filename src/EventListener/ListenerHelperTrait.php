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

namespace Pdir\MobileDeBundle\EventListener;

use Pdir\MobileDeBundle\Model\VehicleAccountModel;

trait ListenerHelperTrait
{
    private function buildVehicleAccountOptions($default = false): array
    {
        $options = [];

        if ($default) {
            $options[0] = $GLOBALS['TL_LANG']['pdirMobileDe']['vehicleAccountDefault'];
        }

        $accounts = VehicleAccountModel::findAll();

        if (null !== $accounts) {
            foreach ($accounts as $account) {
                $options[$account->id] = $account->description;
            }
        }

        return $options;
    }
}
