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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Pdir\MobileDe',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Elements
    'Pdir\MobileDe\ListingElement' => 'system/modules/pdirMobileDe/Elements/ListingElement.php',
	'Pdir\MobileDe\ReaderElement' => 'system/modules/pdirMobileDe/Elements/ReaderElement.php',

	// Modules
	'Pdir\MobileDe\MobileDeSetup' => 'system/modules/pdirMobileDe/Modules/MobileDeSetup.php',

	// Classes
	'Pdir\MobileDe\Helper'  => 'system/modules/pdirMobileDe/Classes/Helper.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_mobilede_setup' => 'system/modules/pdirMobileDe/templates/be',

    'ce_mobilede_list' => 'system/modules/pdirMobileDe/templates/elements',
	'ce_mobilede_item' => 'system/modules/pdirMobileDe/templates/elements',
	'ce_mobilede_reader' => 'system/modules/pdirMobileDe/templates/elements',
));
