<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2018 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://www.maklermodul.de
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Tests;

use Contao\TestCase\ContaoTestCase;
use Pdir\MobileDeBundle\DependencyInjection\MobileDeExtension;
use Pdir\MobileDeBundle\PdirMobileDeBundle;

class PdirMobileDeBundleTest extends ContaoTestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new PdirMobileDeBundle();
        $this->assertInstanceOf(PdirMobileDeBundle::class, $bundle);
    }

    public function testGetContainerExtension()
    {
        $bundle = new PdirMaklermodulBundle();
        $this->assertInstanceOf(MobileDeExtension::class, $bundle->getContainerExtension());
    }
}
