<?php

namespace DigitalMarketingFramework\LocalCrm\IdentifierCollector;

use DigitalMarketingFramework\Core\Context\ContextInterface;
use DigitalMarketingFramework\Core\Context\WriteableContextInterface;
use DigitalMarketingFramework\Core\IdentifierCollector\IdentifierCollector;
use DigitalMarketingFramework\Core\Model\Configuration\ConfigurationInterface;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;
use DigitalMarketingFramework\Core\Registry\RegistryInterface;
use DigitalMarketingFramework\LocalCrm\Service\LocalCrmServiceInterface;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 */
class LocalCrmIdentifierCollector extends IdentifierCollector
{
    /**
     * @param LocalCrmServiceInterface<LocalCrmUserIdentifier> $crm
     */
    public function __construct(
        string $keyword,
        RegistryInterface $registry,
        ConfigurationInterface $identifiersConfiguration,
        protected LocalCrmServiceInterface $crm,
    ) {
        parent::__construct($keyword, $registry, $identifiersConfiguration);
    }

    protected function prepareContext(ContextInterface $source, WriteableContextInterface $target): void
    {
        $this->crm->prepareContext($source, $target);
    }

    protected function collect(ContextInterface $context): ?IdentifierInterface
    {
        return $this->crm->fetchIdentifierFromContext($context);
    }
}
