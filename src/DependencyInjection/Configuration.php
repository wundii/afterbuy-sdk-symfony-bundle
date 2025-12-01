<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Wundii\AfterbuySdk\Enum\Core\EndpointEnum;
use Wundii\AfterbuySdk\Enum\ErrorLanguageEnum;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder<'array'>
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $endpoint = array_map(
            static fn (EndpointEnum $endpointEnum): string => $endpointEnum->value,
            EndpointEnum::cases()
        );
        $errorLanguage = array_map(
            static fn (ErrorLanguageEnum $errorLanguageEnum): string => $errorLanguageEnum->value,
            ErrorLanguageEnum::cases()
        );

        $treeBuilder = new TreeBuilder('afterbuy_sdk');
        $treeBuilder->getRootNode()
            ->children()
            ->arrayNode('afterbuy_global')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('accountToken')
            ->defaultValue('<your_account_token>')
            ->info('Account Token or %env(...)%')
            ->end()
            ->scalarNode('partnerToken')
            ->defaultValue('<your_partner_token>')
            ->info('Partner Token or %env(...)%')
            ->end()
            ->enumNode('endpointEnum')
            ->values($endpoint)
            ->defaultValue('sandbox')
            ->info('Endpoint enum value')
            ->end()
            ->enumNode('errorLanguageEnum')
            ->values($errorLanguage)
            ->defaultValue('DE')
            ->info('Error language enum value')
            ->end()
            ->end()
            ->end()
            ->scalarNode('logger_interface')
            ->defaultNull()
            ->info('Logger interface class string (e.g. Psr\Log\LoggerInterface)')
            ->end()
            ->scalarNode('validatorBuilder')
            ->defaultNull()
            ->info('ValidatorBuilder class string (e.g. Symfony\Component\Validator\ValidatorBuilder)')
            ->end()
            ->end();

        return $treeBuilder;
    }
}
