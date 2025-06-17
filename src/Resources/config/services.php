<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\Resources\Config;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ReferenceConfigurator;
use Wundii\AfterbuySdk\Core\Afterbuy;
use Wundii\AfterbuySdk\Core\AfterbuyGlobal;
use Wundii\AfterbuySdk\SymfonyBundle\Command\DefaultConfigCommand;

return function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(Afterbuy::class)
        ->arg('$afterbuyGlobal', new ReferenceConfigurator(AfterbuyGlobal::class))
        ->public();

    $services->set(DefaultConfigCommand::class)
        ->autowire()
        ->autoconfigure()
        ->public();
};
