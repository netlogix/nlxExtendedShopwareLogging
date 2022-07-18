<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Services;

use Psr\Log\LoggerInterface;

class LoggerService implements LoggerInterface
{
    const SHOPWARE_LOG_LEVEL = 'warning';

    const NLX_LOG_LEVEL_EMERGENCY = 'EMERGENCY';
    const NLX_LOG_LEVEL_ALERT     = 'ALERT';
    const NLX_LOG_LEVEL_CRITICAL  = 'CRITICAL';
    const NLX_LOG_LEVEL_ERROR     = 'ERROR';
    const NLX_LOG_LEVEL_WARNING   = 'WARNING';
    const NLX_LOG_LEVEL_NOTICE    = 'NOTICE';
    const NLX_LOG_LEVEL_INFO      = 'INFO';
    const NLX_LOG_LEVEL_DEBUG     = 'DEBUG';

    const NLX_LOG_LEVELS = [
        self::NLX_LOG_LEVEL_EMERGENCY => 8,
        self::NLX_LOG_LEVEL_ALERT     => 7,
        self::NLX_LOG_LEVEL_CRITICAL  => 6,
        self::NLX_LOG_LEVEL_ERROR     => 5,
        self::NLX_LOG_LEVEL_WARNING   => 4,
        self::NLX_LOG_LEVEL_NOTICE    => 3,
        self::NLX_LOG_LEVEL_INFO      => 2,
        self::NLX_LOG_LEVEL_DEBUG     => 1,
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

    /**
     * {@inheritdoc}
     */
    public function emergency($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_EMERGENCY, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function alert($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_ALERT, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function critical($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_CRITICAL, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_ERROR, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function warning($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_WARNING, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_NOTICE, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_INFO, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function debug($message, array $context = []): void
    {
        $this->log(self::NLX_LOG_LEVEL_DEBUG, $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = []): void
    {
        if (self::NLX_LOG_LEVELS[$level] < $this->currentLogLevel) {
            return;
        }
        $this->logger->log(self::SHOPWARE_LOG_LEVEL, \sprintf('[nlxLogging][%s]: ', $level) . $message, $context);
    }
}
