<?php

namespace DigitalMarketingFramework\LocalCrm;

use DigitalMarketingFramework\Collector\Core\DataCollector\DataCollectorInterface;
use DigitalMarketingFramework\Core\IdentifierCollector\IdentifierCollectorInterface;
use DigitalMarketingFramework\Core\Initialization;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;
use DigitalMarketingFramework\Core\Registry\RegistryDomain;
use DigitalMarketingFramework\Core\Registry\RegistryInterface;
use DigitalMarketingFramework\Distributor\Core\DataDispatcher\DataDispatcherInterface;
use DigitalMarketingFramework\Distributor\Core\Route\RouteInterface;
use DigitalMarketingFramework\LocalCrm\DataCollector\LocalCrmDataCollector;
use DigitalMarketingFramework\LocalCrm\DataDispatcher\LocalCrmDataDispatcher;
use DigitalMarketingFramework\LocalCrm\IdentifierCollector\LocalCrmIdentifierCollector;
use DigitalMarketingFramework\LocalCrm\Route\LocalCrmRoute;
use DigitalMarketingFramework\LocalCrm\Service\LocalCrmServiceInterface;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 */
class LocalCrmInitialization extends Initialization
{
    protected const PLUGINS = [
        RegistryDomain::CORE => [
            IdentifierCollectorInterface::class => [
                LocalCrmIdentifierCollector::class,
            ],
        ],
        RegistryDomain::COLLECTOR => [
            DataCollectorInterface::class => [
                LocalCrmDataCollector::class,
            ],
        ],
        RegistryDomain::DISTRIBUTOR => [
            RouteInterface::class => [
                LocalCrmRoute::class,
            ],
            DataDispatcherInterface::class => [
                LocalCrmDataDispatcher::class,
            ],
        ],
    ];

    protected const SCHEMA_MIGRATIONS = [];

    /**
     * @param LocalCrmServiceInterface<LocalCrmUserIdentifier> $crm
     */
    public function __construct(
        protected LocalCrmServiceInterface $crm,
        string $packageAlias = ''
    ) {
        parent::__construct('local-crm', '1.0.0', $packageAlias);
    }

    protected function getAdditionalPluginArguments(string $interface, string $pluginClass, RegistryInterface $registry): array
    {
        if (
            in_array(
                $pluginClass,
                [
                    LocalCrmIdentifierCollector::class,
                    LocalCrmDataCollector::class,
                    LocalCrmRoute::class,
                    LocalCrmDataDispatcher::class,
                ],
                true
            )
        ) {
            return [$this->crm];
        }

        return parent::getAdditionalPluginArguments($interface, $pluginClass, $registry);
    }
}
