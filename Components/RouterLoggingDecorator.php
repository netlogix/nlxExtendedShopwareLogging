<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Components;

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

    /**
     * {@inheritdoc}
     */
    public function assemble($userParams = [], Context $context = null)
    {
        $assembledLink = parent::assemble($userParams, $context);

        $this->logger->debug('Router assemble', [
            'userParams' => $userParams,
            'assembledLink' => $assembledLink,
            'context' => empty($context) ? $context : $context->jsonSerialize(),
        ]);

        return $assembledLink;
    }
}
