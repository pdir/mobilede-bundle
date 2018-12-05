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
    const VERSION = '2.0.3';

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
            while ($objArchive->next())
            {
                \File::putContent($this->strPath . $objArchive->file_name, $objArchive->unzip());
            }

            // read local sql file
            $fileModel = new  \File($this->strPath . 'tl_mobile_ad-demodata.sql');
            $strQueries = $fileModel->getContent();

            // empty table and insert demo data
            \Database::getInstance()->execute("DELETE FROM $this->strTable WHERE type = 'sync'");
            \Database::getInstance()->query($strQueries);

            $this->Template->message = array('Demo Daten wurden erfolgreich heruntergeladen!', 'confirm');
        }
    }

    protected function getEmailBody()
    {
        $arrSearch = array(':IP:', ':HOST:', ':DOMAIN:', '<br>');
        $arrReplace = array($this->Template->ip, $this->Template->hostname, $this->Template->domain, '%0d%0a');
        return str_replace($arrSearch, $arrReplace, $GLOBALS['TL_LANG']['MOBILEDE']['emailBody']);
    }
}
