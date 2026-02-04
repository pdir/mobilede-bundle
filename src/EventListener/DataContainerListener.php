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

use Contao\BackendTemplate;
use Contao\BackendUser;
use Contao\Controller;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\DataContainer;
use Contao\Frontend;
use Contao\Image;
use Contao\StringUtil;
use Contao\System;
use Contao\User;
use Pdir\MobileDeBundle\Model\VehicleAccountModel;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Pdir\MobileDeSyncBundle\Module\Sync;

class DataContainerListener
{
    use ListenerHelperTrait;

    /**
     * @var BackendUser|User
     */
    private $user;

    /**
     * AssociationContactListener constructor.
     */
    public function __construct()
    {
        $this->user = BackendUser::getInstance();
        $this->requestToken = System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue();
    }

    /**
     * builds the account options
     */
    #[AsCallback(table: 'tl_content', target: 'fields.pdirVehicleFilterByAccount.options')]
    public function getContentVehicleAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions(true);
    }

    /**
     * builds the list template options
     */
    #[AsCallback(table: 'tl_content', target: 'fields.pdir_md_listTemplate.options')]
    public function getListTemplates(DataContainer $dc): array
    {
        return $this->getElementsTemplates($dc);
    }

    /**
     * builds the item template options
     */
    #[AsCallback(table: 'tl_content', target: 'fields.pdir_md_itemTemplate.options')]
    public function getItemTemplates(DataContainer $dc): array
    {
        return $this->getElementsTemplates($dc, 'item');
    }

    /**
     * Get elements templates.
     *
     * @param string $strTmpl
     */
    public function getElementsTemplates(DataContainer $dc, $strTmpl = 'list'): array
    {
        return Controller::getTemplateGroup('ce_mobilede_'.$strTmpl);
    }

    #[AsCallback(table: 'tl_vehicle', target: 'list.global_operations.toolbar.button')]
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

        if (class_exists('Pdir\MobileDeSyncBundle\Module\Sync')) {
            $template->extMode = Sync::MODE;
            $template->syncVersion = Sync::SYNC_VERSION;
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
            ],
        ];

        $template->arrLANG = $GLOBALS['TL_LANG']['MOD']['vehicle'];

        return $template->parse();
    }

    #[AsCallback(table: 'tl_vehicle', target: 'list.label.label')]
    public function listLabel(array $row, string $label, DataContainer $dc, array $arrLabels): array
    {
        $account = VehicleAccountModel::findByPk($row['account']);

        if (null !== $account) {
            $arrLabels[5] = $account->description;
        }

        return $arrLabels;
    }

    /**
     * builds the account options
     */
    #[AsCallback(table: 'tl_vehicle', target: 'fields.account.options')]
    public function getVehicleVehicleAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions();
    }

    /**
     * builds the account options
     */
    #[AsCallback(table: 'tl_content', target: 'fields.pdirVehicleFilterByAccount.options')]
    public function getVehicleFilterByAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions();
    }
}
