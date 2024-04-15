<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

final class MetadataSerializer
{
    /**
     * @throws \JsonException
     */
    public function serialize(Metadata $metadata): string
    {
        return \json_encode(
            $metadata->all(),
            \JSON_FORCE_OBJECT |
            \JSON_HEX_TAG |
            \JSON_HEX_APOS |
            \JSON_HEX_AMP |
            \JSON_HEX_QUOT |
            \JSON_UNESCAPED_UNICODE |
            \JSON_PRESERVE_ZERO_FRACTION |
            \JSON_THROW_ON_ERROR,
        );
    }

    /**
     * @throws \JsonException
     */
    public function deserialize(string $serializedMetadata): Metadata
    {
        /** @var array<string, scalar> $metadata */
        $metadata = \json_decode($serializedMetadata, true, flags: \JSON_THROW_ON_ERROR);

        return Metadata::fromArray($metadata);
    }
}