<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Metadata;

use Lendable\Message\CorrelationId;
use Lendable\Message\MessageId;
use Lendable\Message\MessageName;
use Lendable\Message\Metadata\Metadata;
use Lendable\Message\Metadata\MetadataKey;
use Lendable\Message\Metadata\MetadataSerializer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetadataSerializer::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class MetadataSerializerTest extends TestCase
{
    #[Test]
    public function metadata_is_json_dictionary(): void
    {
        $metadata = Metadata::fromArray(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
        );

        self::assertSame(
            '{"Message-Name":"foo","Causation-Id":"ccc32a5b-3fb9-40a8-b366-5d863f536035","Correlation-Id":"9a040030-5a71-4a07-a469-4c005b47c686"}',
            (new MetadataSerializer())->serialize($metadata),
        );
    }

    #[Test]
    public function floats_maintain_type(): void
    {
        $metadata = Metadata::fromArray(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'foo' => 1.0,
            ],
        );

        $serializer = new MetadataSerializer();
        $serialized = $serializer->serialize($metadata);

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'foo' => 1.0,
            ],
            $serializer->deserialize($serialized)->all(),
        );
    }

    #[Test]
    public function deserializes_serialized_data_to_same_representation(): void
    {
        $metadata = Metadata::fromArray(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'foo' => 'bar',
            ],
        );
        $serializer = new MetadataSerializer();

        $deserializedMetadata = $serializer->deserialize($serializer->serialize($metadata));

        self::assertCount(4, $deserializedMetadata);

        self::assertSame('foo', $deserializedMetadata->get(MetadataKey::MESSAGE_NAME->value));
        self::assertEquals(MessageName::fromString('foo'), $deserializedMetadata->messageName);

        self::assertSame('ccc32a5b-3fb9-40a8-b366-5d863f536035', $deserializedMetadata->get(MetadataKey::CAUSATION_ID->value));
        self::assertEquals(MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'), $deserializedMetadata->causationId);

        self::assertSame('9a040030-5a71-4a07-a469-4c005b47c686', $deserializedMetadata->get(MetadataKey::CORRELATION_ID->value));
        self::assertEquals(CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'), $deserializedMetadata->correlationId);

        self::assertSame('bar', $deserializedMetadata->get('foo'));
    }
}
