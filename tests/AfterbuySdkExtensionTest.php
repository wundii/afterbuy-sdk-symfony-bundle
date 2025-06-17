<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Wundii\AfterbuySdk\Core\Afterbuy;
use Wundii\AfterbuySdk\Core\AfterbuyGlobal;
use Wundii\AfterbuySdk\Enum\Core\EndpointEnum;
use Wundii\AfterbuySdk\Enum\ErrorLanguageEnum;
use Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection\AfterbuySdkExtension;

class AfterbuySdkExtensionTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testLoadRegistersServicesWithCorrectArguments(): void
    {
        $container = new ContainerBuilder();
        $extension = new AfterbuySdkExtension();

        $configs = [[
            'afterbuy_global' => [
                'accountToken' => 'your_account_token',
                'partnerToken' => 'your_partner_token',
                'endpointEnum' => 'sandbox',
                'errorLanguageEnum' => 'DE',
            ],
            'logger_interface' => 'logger_interface_class_string',
            'validatorBuilder' => '',
        ]];

        $extension->load($configs, $container);

        $this->assertTrue($container->hasDefinition(AfterbuyGlobal::class));
        $this->assertTrue($container->hasDefinition(Afterbuy::class));

        $afterbuyGlobalDef = $container->getDefinition(AfterbuyGlobal::class);
        $args = $afterbuyGlobalDef->getArguments();

        $this->assertSame('your_account_token', $args[0]);
        $this->assertSame('your_partner_token', $args[1]);
        $this->assertSame('sandbox', $args[2]);
        $this->assertSame('DE', $args[3]);
        // $this->assertInstanceOf(EndpointEnum::class, $args[2]);
        // $this->assertInstanceOf(ErrorLanguageEnum::class, $args[3]);
    }

    public function testGetXsdValidationBasePath(): void
    {
        $extension = new AfterbuySdkExtension();
        $result = $extension->getXsdValidationBasePath();
        $this->assertIsString($result);
        $this->assertStringEndsWith('src/DependencyInjection/../Resources/config/schema', $result);
    }
}
