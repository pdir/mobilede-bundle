<?php
/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2018 pdir / digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Dca;

use Contao\Backend;
use Contao\DataContainer;
use Contao\Exception;
use Contao\Image;
use Contao\Input;
use Contao\StringUtil;
use Contao\System;


class Ad
{
    private $Database = null;

    public function __construct()
    {
        $this->Database = System::importStatic('Database');
    }

    /**
     * Auto-generate an article alias if it has not been set yet
     * @param mixed
     * @param DataContainer
     * @return string
     * @throws Exception
     */
    public function generateAlias($varValue, DataContainer $dc)
    {
        $autoAlias = false;
        // Generate an alias if there is none
        if ($varValue == '') {
            $autoAlias = true;
            $varValue = standardize(StringUtil::restoreBasicEntities($dc->activeRecord->name));
        }
        $objAlias = $this->Database->prepare("SELECT id FROM tl_mobile_ad WHERE (id=? OR alias=?)")
            ->execute($dc->id, $varValue);
        // Check whether the page alias exists
        if ($objAlias->numRows > 1) {
            if (!$autoAlias) {
                throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
            }
            $varValue .= '-' . $dc->id;
        }
        return $varValue;
    }

    /**
     * Auto-generate an article alias if it has not been set yet
     * @param mixed
     * @param DataContainer
     * @return string
     * @throws Exception
     */
    public function generateAliasByName($varValue)
    {
        $varValue = standardize(StringUtil::restoreBasicEntities($varValue));

        $objAlias = $this->Database->prepare("SELECT id FROM tl_mobile_ad WHERE alias=?")
            ->execute($varValue);
        // Check whether the page alias exists
        if ($objAlias->numRows > 1) {
            $varValue .= '-' . mt_rand();
        }
        return $varValue;
    }

    /**
     * Return the "toggle visibility" button
     *
     * @param array $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        /*
        if (Input::get('tid') !== null && \strlen(Input::get('tid'))) {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }
        // Check permissions AFTER checking the tid, so hacking attempts are logged
        //if (!$this->User->hasAccess('tl_mobile_ad::published', 'alexf')) {
        //    return '';
        //}
        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);
        if (!$row['published']) {
            $icon = 'invisible.gif';
        }
        return '<a href="' . Backend::addToUrl($href) . '" title="' . StringUtil::specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
        */
    }

    /**
     * get vehicle category options by vehicle class
     * @param  $dc
     * @return array
     */
    public function categoryOptionsCallback(DataContainer $dc)
    {
        return $GLOBALS['TL_LANG']['tl_mobile_ad']['vehicle_category_' . $dc->activeRecord->vehicle_class]['options'];
    }

    /**
     * get vehicle features options by vehicle class
     * @param  $dc
     * @return array
     */
    public function featuresOptionsCallback(DataContainer $dc)
    {
        return $GLOBALS['TL_LANG']['tl_mobile_ad']['features_' . $dc->activeRecord->vehicle_class]['options'];
    }
}