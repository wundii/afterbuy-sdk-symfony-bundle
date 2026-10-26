<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\Tests;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Wundii\AfterbuySdk\Core\Afterbuy;
use Wundii\AfterbuySdk\Core\AfterbuyGlobal;
use Wundii\AfterbuySdk\Enum\Core\EndpointEnum;
use Wundii\AfterbuySdk\Enum\ErrorLanguageEnum;
use Wundii\AfterbuySdk\Extension\DateTime;
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
        $this->assertInstanceOf(EndpointEnum::class, $args[2]);
        $this->assertInstanceOf(ErrorLanguageEnum::class, $args[3]);
    }

    /**
     * @throws Exception
     */
    public function testLoadWithLoggerClassAndWithoutValidatorBuilder(): void
    {
        $container = new ContainerBuilder();
        $extension = new AfterbuySdkExtension();

        $configs = [[
            'afterbuy_global' => [
                'accountToken' => 'your_account_token',
                'partnerToken' => 'your_partner_token',
            ],
            'logger_interface' => NullLogger::class,
            'validatorBuilder' => '',
        ]];

        $extension->load($configs, $container);

        $args = $container->getDefinition(Afterbuy::class)->getArguments();

        $this->assertInstanceOf(Reference::class, $args[1]);
        $this->assertSame(NullLogger::class, (string) $args[1]);
        $this->assertNull($args[2]);
    }

    /**
     * @throws Exception
     */
    public function testLoadPassesDebugModeAndClassMap(): void
    {
        $container = new ContainerBuilder();
        $extension = new AfterbuySdkExtension();

        $configs = [[
            'afterbuy_global' => [
                'accountToken' => 'your_account_token',
                'partnerToken' => 'your_partner_token',
            ],
            'debug_mode' => true,
            'class_map' => [
                DateTimeInterface::class => DateTimeImmutable::class,
            ],
        ]];

        $extension->load($configs, $container);

        $args = $container->getDefinition(Afterbuy::class)->getArguments();

        $this->assertTrue($args[3]);
        $this->assertSame([
            DateTimeInterface::class => DateTimeImmutable::class,
        ], $args[4]);
    }

    /**
     * @throws Exception
     */
    public function testLoadUsesSdkDefaultClassMap(): void
    {
        $container = new ContainerBuilder();
        $extension = new AfterbuySdkExtension();

        $extension->load([[]], $container);

        $args = $container->getDefinition(Afterbuy::class)->getArguments();

        $this->assertFalse($args[3]);
        $this->assertSame([
            DateTimeInterface::class => DateTime::class,
        ], $args[4]);
    }

    public function testGetXsdValidationBasePath(): void
    {
        $extension = new AfterbuySdkExtension();
        $result = $extension->getXsdValidationBasePath();
        $this->assertIsString($result);
        $this->assertStringEndsWith('src/DependencyInjection/../Resources/config/schema', $result);
    }

    public function testConfigLoadExceptionOnInvalidAfterbuyGlobal(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid type for path "afterbuy_sdk.afterbuy_global". Expected "array", but got "string"');

        $container = new ContainerBuilder();
        $extension = new AfterbuySdkExtension();

        $configs = [[
            'afterbuy_global' => 'invalid_value',
            'logger_interface' => 'logger_interface_class_string',
            'validatorBuilder' => '',
        ]];

        $extension->load($configs, $container);
    }
}
