<?php

/**
 * Namespace
 */
namespace Pdir\MobileDe;

class MobileDeSetup extends \BackendModule
{
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
		$className = '/vendor/pdir/mobilede-bundle/src/Resources/contao/Classes/Helper.php';
		$strDomain = \Environment::get('httpHost');

		/* @todo empty cache folder from backend */

		switch (\Input::get('act')) {
			case 'download':
				$strHelperData = file_get_contents(self::$apiUrl . 'download/latest/'.$strDomain);

				$this->Template->message = array('Für Ihre IP/Domain wurde noch keine Lizenz gekauft.', 'error');

				if ($strHelperData != 'error')
				{
					\File::putContent($className, $strHelperData);
					$this->Template->message = array('Vollversion wurde erfolgreich heruntergeladen!', 'confirm');
				}
			default:
				// do something here
		}

		$this->Template->extMode = Helper::MODE;
		$this->Template->extModeTxt = Helper::MODE=='FULL' ? 'Vollversion' : 'Demo';
		$this->Template->version = Helper::VERSION;
		$this->Template->hostname = gethostname();
		$this->Template->ip = \Environment::get('server');
		$this->Template->domain = $strDomain;

		// email body
		$this->Template->emailBody = $this->getEmailBody();
    }

	protected function getEmailBody()
	{
		$arrSearch = array(':IP:', ':HOST:', ':DOMAIN:', '<br>');
		$arrReplace = array($this->Template->ip, $this->Template->hostname, $this->Template->domain, '%0d%0a');
		return str_replace( $arrSearch, $arrReplace, $GLOBALS['TL_LANG']['MOBILEDE']['emailBody'] );
	}
}