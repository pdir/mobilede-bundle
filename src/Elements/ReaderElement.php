<?php

/**
 * mobilede for Contao Open Source CMS
 *
 * Copyright (C) 2018 pdir/ digital agentur <develop@pdir.de>
 *
 * @package    mobilede
 * @link       https://pdir.de/mobilede
 * @license    pdir license - All-rights-reserved - commercial extension
 * @author     pdir GmbH <develop@pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\MobileDeBundle\Elements;

use Contao\CoreBundle\Exception\PageNotFoundException;

class ReaderElement extends  \ContentElement
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_mobilede_reader';

    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### MobileDe READER ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
            return $objTemplate->parse();
        }

		// Set auto item
		if (!isset($_GET['ad']) && \Config::get('useAutoItem') && isset($_GET['auto_item'])) {
			\Input::setGet('ad', \Input::get('auto_item'));
		}


		// get alias from auto item
		$this->alias = \Input::get('ad');

		$helper = new Helper($this->pdir_md_customer_username, $this->pdir_md_customer_password, $this->pdir_md_customer_id);
		$this->ad = $helper->getAd($this->alias);

		if($this->ad['page'])
			$this->ad = $this->ad['page']['ad'];

        // Return if there are no ad / do not index or cache
        if (!is_array($this->ad) || count($this->ad) < 1)
        {
			throw new PageNotFoundException('Page not found: ' . \Environment::get('uri'));
        }
        return parent::generate();
    }

    /**
     * Generate module
     */
    protected function compile()
    {
		$assetsDir = 'web/bundles/pdirmobilede';

		if(!$this->pdir_md_removeModuleJs)
		{
			// not used yet $GLOBALS['TL_JAVASCRIPT']['md_js_1'] = '/bundles/pdirmobilede/js/ads.js|static';
		}
		if(!$this->pdir_md_removeModuleCss)
		{
			$GLOBALS['TL_CSS']['md_css_1'] = $assetsDir . '/vendor/fontello/css/fontello.css||static';
			$GLOBALS['TL_CSS']['md_css_2'] = $assetsDir . '/vendor/fontello/css/animation.css||static';
			$GLOBALS['TL_CSS']['md_css_3'] = $assetsDir . '/css/ads.css||static';
		}

		$this->Template->ad = $this->ad;

		// Debug mode
		if($this->pdir_md_enableDebugMode)
		{
			$this->Template->debug = true;
			$this->Template->version = Helper::VERSION;
			$this->Template->customer = $this->pdir_md_customer_id;
			$this->Template->rawData = $this->ad;
		}
    }
}
