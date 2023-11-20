<?php

namespace DigitalMarketingFramework\LocalCrm\DataCollector;

use DigitalMarketingFramework\Collector\Core\DataCollector\DataCollector;
use DigitalMarketingFramework\Collector\Core\Model\Configuration\CollectorConfigurationInterface;
use DigitalMarketingFramework\Collector\Core\Model\Result\DataCollectorResult;
use DigitalMarketingFramework\Collector\Core\Model\Result\DataCollectorResultInterface;
use DigitalMarketingFramework\Collector\Core\Registry\RegistryInterface;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;
use DigitalMarketingFramework\Core\Utility\GeneralUtility;
use DigitalMarketingFramework\LocalCrm\Service\LocalCrmServiceInterface;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 */
class LocalCrmDataCollector extends DataCollector
{
    /**
     * @param LocalCrmServiceInterface<LocalCrmUserIdentifier> $crm
     */
    public function __construct(
        string $keyword,
        RegistryInterface $registry,
        CollectorConfigurationInterface $collectorConfiguration,
        protected LocalCrmServiceInterface $crm,
    ) {
        parent::__construct($keyword, $registry, $collectorConfiguration);
    }

    protected function collect(IdentifierInterface $identifier): ?DataCollectorResultInterface
    {
        $data = $this->crm->read($identifier);
        if ($data === null) {
            return null;
        }

        $identifiers = [$identifier];
        $data = GeneralUtility::castArrayToData($data);

        return new DataCollectorResult($data, $identifiers);
    }

    public static function getLabel(): ?string
    {
        return 'Local CRM';
    }
}
