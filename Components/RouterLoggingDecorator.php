<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Components;

use nlxExtendedShopwareLogging\Service\ConfigService;
use nlxExtendedShopwareLogging\Services\LoggerService;
use Shopware\Components\Routing\Context;
use Shopware\Components\Routing\Router;

class RouterLoggingDecorator extends Router
{
    /** @var LoggerService */
    protected $logger;

    public function setLogger(LoggerService $logger): void
    {
        $this->logger = $logger;
    }

    public function assemble($userParams = [], Context $context = null)
    {
        $assembledLink = parent::assemble($userParams, $context);

        $this->logger->log('Router assemble', [
            'userParams' => $userParams,
            'assembledLink' => $assembledLink,
            'context' => empty($context) ? $context : $context->jsonSerialize(),
        ]);

        return $assembledLink;
    }
}