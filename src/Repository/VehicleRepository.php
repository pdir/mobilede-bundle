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
use Pdir\MobileDeBundle\Entity\Vehicle;
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
     * @return array<Vehicle>
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
