<?php

declare(strict_types=1);

$date = date('Y');

$GLOBALS['ecsHeader'] = <<<EOF
mobile.de bundle for Contao Open Source CMS

Copyright (c) $date pdir / digital agentur // pdir GmbH

@package    mobilede-bundle
@link       https://pdir.de/mobilede.html
@license    proprietary / pdir license - All-rights-reserved - commercial extension
@author     Mathias Arzberger <develop@pdir.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__.'/vendor/contao/easy-coding-standard/config/set/contao.php');

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::LINE_ENDING, "\n");

    $services = $containerConfigurator->services();
    $services
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => $GLOBALS['ecsHeader'],
        ]])
    ;
};
