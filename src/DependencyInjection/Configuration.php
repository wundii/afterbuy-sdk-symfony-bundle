<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Wundii\AfterbuySdk\Enum\Core\EndpointEnum;
use Wundii\AfterbuySdk\Enum\ErrorLanguageEnum;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $endpoint = array_map(
            static fn (EndpointEnum $endpointEnum): string => $endpointEnum->name,
            EndpointEnum::cases()
        );
        $errorLanguage = array_map(
            static fn (ErrorLanguageEnum $errorLanguageEnum): string => $errorLanguageEnum->value,
            ErrorLanguageEnum::cases()
        );

        $treeBuilder = new TreeBuilder('afterbuy_sdk');

        /** @phpstan-ignore-next-line  */
        $treeBuilder->getRootNode()
            ->children()
            ->arrayNode('afterbuy_global')
            ->isRequired()
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('accountToken')
            ->defaultValue('<your_account_token>')
            ->isRequired()
            ->cannotBeEmpty()
            ->info('Account Token or %env(Afterbuy-AccountToken)%')
            ->end()
            ->scalarNode('partnerToken')
            ->defaultValue('<your_partner_token>')
            ->isRequired()
            ->cannotBeEmpty()
            ->info('Partner Token or %env(Afterbuy-PartnerToken)%')
            ->end()
            ->enumNode('endpointEnum')
            ->values($endpoint)
            ->defaultValue('SANDBOX')
            ->end()
            ->enumNode('errorLanguageEnum')
            ->values($errorLanguage)
            ->defaultValue('DE')
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
