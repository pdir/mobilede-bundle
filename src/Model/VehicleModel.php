<?php

declare(strict_types=1);

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2025 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://pdir.de/mobilede.html
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Model;

use Contao\Model;
use Contao\StringUtil;
use Contao\System;

class VehicleModel extends Model
{
    protected static $strTable = 'tl_vehicle';

    /**
     * Auto-generate an article alias if it has not been set yet.
     *
     * @param mixed $varValue
     *
     * @throws Exception
     *
     * @return string
     */
    public function generateAliasByName($varValue): string
    {
        $connection = System::getContainer()->get('database_connection');

        $varValue = StringUtil::standardize(StringUtil::restoreBasicEntities($varValue));

        $objAlias = $connection->executeQuery('SELECT id FROM tl_vehicle WHERE alias=?', [$varValue]);

        // Check whether the page alias exists
        if ($objAlias->numRows > 0) {
            $varValue .= '-'.random_int(0, 1000000);
        }

        return $varValue;
    }
}
