<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2018 pdir / digital agentur // pdir GmbH
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

class HooksListener
{
    public function parseFrontendTemplate($strContent, $strTemplate)
    {
        if ('ce_mobilede_list' === $strTemplate || 'ce_mobilede_reader' === $strTemplate) {
            // Sponsored by is only used in demo mode. If you want to remove the link, you must buy the full version at https://pdir.de/mobilede.html
            $strContent .= '<div style="text-align:center;"><br>Sponsored by: <a href="https://pdir.de/mobilede.html">Contao mobile.de Erweiterung</a></div>';
        }

        return $strContent;
    }
}
