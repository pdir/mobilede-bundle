<?php

/**
 * Namespace
 */

namespace Pdir\MobileDeBundle\Module;

class MobileDeSetup extends \BackendModule
{
    /**
     * mobilede version
     */
    const VERSION = '2.0.1';

    /**
     * Extension mode
     * @var boolean
     */

    const MODE = 'DEMO';
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_mobilede_setup';

    /**
     * API Url
     * @var string
     */
    static $apiUrl = 'https://pdir.de/api/mobilede/';

    /**
     * Table
     * @var string
     */
    protected $strTable = 'tl_mobile_ad';

    /**
     * Demo data path
     * @var string
     */
    protected $strPath = 'files/mobilede/demodata/';

    /**
     * Active Domain
     * @var string
     */
    protected $strDomain = '';

    /**
     * Generate the module
     * @throws \Exception
     */
    protected function compile()
    {
        $this->strDomain = \Environment::get('httpHost');

        switch (\Input::get('act')) {
            case 'download':
                $this->downloadDemoData();
            default:
                // do something here
        }

        $this->Template->extMode = self::MODE;
        $this->Template->extModeTxt = self::MODE == 'FULL' ? 'Vollversion' : 'Demo';
        $this->Template->version = self::VERSION;
        $this->Template->hostname = gethostname();
        $this->Template->ip = \Environment::get('server');
        $this->Template->domain = $this->strDomain;

        // email body
        $this->Template->emailBody = $this->getEmailBody();
    }

    protected function downloadDemoData()
    {
        $strFile = $this->strPath . 'demo.zip';

        if(!is_dir($this->strPath)) {
            new \Folder($this->strPath);
        }

        $strHelperData = file_get_contents(self::$apiUrl . 'demodata/' . self::VERSION . '/' . $this->strDomain);
        $this->Template->message = array('Beim herunterladen der Demo Daten ist ein Fehler aufgetreten. (support@pdir.de)', 'error');

        if ($strHelperData != 'error') {
            \File::putContent($strFile, $strHelperData);

            // unzip files
            $objArchive = new \ZipReader($strFile);
			$images = array();
            while ($objArchive->next())
            {
                \File::putContent($this->strPath . $objArchive->file_name, $objArchive->unzip());

				// get uuid and push to array
				$uuid = \FilesModel::findByPath($this->strPath . $objArchive->file_name)->uuid;
				if( strpos($objArchive->file_name,"detail/") !== false ) {
					array_push($images,$uuid);
				}
            }

            // read local sql file
            $fileModel = new  \File($this->strPath . 'tl_mobile_ad-demodata.sql');
            $strQueries = $fileModel->getContent();

            // empty table and insert demo data
            \Database::getInstance()->execute("DELETE FROM $this->strTable WHERE type = 'sync'");
            \Database::getInstance()->query($strQueries);

            $this->Template->message = array('Demo Daten wurden erfolgreich heruntergeladen!', 'confirm');

            // set images
            $adIds = \Database::getInstance()->prepare("SELECT ad_id FROM tl_mobile_ad")->execute();
            $numbers = range(0,count($images)-1);
            while($adIds->next())
            {
                $uuidArr = array();
                shuffle($numbers);
                $randomNumber = $numbers[0];
                for($i = 0; $i <= $randomNumber; $i++) {
                    $uuidArr = $this->randomImage($uuidArr,$numbers,$images);
                }
                $uuidArr = serialize($uuidArr);

                // update
                \Database::getInstance()->prepare("UPDATE tl_mobile_ad SET images=?, orderSRC=? WHERE ad_id=?")->execute($uuidArr,$uuidArr,$adIds->ad_id);
            }
        }
    }

    protected function getEmailBody()
    {
        $arrSearch = array(':IP:', ':HOST:', ':DOMAIN:', '<br>');
        $arrReplace = array($this->Template->ip, $this->Template->hostname, $this->Template->domain, '%0d%0a');
        return str_replace($arrSearch, $arrReplace, $GLOBALS['TL_LANG']['MOBILEDE']['emailBody']);
    }

	protected function randomImage($uuidArr,$numbers,$images)
	{
		// shuffe uuid
		shuffle($numbers);
		$image_uuid = $images[ $numbers[0] ];

		// set uuid array
		array_push($uuidArr,$image_uuid);
		return $uuidArr;
	}
}
