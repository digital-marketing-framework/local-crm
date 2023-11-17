<?php

namespace DigitalMarketingFramework\LocalCrm\Route;

use DigitalMarketingFramework\Core\Context\ContextInterface;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;
use DigitalMarketingFramework\Distributor\Core\DataDispatcher\DataDispatcherInterface;
use DigitalMarketingFramework\Distributor\Core\Model\DataSet\SubmissionDataSetInterface;
use DigitalMarketingFramework\Distributor\Core\Registry\RegistryInterface;
use DigitalMarketingFramework\Distributor\Core\Route\Route;
use DigitalMarketingFramework\LocalCrm\DataDispatcher\LocalCrmDataDispatcher;
use DigitalMarketingFramework\LocalCrm\Service\LocalCrmServiceInterface;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 */
class LocalCrmRoute extends Route
{
    /**
     * @param LocalCrmServiceInterface<LocalCrmUserIdentifier> $crm
     */
    public function __construct(
        string $keyword,
        RegistryInterface $registry,
        SubmissionDataSetInterface $submission,
        string $routeId,
        protected LocalCrmServiceInterface $crm
    ) {
        parent::__construct($keyword, $registry, $submission, $routeId);
    }

    public function enabled(): bool
    {
        // TODO implement data privacy elements here?
        //      or should those be implemented in the parent class for all routes?
        return parent::enabled();
    }

    protected function getDispatcher(): DataDispatcherInterface
    {
        /** @var LocalCrmDataDispatcher<LocalCrmUserIdentifier> */
        $dispatcher = $this->registry->getDataDispatcher('localCrm');

        $identifier = $this->crm->fetchIdentifierFromContext($this->submission->getContext());
        $dispatcher->setIdentifier($identifier);

        return $dispatcher;
    }

    public function addContext(ContextInterface $context): void
    {
        parent::addContext($context);
        $this->crm->prepareContext($context, $this->submission->getContext());
    }
}
