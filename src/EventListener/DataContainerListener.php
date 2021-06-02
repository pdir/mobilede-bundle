<?php

namespace Pdir\MobileDeBundle\EventListener;

use Contao\Config;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\BackendTemplate;
use Contao\Date;
use Contao\DataContainer;
use Contao\System;
use Contao\Template;
use Pdir\MaklermodulBundle\Maklermodul\ContaoImpl\StaticDIC;
use Pdir\MaklermodulBundle\Model\MaklerModel;
use Pdir\MaklermodulBundle\Module\MaklermodulSetup;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Pdir\MobileDeSyncBundle\Module\Sync;

class DataContainerListener
{
    /**
     * @Callback(table="tl_vehicle", target="list.global_operations.toolbar.button", priority=1)
     */
    public function renderToolbar(): string
    {
        $template = new BackendTemplate('be_vehicle_toolbar');

        System::loadLanguageFile('modules');

        $template->strBundleName = $GLOBALS['TL_LANG']['MOD']['vehicle'][0];
        $template->strBundleGreeting = sprintf($GLOBALS['TL_LANG']['MOD']['vehicle']['greeting'], $template->strBundleName);
        $template->version = MobileDeSetup::VERSION;
        $template->arrButtons = $GLOBALS['TL_LANG']['MOD']['vehicle']['buttons'];
        $template->arrLinks = $GLOBALS['TL_LANG']['MOD']['vehicle']['setupLinks'];
        $template->extMode = MobileDeSetup::MODE;

        if (class_exists('Pdir\MobileDeSyncBundle\Module\Sync'))
        {
            $template->extMode = Sync::MODE;
        }

        $template->arrEditions = [
            'free' => [
                'price' => 0,
            ],
            'mobileDeSync' => [
                'price' => 199,
                'product_link' => 'https://pdir.de/mobile-de-integration-fuer-contao-cms.html',
            ],
            'sysCaraSync' => [
                'price' => 199,
                'product_link' => 'https://pdir.de/mobile-de-integration-fuer-contao-cms.html',
            ]
        ];

        $template->arrLANG = $GLOBALS['TL_LANG']['MOD']['vehicle'];

        return $template->parse();
    }

}
