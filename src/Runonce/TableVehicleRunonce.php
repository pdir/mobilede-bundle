<?php

/*
 * mobile.de bundle for Contao Open Source CMS
 *
 * Copyright (c) 2019 pdir / digital agentur // pdir GmbH
 *
 * @package    mobilede-bundle
 * @link       https://pdir.de/mobilede.html
 * @license    proprietary / pdir license - All-rights-reserved - commercial extension
 * @author     Mathias Arzberger <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Runonce;

use Contao\Controller;

class TableVehicleRunonce extends Controller
{
    /**
     * Initialize the object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('Database');
    }

    /**
     * Run the controller
     * Update from tl_mobile_ad to tl_vehicle
     *
     * @return void|null
     */
    public function run()
    {
        if ($this->Database->tableExists('tl_vehicle')) {
            return;
        }

        if ($this->Database->tableExists('tl_mobile_ad')) {
            $this->Database
                ->prepare('RENAME TABLE tl_mobile_ad TO tl_vehicle')
                ->execute();
        }
    }
}
