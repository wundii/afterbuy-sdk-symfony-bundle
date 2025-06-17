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
            ->defaultValue('<your_account_token>')
            ->info('Account Token or %env(...)%')
            ->end()
            ->scalarNode('partnerToken')
            ->defaultValue('<your_partner_token>')
            ->info('Partner Token or %env(...)%')
            ->end()
            ->scalarNode('endpointEnum')
            ->defaultValue('sandbox')
            ->info('sandbox/prod or %env(...)%')
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
