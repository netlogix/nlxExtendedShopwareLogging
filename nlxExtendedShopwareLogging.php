<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging;

use nlxExtendedShopwareLogging\Services\LoggerService;
use Shopware\Components\Plugin;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class nlxExtendedShopwareLogging extends Plugin
{
    const LOGGING_FEATURES_KEY = 'NLX_LOG_FEATURES';
    const LOGGING_LEVEL_KEY = 'NLX_LOG_LEVEL';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $this->initLogLevelParameter($container);

        $loggingFeaturesString = \getenv(self::LOGGING_FEATURES_KEY);
        if (empty($loggingFeaturesString)) {
            return;
        }

        $loggingFeatures = explode(',', $loggingFeaturesString);
        if (empty($loggingFeatures)) {
            return;
        }

        $componentsXmlDir = __DIR__ . '/Resources/Components/';
        $loader = new XmlFileLoader($container, new FileLocator($componentsXmlDir));
        foreach ($loggingFeatures as $loggingFeature) {
            if (file_exists($componentsXmlDir . $loggingFeature . '.xml')) {
                $loader->load($loggingFeature . '.xml');
            }
        }
    }

    private function initLogLevelParameter(ContainerBuilder $container)
    {
        $envLogLevel = \getenv(self::LOGGING_LEVEL_KEY);
        if (empty($envLogLevel) || in_array(strtoupper($envLogLevel), array_keys(LoggerService::NLX_LOG_LEVELS)) === false) {
            $envLogLevel = LoggerService::NLX_LOG_LEVEL_NOTICE;
        }
        $container->setParameter('nlx.extended_shopware_logging.parameters.log_level', $envLogLevel);
    }
}
