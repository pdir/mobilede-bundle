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

namespace Pdir\MobileDeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pdir\MobileDeBundle\Entity\VehicleAccount;
use Symfony\Bridge\Doctrine\RegistryInterface;

class VehicleAccountRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VehicleAccount::class);
    }

    public function findByIdOrDescription(string $identifier): ?VehicleAccount
    {
        /** @var VehicleAccount $vehicleAccount */
        $vehicleAccount = $this->findOneBy(['id' => $identifier]);

        if (null === $vehicleAccount) {
            $vehicleAccount = $this->findOneBy(['description' => $identifier]);
        }

        return $vehicleAccount;
    }
}
