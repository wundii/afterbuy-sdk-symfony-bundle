<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;
use Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection\Configuration;

class ConfigurationTest extends TestCase
{
    public function testDefaultConfiguration(): void
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, []);

        $expected = [
            'afterbuy_global' => [
                'accountToken' => '<your_account_token>',
                'partnerToken' => '<your_partner_token>',
                'endpointEnum' => 'sandbox',
                'errorLanguageEnum' => 'DE',
            ],
            'logger_interface' => null,
            'validatorBuilder' => null,
        ];

        $this->assertSame($expected, $config);
    }

    public function testOverrideConfiguration(): void
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $input = [[
            'afterbuy_global' => [
                'accountToken' => 'your_account_token',
                'partnerToken' => 'your_partner_token',
                'endpointEnum' => 'PROD',
                'errorLanguageEnum' => 'EN',
            ],
            'logger_interface' => 'logger_interface_class_string',
        ]];

        $config = $processor->processConfiguration($configuration, $input);

        $this->assertSame('your_account_token', $config['afterbuy_global']['accountToken']);
        $this->assertSame('your_partner_token', $config['afterbuy_global']['partnerToken']);
        $this->assertSame('PROD', $config['afterbuy_global']['endpointEnum']);
        $this->assertSame('EN', $config['afterbuy_global']['errorLanguageEnum']);
    }
}
