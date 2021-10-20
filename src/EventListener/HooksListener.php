<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2021 pdir / digital agentur // pdir GmbH
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

use Pdir\MobileDeBundle\Model\VehicleModel;

class HooksListener
{
    const PARAMETER_KEY = 'ad';

    public function parseFrontendTemplate($strContent, $strTemplate)
    {
        if ('ce_mobilede_list' === $strTemplate || 'ce_mobilede_reader' === $strTemplate) {
            // Sponsored by is only used in demo mode. If you want to remove the link, you must buy the full version at https://pdir.de/mobilede.html
            $strContent .= '<div style="text-align:center;"><br>Sponsored by: <a href="https://pdir.de/mobilede.html">Contao mobile.de Erweiterung</a></div>';
        }

        return $strContent;
    }

    /**
     * Replace the insert tag.
     *
     * @param string $tag the insert tag
     *
     * @return bool|string
     */
    public function onReplaceInsertTags($tag)
    {
        if (preg_match('/^mobileDe([bsrl]?)\:\:/', $tag)) {
            return $this->replaceMobileDeInsertTag($tag);
        }

        return false;
    }

    /**
     * @param array $arrPages
     * @param array $intRoot
     *
     * @return array
     */
    public function addVehiclesToSearchIndex($arrPages)
    {
        $vehicles = VehicleModel::findAll();
        $newVehiclePage = [];

        $db = \Database::getInstance();
        $result = $db->prepare('SELECT pdir_md_readerPage FROM tl_content WHERE pdir_md_readerPage != ?')->execute(0);
        $readerPageId = $result->pdir_md_readerPage;

        foreach ($vehicles as $vehicle) {
            $newVehiclePage[] = \Environment::get('url').'/'.$this->getReaderPageLink($vehicle->alias, $readerPageId);
        }

        $newVehiclePage = array_unique($newVehiclePage);

        return array_merge($arrPages, $newVehiclePage);
    }

    protected function getReaderPageLink($pageId, $readerPageId)
    {
        $paramString = sprintf('/%s/%s',
            self::PARAMETER_KEY,
            $pageId
        );

        if (\Config::get('useAutoItem')) {
            $paramString = sprintf('/%s',
                $pageId
            );
        }

        $readerPage = \PageModel::findPublishedByIdOrAlias($readerPageId)->current()->row();

        return \Controller::generateFrontendUrl($readerPage, $paramString);
    }

    /**
     * Replace the mobilede insert tag.
     *
     * @param string $tag the given tag
     *
     * @return string
     */
    private function replaceMobileDeInsertTag($tag)
    {
        $parts = explode('::', $tag);

        try {
            // @todo use model
            $db = \Database::getInstance();
            $stmt = $db->prepare('SELECT * FROM tl_vehicle WHERE id=? OR alias =?');
            $res = $stmt->execute($parts[1], $parts[1]);
            $ad = $res->fetchAssoc();
            if ($ad[$parts[2]]) {
                return $ad[$parts[2]];
            }
        } catch (\RuntimeException $e) {
            // property of ad item not found
            return '';
        }
    }
}
