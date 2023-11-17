<?php

namespace DigitalMarketingFramework\LocalCrm\DataDispatcher;

use DigitalMarketingFramework\Core\Exception\DigitalMarketingFrameworkException;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;
use DigitalMarketingFramework\Distributor\Core\DataDispatcher\DataDispatcher;
use DigitalMarketingFramework\Distributor\Core\Registry\RegistryInterface;
use DigitalMarketingFramework\LocalCrm\Service\LocalCrmServiceInterface;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 */
class LocalCrmDataDispatcher extends DataDispatcher
{
    protected ?IdentifierInterface $identifier = null;

    /**
     * @param LocalCrmServiceInterface<LocalCrmUserIdentifier> $crm
     */
    public function __construct(
        string $keyword,
        RegistryInterface $registry,
        protected LocalCrmServiceInterface $crm
    ) {
        parent::__construct($keyword, $registry);
    }

    public function setIdentifier(IdentifierInterface $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function send(array $data): void
    {
        if (!$this->identifier instanceof IdentifierInterface) {
            throw new DigitalMarketingFrameworkException('No CRM user identifier given');
        }

        $crmData = $this->crm->read($this->identifier) ?? [];
        foreach ($data as $key => $value) {
            $crmData[$key] = $value;
        }

        $this->crm->write($this->identifier, $crmData);
    }
}
