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
use Shopware\Components\Routing\Matchers\RewriteMatcher;

class RewriteMatcherLoggingDecorator extends RewriteMatcher
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
    public function match($seoPathInfo, Context $context)
    {
        $pathInfo = parent::match($seoPathInfo, $context);

        $this->logger->log('SEO table access', [
            'incomingSeoUrl' => $seoPathInfo,
            'resolvedPathInfo' => $pathInfo,
        ]);

        return $pathInfo;
    }
}
