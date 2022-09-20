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
use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Contao\Image;
use Contao\StringUtil;
use Contao\System;
use Pdir\MobileDeBundle\Module\MobileDeSetup;
use Pdir\MobileDeSyncBundle\Module\Sync;

class DataContainerListener
{
    use ListenerHelperTrait;

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
     * @Callback(
     *     table="tl_vehicle",
     *     target="list.global_operations.toolbar.button",
     *     priority=1)
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
     *     target="fields.account.options"
     * )
     * builds the gzOwner options
     */
    public function getVehicleVehicleAccountOptions(DataContainer $dc): array
    {
        return $this->buildVehicleAccountOptions();
    }

    /**
     * @Callback(
     *  table="tl_vehicle_account",
     *  target="list.operations.toggle.button",
     *  priority=-11
     * )
     * button_callback: generates a button for the enabled operation
     */
    public function visibleButtonCallback(array $row, ?string $href, string $label, string $title, ?string $icon, string $attributes): string
    {
        // disable the button if the user is not admin or apiType = man
        if (!$this->user->isAdmin || 'man' === $row['apiType']) {
            $title = !$this->user->isAdmin ? $GLOBALS['TL_LANG']['pdirMobileDe']['visibleButtonCallbackAdminOnly'] : $GLOBALS['TL_LANG']['pdirMobileDe']['visibleButtonCallbackUnused'];

            return '<span title="'.$title.'">'.Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).'</span>';
        }

        // build variables
        $published = $row['enabled'] ? 1 : 0;
        $unpublished = $row['enabled'] ? 0 : 1;
        $url = Controller::addToUrl("&amp;tid={$row['id']}&amp;state=$published");
        $icon = 0 === $row['enabled'] ? 'invisible.svg' : $icon;
        $_title = StringUtil::specialchars($title);
        $image = Image::getHtml($icon, $label, "data-state='$unpublished'");

        return "<a href='$url' title='$_title' $attributes>$image</a>";
    }

    /**
     * @Callback(
     *     table="tl_content",
     *     target="fields.pdirVehicleFilterByAccount.options"
     * )
     * builds the account options
     *
     * @param string $strTmpl
     */
    public function getElementsTemplates(DataContainer $dc, $strTmpl = 'list'): array
    {
        return Controller::getTemplateGroup('ce_mobilede_'.$strTmpl);
    }
}
