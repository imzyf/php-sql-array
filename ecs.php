<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PARALLEL, true);
    $parameters->set(Option::PATHS, [
        __DIR__.'/src',
        __DIR__.'/test',
        __DIR__.'/ecs.php',
    ]);

    $containerConfigurator->import(SetList::STRICT);
    $containerConfigurator->import(SetList::SYMFONY);
};
