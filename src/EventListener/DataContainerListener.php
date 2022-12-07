<?php

declare(strict_types=1);

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 pdir / digital agentur // pdir GmbH
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
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Pdir\MobileDeBundle\Model\VehicleAccountModel;
use Pdir\MobileDeSyncBundle\Module\Sync;

class DataContainerListener
{
    use ListenerHelperTrait;

    /**
     * @var BackendUser|\Contao\User
     */
    private $user;

    /**
     * AssociationContactListener constructor.
     */
    public function __construct()
    {
        $this->user = BackendUser::getInstance();
    }

    /**
     * @Callback(
     *     table="tl_content",
     *     target="fields.pdirVehicleFilterByAccount.options"
     * )
     * builds the account options
     */
    public function getContentVehicleAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions(true);
    }

    /**
     * @Callback(
     *     table="tl_content",
     *     target="fields.pdir_md_listTemplate.options"
     * )
     * builds the list template options
     */
    public function getListTemplates(DataContainer $dc): array
    {
        return $this->getElementsTemplates($dc);
    }

    /**
     * @Callback(
     *     table="tl_content",
     *     target="fields.pdir_md_itemTemplate.options"
     * )
     * builds the item template options
     */
    public function getItemTemplates(DataContainer $dc): array
    {
        return $this->getElementsTemplates($dc, 'item');
    }

    /**
     * Get elements templates
     * @param string $strTmpl
     */
    public function getElementsTemplates(DataContainer $dc, $strTmpl = 'list'): array
    {
        return Controller::getTemplateGroup('ce_mobilede_'.$strTmpl);
    }


    /**
     * @Callback(
     *     table="tl_vehicle",
     *     target="list.global_operations.toolbar.button")
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

    /**
     * @Callback(
     *     table="tl_vehicle",
     *     target="list.label.label"
     * )
     */
    public function listLabel(array $row, string $label, DataContainer $dc, array $arrLabels): array
    {
        $account = VehicleAccountModel::findByPk($row['account']);

        if (null !== $account) {
            $arrLabels[5] = $account->description;
        }

        return $arrLabels;
    }

    /**
     * @Callback(
     *     table="tl_vehicle",
     *     target="fields.account.options"
     * )
     * builds the account options
     */
    public function getVehicleVehicleAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions();
    }

    /**
     * @Callback(
     *  table="tl_vehicle_account",
     *  target="list.operations.toggle.button"
     * )
     * button_callback: generates a button for the enabled operation
     */
    public function visibleButtonCallback(array $row, ?string $href, string $label, string $title, ?string $icon, string $attributes): string
    {

        $security = System::getContainer()->get('security.helper');

        // Contao 5.13 and 5 / Check permissions AFTER checking the tid, so hacking attempts are logged
        if (class_exists(ContaoCorePermissions::class) && !$security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELD_OF_TABLE, 'tl_vehicle_account::enabled'))
        {
            return '';
        }

        // Contao 4.9 / Check the permissions (see #5835)
        if (!class_exists(ContaoCorePermissions::class) && !$this->user->hasAccess('enabled', 'tl_vehicle_account'))
        {
            throw new Contao\CoreBundle\Exception\AccessDeniedException('Not enough permissions to import themes.');
        }

        $href .= '&amp;id=' . $row['id'] . '&amp;rt=' . REQUEST_TOKEN;

        if (!$row['enabled'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="' . Controller::addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.getScrollOffset();return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="' . Image::getPath('visible.svg') . '" data-icon-disabled="' . Image::getPath('invisible.svg') . '" data-state="' . ($row['enabled'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * @Callback(
     *  table="tl_vehicle",
     *  target="list.operations.toggle.button"
     * )
     * button_callback: generates a button for the enabled operation
     */
    public function visibleButtonCallbackVehicles(array $row, ?string $href, string $label, string $title, ?string $icon, string $attributes): string
    {
        $security = System::getContainer()->get('security.helper');

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELD_OF_TABLE, 'tl_vehicle::published'))
        {
            return '';
        }

        $href .= '&amp;id=' . $row['id'] . '&amp;rt=' . REQUEST_TOKEN;;

        if (!$row['published'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="' . Controller::addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.getScrollOffset();return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="' . Image::getPath('visible.svg') . '" data-icon-disabled="' . Image::getPath('invisible.svg') . '" data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * @Callback(
     *     table="tl_content",
     *     target="fields.pdirVehicleFilterByAccount.options"
     * )
     * builds the account options
     */
    public function getVehicleFilterByAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions();
    }
}
