<?php

/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2017 pdir / digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * this class is only used for demo presentation and will be replaced by downloader in extension setup
 */

namespace Pdir\MobileDe;

class Helper extends \Frontend
{
	/**
	 * mobilede version
	 */
	const VERSION = '1.0.2';

	/**
	 * Extension mode
	 * @var boolean
	 */
	const MODE = 'DEMO';

	/**
	 * API Url
	 * @var string
	 */
	static $apiUrl = 'https://pdir.de/api/mobilede/';

	public function getAds($customerID, $apiUsr, $apiPwd)
	{
		// only used for demo presentation
		$json = file_get_contents(self::$apiUrl . 'list/all/' . $_SERVER['SERVER_NAME']);
		$arrAds = json_decode( $json, true );
		return $arrAds; // load from local cache
	}

	public function getAdDetail($customerID, $alias)
	{
		// only used for demo presentation
		$json = file_get_contents(self::$apiUrl . 'ad/' . $alias . '/' . $_SERVER['SERVER_NAME']);
		$arrAd = json_decode( $json, true );
		return $arrAd;
	}
}