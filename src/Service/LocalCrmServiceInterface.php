<?php

namespace DigitalMarketingFramework\LocalCrm\Service;

use DigitalMarketingFramework\Core\Context\ContextInterface;
use DigitalMarketingFramework\Core\Context\WriteableContextInterface;
use DigitalMarketingFramework\Core\Model\Data\Value\ValueInterface;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 */
interface LocalCrmServiceInterface
{
    /**
     * @param LocalCrmUserIdentifier $identifier
     *
     * @return ?array<string,string|ValueInterface>
     */
    public function read(IdentifierInterface $identifier): ?array;

    /**
     * @param LocalCrmUserIdentifier $identifier
     * @param array<string,string|ValueInterface> $data
     */
    public function write(IdentifierInterface $identifier, array $data): void;

    public function prepareContext(ContextInterface $source, WriteableContextInterface $target): void;

    /**
     * @return ?LocalCrmUserIdentifier
     */
    public function fetchIdentifierFromContext(ContextInterface $context): ?IdentifierInterface;

    /**
     * @return LocalCrmUserIdentifier
     */
    public function createIdentifier(): IdentifierInterface;
}
