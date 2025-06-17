<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Wundii\AfterbuySdk\Core\Afterbuy;
use Wundii\AfterbuySdk\Core\AfterbuyGlobal;
use Wundii\AfterbuySdk\SymfonyBundle\Command\DefaultConfigCommand;

class ServicesConfigTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testServicesAreLoadedCorrectly(): void
    {
        $container = new ContainerBuilder();
        $container->register(AfterbuyGlobal::class);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/../src/Resources/config'));
        $loader->load('services.php');

        $container->compile();

        $this->assertTrue($container->has(Afterbuy::class), 'Afterbuy service is not registered.');
        $afterbuyDef = $container->getDefinition(Afterbuy::class);
        $this->assertTrue($afterbuyDef->isPublic(), 'Afterbuy service is not public.');

        /**
         * @todo Check if Afterbuy is initialized with AfterbuyGlobal.
         */
        // $this->assertEquals(AfterbuyGlobal::class, $afterbuyDef->getArgument(0)?->getClass(), 'Afterbuy should be initialized with AfterbuyGlobal.');

        $this->assertTrue($container->has(DefaultConfigCommand::class), 'DefaultConfigCommand is not registered.');
        $commandDef = $container->getDefinition(DefaultConfigCommand::class);
        $this->assertTrue($commandDef->isAutowired(), 'DefaultConfigCommand should be autowired.');
        $this->assertTrue($commandDef->isAutoconfigured(), 'DefaultConfigCommand should be autoconfigured.');
        $this->assertTrue($commandDef->isPublic(), 'DefaultConfigCommand should be public.');
    }
}
