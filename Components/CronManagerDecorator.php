<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxExtendedShopwareLogging\Components;

use Enlight_Components_Cron_Adapter;
use Enlight_Components_Cron_Job;
use Enlight_Components_Cron_Manager;
use Enlight_Event_EventManager;
use nlxExtendedShopwareLogging\Services\LoggerService;

class CronManagerDecorator extends Enlight_Components_Cron_Manager
{
    /** @var LoggerService */
    protected $logger;

    public function __construct(
        Enlight_Components_Cron_Adapter $adapter,
        Enlight_Event_EventManager $eventManager,
        string $eventArgsClass = null
    ) {
        parent::__construct($adapter, $eventManager, $eventArgsClass);
    }

    public function setLogger(LoggerService $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function runJob(Enlight_Components_Cron_Job $job)
    {
        $this->logger->notice(\sprintf('[cron] started cron: %s', $job->getName()), [
            'startDate' => $job->getStart(),
            'endDate'   => $job->getEnd(),
            'nextDate'  => $job->getNext(),
            'interval'  => $job->getInterval(),
        ]);
        parent::runJob($job);
    }

    /**
     * {@inheritdoc}
     */
    public function endJob(Enlight_Components_Cron_Job $job)
    {
        $this->logger->notice(\sprintf('[cron] cron finished: %s', $job->getName()), [
            'startDate' => $job->getStart(),
            'endDate'   => $job->getEnd(),
            'nextDate'  => $job->getNext(),
            'interval'  => $job->getInterval(),
        ]);
        parent::endJob($job);
    }
}
