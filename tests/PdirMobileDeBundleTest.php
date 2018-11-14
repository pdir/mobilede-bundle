<?php
/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2018 pdir/ digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Tests;

use Contao\SkeletonBundle\ContaoSkeletonBundle;
use PHPUnit\Framework\TestCase;

class PdirMobileDeBundleTest extends TestCase
{
    public function testCanBeInstantiated()
    {
        $bundle = new PdirMobileDeBundle();
        $this->assertInstanceOf('Pdir\MobileDeBundle\PdirMobileDeBundle', $bundle);
    }
}
