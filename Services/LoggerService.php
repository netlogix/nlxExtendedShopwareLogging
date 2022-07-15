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
    const SHOPWARE_LOG_LEVEL = 'warning';

    const NLX_LOG_LEVEL_BASIC = 'BASIC';
    const NLX_LOG_LEVEL_INFO = 'INFO';
    const NLX_LOG_LEVEL_DEBUG = 'DEBUG';

    const NLX_LOG_LEVELS = [
        self::NLX_LOG_LEVEL_BASIC => 3,
        self::NLX_LOG_LEVEL_INFO  => 2,
        self::NLX_LOG_LEVEL_DEBUG => 1,
    ];

    /** @var LoggerInterface */
    protected $logger;

    /** @var int */
    protected $currentLogLevel;

    public function __construct(LoggerInterface $logger, string $currentLogLevel)
    {
        $this->logger = $logger;
        $this->currentLogLevel = self::NLX_LOG_LEVELS[$currentLogLevel];
    }

    public function basic(string $message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_BASIC, $message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_INFO, $message, $context);
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_DEBUG, $message, $context);
    }

    /**
     * @param mixed[] $context
     */
    public function log(string $level, string $message, array $context): void
    {
        if (self::NLX_LOG_LEVELS[$level] < $this->currentLogLevel) {
            return;
        }
        $this->logger->log(self::SHOPWARE_LOG_LEVEL, sprintf('[nlxLogging][%s]: ', $level) . $message, $context);
    }
}
