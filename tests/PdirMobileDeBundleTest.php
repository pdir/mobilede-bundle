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

namespace Pdir\MobileDeBundle\Tests;

use Contao\TestCase\ContaoTestCase;
use Pdir\MobileDeBundle\DependencyInjection\PdirMobileDeExtension;
use Pdir\MobileDeBundle\PdirMobileDeBundle;

class PdirMobileDeBundleTest extends ContaoTestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new PdirMobileDeBundle();
        $this->assertInstanceOf(PdirMobileDeBundle::class, $bundle);
    }

    public function testGetContainerExtension(): void
    {
        $bundle = new PdirMobileDeBundle();
        $this->assertInstanceOf(PdirMobileDeExtension::class, $bundle->getContainerExtension());
    }
}
