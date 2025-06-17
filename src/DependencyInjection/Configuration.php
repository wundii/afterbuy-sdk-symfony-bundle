<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('afterbuy_sdk');

        /** @phpstan-ignore-next-line  */
        $treeBuilder->getRootNode()
            ->children()
            ->arrayNode('afterbuy_global')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('accountToken')
            ->defaultValue('"%env(AFTERBUY_ACCOUNT_TOKEN)%"')
            ->info('Account Token or %env(AFTERBUY_ACCOUNT_TOKEN)%')
            ->end()
            ->scalarNode('partnerToken')
            ->defaultValue('"%env(AFTERBUY_PARTNER_TOKEN)%"')
            ->info('Partner Token or %env(AFTERBUY_PARTNER_TOKEN)%')
            ->end()
            ->scalarNode('endpointEnum')
            ->defaultValue('"%env(AFTERBUY_ENDPOINT_ENUM)%"')
            ->info('SANDBOX/PROD or %env(AFTERBUY_ENDPOINT_ENUM)%')
            ->end()
            ->scalarNode('errorLanguageEnum')
            ->defaultValue('DE')
            ->info('Error language enum value (e.g. DE, EN)')
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
