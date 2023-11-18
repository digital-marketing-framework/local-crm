<?php

namespace DigitalMarketingFramework\LocalCrm\Service;

use DigitalMarketingFramework\Core\Model\Data\Value\ValueInterface;
use DigitalMarketingFramework\Core\Model\Identifier\IdentifierInterface;
use DigitalMarketingFramework\Core\Utility\GeneralUtility;

/**
 * @template LocalCrmUserIdentifier of IdentifierInterface
 *
 * @implements LocalCrmServiceInterface<LocalCrmUserIdentifier>
 */
abstract class AbstractLocalCrmService implements LocalCrmServiceInterface
{
    /**
     * @param array<string,string|ValueInterface> $data
     *
     * @return array<string,array{type:string,value:mixed}>
     */
    protected function packData(array $data): array
    {
        $packed = [];
        foreach ($data as $key => $value) {
            $packed[$key] = GeneralUtility::packValue($value);
        }

        return $packed;
    }

    /**
     * @param array<string,array{type:string,value:mixed}> $packed
     *
     * @return array<string,string|ValueInterface>
     */
    protected function unpackData(array $packed): array
    {
        $data = [];
        foreach ($packed as $key => $value) {
            $data[$key] = GeneralUtility::unpackValue($value);
        }

        return $data;
    }

    /**
     * @param array<string,string|ValueInterface> $data
     */
    protected function encodeData(array $data): string
    {
        return json_encode($this->packData($data), flags: JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string,string|ValueInterface>
     */
    protected function decodeData(string $encodedData): array
    {
        if ($encodedData === '') {
            return [];
        }

        return $this->unpackData(json_decode($encodedData, associative: true, flags: JSON_THROW_ON_ERROR));
    }
}
