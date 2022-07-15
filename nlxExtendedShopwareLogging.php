<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging;

use Shopware\Components\Plugin;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class nlxExtendedShopwareLogging extends Plugin
{
    const LOGGING_ENVIRONMENT_KEY = 'LOGGING_ENV';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $loggingEnvironment = \getenv(self::LOGGING_ENVIRONMENT_KEY);
        if (false === empty($loggingEnvironment) && 'dev' === $loggingEnvironment) {
            $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/Resources/Services/'));
            $loader->load('dev.xml');
        }
    }
}
