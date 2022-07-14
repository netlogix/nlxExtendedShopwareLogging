<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Factory;

use Enlight_Event_EventManager as EnlightEventManager;
use nlxExtendedShopwareLogging\Components\RouterLoggingDecorator;
use Shopware\Components\DependencyInjection\Bridge\Router;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\RouterInterface;

class RouterLoggingDecoratorFactory extends Router
{
    public function factory(
        EnlightEventManager $eventManager,
        iterable $matchers,
        iterable $generators,
        iterable $preFilters,
        iterable $postFilters
    ): RouterInterface
    {
        $router = new RouterLoggingDecorator(
            Context::createEmpty(),
            $this->convertIteratorToArray($matchers),
            $this->convertIteratorToArray($generators),
            $this->convertIteratorToArray($preFilters),
            $this->convertIteratorToArray($postFilters)
        );

        $eventManager->addListener(
            'Enlight_Bootstrap_AfterRegisterResource_Shop',
            [$this, 'onAfterRegisterShop'],
            -100
        );

        $eventManager->addListener(
            'Enlight_Controller_Front_PreDispatch',
            [$this, 'onPreDispatch'],
            -100
        );

        return $router;
    }

    private function convertIteratorToArray(iterable $iterator): array
    {
        if (\is_array($iterator)) {
            return $iterator;
        }

        return iterator_to_array($iterator, false);
    }
}