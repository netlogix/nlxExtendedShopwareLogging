<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Services;

use Psr\Log\LoggerInterface;

class LoggerService
{
    const LOG_LEVEL = 'warning';

    /** @var LoggerInterface */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param mixed[] $context
     */
    public function log(string $message, array $context): void
    {
        $this->logger->log(self::LOG_LEVEL, $message, $context);
    }
}
