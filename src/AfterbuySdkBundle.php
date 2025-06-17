<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection\AfterbuySdkExtension;

class AfterbuySdkBundle extends Bundle
{
    public function getContainerExtension(): ExtensionInterface
    {
        return new AfterbuySdkExtension();
    }
}
