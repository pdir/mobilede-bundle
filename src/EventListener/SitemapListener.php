<?php

declare(strict_types=1);

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2026 pdir / digital agentur // pdir GmbH
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

use Contao\CoreBundle\Event\ContaoCoreEvents;
use Contao\CoreBundle\Event\SitemapEvent;
use Contao\Database;
use Contao\Environment;
use Pdir\MobileDeBundle\Model\VehicleModel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(ContaoCoreEvents::SITEMAP)]
class SitemapListener
{
    use ListenerHelperTrait;

    public function __invoke(SitemapEvent $event): void
    {
        $vehicles = VehicleModel::findAll();

        if (null === $vehicles) {
            return;
        }

        $db = Database::getInstance();
        $result = $db->prepare('SELECT pdir_md_readerPage, pdirVehicleFilterByAccount FROM tl_content WHERE pdir_md_readerPage != ? AND invisible != ?')->execute(0, 1);

        $readerPageId = $result->pdir_md_readerPage;

        if (null === $readerPageId) {
            return;
        }

        foreach ($vehicles as $vehicle) {
            if (null !== $result->pdirVehicleFilterByAccount && $vehicle->account !== $result->pdirVehicleFilterByAccount) {
                continue;
            }

            $event->addUrlToDefaultUrlSet(Environment::get('url').$this->getReaderPageLink($vehicle->alias, $readerPageId));
        }
    }
}
