<?php

/**
 * Namespace
 */
namespace Pdir\MobileDe;

class MobileDeSetup extends \BackendModule
{
    /**
     * Mobile.de Inserate version
     */
    const VERSION = '1.0.4';

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
    * Generate the module
    * @throws \Exception
    */
    protected function compile()
    {
		$className = 'system/modules/pdirMobileDe/Classes/Helper.php';
		$strDomain = $_SERVER['SERVER_NAME'];

		/* @todo empty cache folder from backend */

		switch (\Input::get('act')) {
			case 'download':
				$strHelperData = file_get_contents(self::$apiUrl . 'download/latest/'.$strDomain);
				if ($strHelperData != 'error')
				{
					\File::putContent($className, $strHelperData);
					$this->Template->message = array('Vollversion wurde erfolgreich heruntergeladen!', 'confirm');
				}
				else
				{
					$this->Template->message = array('Für Ihre IP/Domain wurde noch keine Lizenz gekauft.', 'error');
				}
				// break;
			default:
				// do something here
		}

		$this->Template->extMode = Helper::MODE;
		$this->Template->extModeTxt = Helper::MODE=='FULL' ? 'Vollversion' : 'Demo';
		$this->Template->version = self::VERSION;
		$this->Template->hostname = gethostname();
		$this->Template->ip = $_SERVER['SERVER_ADDR'];
		$this->Template->domain = $strDomain;
    }
}