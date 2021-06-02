<?php

declare(strict_types=1);

namespace Pdir\MobileDeBundle\Repository;

use Pdir\MobileDeBundle\Entity\VehicleAccount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
