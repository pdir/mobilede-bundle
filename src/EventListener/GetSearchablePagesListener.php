<?php

declare(strict_types=1);

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2025 pdir / digital agentur // pdir GmbH
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

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Database;
use Contao\Environment;
use Pdir\MobileDeBundle\Model\VehicleModel;

#[AsHook('getSearchablePages')]
class GetSearchablePagesListener
{
    public function __invoke(array $pages, $rootId = 0, bool $isSitemap = false, string $language = null): array
    {
        dump('addVehiclesToSearchIndex');
        dump($pages);

        $vehicles = VehicleModel::findAll();
        $newVehiclePages = [];

        $db = Database::getInstance();
        $result = $db->prepare('SELECT pdir_md_readerPage FROM tl_content WHERE pdir_md_readerPage != ?')->execute(0);

        dump($result);
        $readerPageId = $result->pdir_md_readerPage;

        foreach ($vehicles as $vehicle) {
            $newVehiclePages[] = Environment::get('url').'/'.$this->getReaderPageLink($vehicle->alias, $readerPageId);
        }

        return array_merge($pages, array_unique($newVehiclePages));
    }
}
