<?php
/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2018 pdir / digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class AdService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CarService constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Find ad by alias
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
     * Find all ads
     *
     * @return array|\Pdir\MobileDeBundle\Entity\Ad[]
     */
    public function findAll()
    {
        $ads = $this->entityManager->getRepository('PdirMobileDeBundle:Ad')->findAll();

        return $ads;
    }
}
