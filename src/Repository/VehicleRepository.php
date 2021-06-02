<?php

declare(strict_types=1);

namespace Pdir\MobileDeBundle\Repository;

use Pdir\MobileDeBundle\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findByIdOrName(string $identifier): ?Vehicle
    {
        /** @var Vehicle $vehicle */
        $vehicle = $this->findOneBy(['mobilede_id' => $identifier]);

        if (null === $vehicle) {
            $vehicle = $this->findOneBy(['name' => $identifier]);
        }

        return $vehicle;
    }

    /**
     * @return Vehicle[]
     */

    public function findByAccount(VehicleAccount $vehicleAccount, int $maxResults = 0): array
    {
        $queryBuilder = $this->createQueryBuilder('v')
            ->andWhere('v.account = :account')
            ->setParameter('account', $vehicleAccount)
            ->orderBy('v.modifiedAt', 'DESC')
        ;

        $vehicles = $queryBuilder
            ->getQuery()
            ->getResult()
        ;

        if ($maxResults > 0) {
            $vehicles = \array_slice($vehicles, 0, $maxResults);
        }

        return $vehicles;
    }
}
