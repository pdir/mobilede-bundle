<?php

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
use Contao\Database;
use Contao\DataContainer;
use Contao\Image;
use Contao\Input;
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
     *     table="tl_content",
     *     target="fields.pdirVehicleFilterByAccount.options"
     * )
     * builds the account options
     *
     * @return array
     */
    public function getContentVehicleAccountOptions(DataContainer $dc)
    {
        return $this->buildVehicleAccountOptions(true);
    }

    /**
     * @Callback(
     *     table="tl_vehicle",
     *     target="fields.account.options"
     * )
     * builds the gzOwner options
     *
     * @return array
     */
    public function getVehicleVehicleAccountOptions(DataContainer $dc)
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
        $security = System::getContainer()->get('security.helper');

        // disable the button if the user has no access or apiType = man
        if (!$security->isGranted(ContaoCorePermissions::USER_CAN_EDIT_FIELD_OF_TABLE, 'tl_vehicle_account::enabled') ||
            'man' === $row['apiType']
        ) {
            $title = 'man' === $row['apiType'] ? $GLOBALS['TL_LANG']['pdirMobileDe']['visibleButtonCallbackUnused']: $GLOBALS['TL_LANG']['pdirMobileDe']['visibleButtonCallbackAdminOnly'];

            return '<span title="'.$title.'">'.Image::getHtml(preg_replace('/\.svg$/i', '_.svg', $icon)).'</span>';
        }

        // toggle visibility
        if (strlen(Input::get('state'))) {
            $this->toggleVisibility($row['id'], (Input::get('state')));
            Controller::redirect(Controller::getReferer());
        }

        $href .= '&amp;state=' . ($row['enabled'] ? 1 : 0) . '&amp;id=' . $row['id'] . '&amp;rt=' . REQUEST_TOKEN;

        if (!$row['enabled'])
        {
            $icon = 'invisible.svg';
        }

        return '<a href="' . Controller::addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.getScrollOffset();return AjaxRequest.toggleField(this,true)">' . Image::getHtml($icon, $label, 'data-icon="' . Image::getPath('visible.svg') . '" data-icon-disabled="' . Image::getPath('invisible.svg') . '" data-state="' . ($row['enabled'] ? 1 : 0) . '"') . '</a> ';
    }

    /**
     * Disable/enable a vehicle account
     *
     * @param integer $intId
     * @param boolean $blnVisible
     * @param DataContainer $dc
     */
    public function toggleVisibility(int $intId, bool $blnVisible)
    {
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        // Update the database
        Database::getInstance()->prepare("UPDATE tl_vehicle_account SET tstamp=". time() .", enabled='" . ($blnVisible ? '' : 1) . "' WHERE id=?")
            ->execute($intId);
    }
}
