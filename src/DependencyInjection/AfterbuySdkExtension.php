<?php

declare(strict_types=1);

namespace Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Wundii\AfterbuySdk\Core\Afterbuy;
use Wundii\AfterbuySdk\Core\AfterbuyGlobal;
use Wundii\AfterbuySdk\Enum\Core\EndpointEnum;
use Wundii\AfterbuySdk\Enum\ErrorLanguageEnum;

class AfterbuySdkExtension extends Extension
{
    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $containerBuilder): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $phpFileLoader = new PhpFileLoader($containerBuilder, new FileLocator(__DIR__ . '/../Resources/config'));
        $phpFileLoader->load('services.php');

        $afterbuyGlobal = $config['afterbuy_global'];
        $loggerInterface = $config['logger_interface'];
        $validatorBuilder = $config['validatorBuilder'];

        if (! is_array($afterbuyGlobal)) {
            throw new Exception('The "afterbuy_global" configuration must be an array.');
        }

        $loggerInterface = is_string($loggerInterface) ? $loggerInterface : '';
        $validatorBuilder = is_string($validatorBuilder) ? $validatorBuilder : '';

        $accountToken = $afterbuyGlobal['accountToken'];
        $partnerToken = $afterbuyGlobal['partnerToken'];
        $endpointEnum = $afterbuyGlobal['endpointEnum'];
        $errorLanguageEnum = $afterbuyGlobal['errorLanguageEnum'];

        $endpointEnum = is_string($endpointEnum) ? $endpointEnum : '';
        $errorLanguageEnum = is_string($errorLanguageEnum) ? $errorLanguageEnum : '';

        $endpointEnum = EndpointEnum::tryFrom(strtolower($endpointEnum));
        $errorLanguageEnum = ErrorLanguageEnum::tryFrom(strtoupper($errorLanguageEnum));

        $afterbuyGlobalDef = new Definition(AfterbuyGlobal::class, [
            $accountToken,
            $partnerToken,
            $endpointEnum,
            $errorLanguageEnum,
        ]);
        $containerBuilder->setDefinition(AfterbuyGlobal::class, $afterbuyGlobalDef);

        $loggerReference = interface_exists($loggerInterface) || class_exists($loggerInterface) ? new Reference($loggerInterface) : null;
        $validatorReference = interface_exists($validatorBuilder) || class_exists($loggerInterface) ? new Reference($validatorBuilder) : null;

        $afterbuyDef = new Definition(Afterbuy::class, [
            $afterbuyGlobalDef,
            $loggerReference,
            $validatorReference,
        ]);
        $containerBuilder->setDefinition(Afterbuy::class, $afterbuyDef);
    }

    public function getXsdValidationBasePath(): string|false
    {
        return __DIR__ . '/../Resources/config/schema';
    }
}
