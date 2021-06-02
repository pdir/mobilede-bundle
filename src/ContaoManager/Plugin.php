<?php

namespace Pdir\MobileDeBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Pdir\MobileDeBundle\PdirMobileDeBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(PdirMobileDeBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['pdirMobileDe']),
        ];
    }
}
