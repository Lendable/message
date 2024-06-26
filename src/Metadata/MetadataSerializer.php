<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

final class MetadataSerializer
{
    /**
     * @throws \RuntimeException If metadata cannot be serialized. A programmatic bug if this happens.
     */
    public function serialize(Metadata $metadata): string
    {
        try {
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
            // @codeCoverageIgnoreStart
        } catch (\JsonException $exception) {
            throw new \RuntimeException('Failed to serialize metadata.', previous: $exception);
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * @throws MetadataNotDeserializable
     */
    public function deserialize(string $serializedMetadata): Metadata
    {
        try {
            /** @var array<string, scalar> $metadata */
            $metadata = \json_decode($serializedMetadata, true, flags: \JSON_THROW_ON_ERROR);

            return Metadata::fromArray($metadata);
        } catch (\Exception $exception) {
            throw MetadataNotDeserializable::dueTo($exception);
        }
    }
}
