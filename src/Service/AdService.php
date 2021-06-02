<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2021 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://pdir.de/mobilede.html
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Service;

use Doctrine\ORM\EntityManager;

class AdService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CarService constructor.
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find ad by alias.
     *
     * @param $alias
     *
     * @return array|\Pdir\MobileDeBundle\Entity\Ad[]
     */
    public function findByAlias($alias)
    {
        $ads = $this->entityManager->getRepository('PdirMobileDeBundle:Ad')->findBy(['alias' => $alias]);

        return $ads;
    }

    /**
     * Find all ads.
     *
     * @return array|\Pdir\MobileDeBundle\Entity\Ad[]
     */
    public function findAll()
    {
        $ads = $this->entityManager->getRepository('PdirMobileDeBundle:Ad')->findAll();

        return $ads;
    }
}
