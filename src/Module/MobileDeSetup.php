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

namespace Pdir\MobileDeBundle\Module;

use Contao\BackendModule;
use Contao\Controller;
use Contao\CoreBundle\Monolog\ContaoContext;
use Contao\Database;
use Contao\Environment;
use Contao\File;
use Contao\FilesModel;
use Contao\Folder;
use Contao\Input;
use Contao\Message;
use Contao\System;
use Contao\ZipReader;
use Psr\Log\LogLevel;

class MobileDeSetup extends BackendModule
{
    /**
     * mobilede version.
     */
    public const VERSION = '3.6.0';

    /**
     * Extension mode.
     */
    public const MODE = 'FREE';

    /**
     * API Url.
     *
     * @var string
     */
    public static $apiUrl = 'https://pdir.de/api/mobilede/';
    /**
     * Template.
     *
     * @var string
     */
    protected $strTemplate = 'be_mobilede_setup';

    /**
     * Table.
     *
     * @var string
     */
    protected $strTable = 'tl_vehicle';

    /**
     * Demo data path.
     *
     * @var string
     */
    protected $strPath = 'files/mobilede/demodata/';

    /**
     * Active Domain.
     *
     * @var string
     */
    protected $strDomain = '';

    /**
     * @throws \Exception
     */
    public function generate(): string
    {
        $this->logger = System::getContainer()->get('monolog.logger.contao');

        $this->compile();
    }

    /**
     * Generate the module.
     *
     * @throws \Exception
     */
    protected function compile(): void
    {
        // load language file
        self::loadLanguageFile('tl_vehicle');

        $this->strDomain = Environment::get('httpHost');

        switch (Input::get('act')) {
            case 'download':
                $this->downloadDemoData();
                // no break
            default:
                // do something here
                Message::addInfo($GLOBALS['TL_LANG']['tl_vehicle']['importMessage']);
        }

        Controller::redirect(Controller::getReferer());
    }

    /**
     * @throws \Exception
     */
    protected function downloadDemoData(): void
    {
        $strFile = $this->strPath.'demo.zip';

        if (!is_dir($this->strPath)) {
            new Folder($this->strPath);
        }

        $strHelperData = file_get_contents(self::$apiUrl.'demodata/'.self::VERSION.'/'.$this->strDomain);

        if ('error' === $strHelperData) {
            $this->logger->log(
                LogLevel::ERROR,
                $GLOBALS['TL_LANG']['pdirMobileDe']['field_keys']['noResultMessage'],
                ['contao' => new ContaoContext($GLOBALS['TL_LANG']['tl_vehicle']['downloadError'], ContaoContext::ERROR, )]
            );
        }

        if ('error' !== $strHelperData) {
            File::putContent($strFile, $strHelperData);

            // unzip files
            $objArchive = new ZipReader($strFile);
            $images = [];

            while ($objArchive->next()) {
                File::putContent($this->strPath.$objArchive->file_name, $objArchive->unzip());

                // get uuid and push to array
                $uuid = FilesModel::findByPath($this->strPath.$objArchive->file_name)->uuid;

                if (false !== strpos($objArchive->file_name, 'detail/')) {
                    $images[] = $uuid;
                }
            }

            // read local sql file
            $fileModel = new File($this->strPath.'tl_vehicle-demodata.sql');
            $strQueries = $fileModel->getContentAsArray();

            // empty table and insert demo data
            Database::getInstance()->execute("TRUNCATE TABLE $this->strTable");

            foreach ($strQueries as $query) {
                Database::getInstance()->query($query);
            }

            $this->logger->log(
                LogLevel::INFO,
                $GLOBALS['TL_LANG']['pdirMobileDe']['field_keys']['noResultMessage'],
                ['contao' => new ContaoContext($GLOBALS['TL_LANG']['tl_vehicle']['downloadSuccess'], ContaoContext::ERROR, )]
            );

            // set images
            $adIds = Database::getInstance()->prepare("SELECT vehicle_id FROM  $this->strTable")->execute();
            $numbers = range(0, \count($images) - 1);

            while ($adIds->next()) {
                $uuidArr = [];
                shuffle($numbers);
                $randomNumber = $numbers[0];

                for ($i = 0; $i <= $randomNumber; ++$i) {
                    $uuidArr = $this->randomImage($uuidArr, $numbers, $images);
                }
                $uuidArr = serialize($uuidArr);

                // update
                Database::getInstance()->prepare("UPDATE  $this->strTable SET images=?, orderSRC=? WHERE vehicle_id=?")->execute($uuidArr, $uuidArr, $adIds->vehicle_id);
            }
        }
    }

    protected function randomImage($uuidArr, $numbers, $images)
    {
        // shuffe uuid
        shuffle($numbers);
        $image_uuid = $images[$numbers[0]];

        // set uuid array
        $uuidArr[] = $image_uuid;

        return $uuidArr;
    }
}
