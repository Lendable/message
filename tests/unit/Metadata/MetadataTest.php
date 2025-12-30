<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Metadata;

use Lendable\Message\CorrelationId;
use Lendable\Message\MessageId;
use Lendable\Message\MessageName;
use Lendable\Message\Metadata\Metadata;
use Lendable\Message\Metadata\MetadataKey;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Metadata::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class MetadataTest extends TestCase
{
    #[Test]
    public function created_from_an_array(): void
    {
        $metadata = Metadata::fromArray(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
        );

        self::assertSame('foo', $metadata->get(MetadataKey::MESSAGE_NAME->value));
        self::assertSame('ccc32a5b-3fb9-40a8-b366-5d863f536035', $metadata->get(MetadataKey::CAUSATION_ID->value));
        self::assertSame('9a040030-5a71-4a07-a469-4c005b47c686', $metadata->get(MetadataKey::CORRELATION_ID->value));

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
            $metadata->all(),
        );
    }

    /**
     * @param array<string, scalar> $input
     */
    #[Test]
    #[DataProvider('fromArrayParameterCombinations')]
    public function created_from_array_missing_mandatory_keys(array $input, \InvalidArgumentException $expectedException): void
    {
        $this->expectExceptionObject($expectedException);
        Metadata::fromArray($input);
    }

    /**
     * @return iterable<string, array{array<string, scalar>, \InvalidArgumentException}>
     */
    public static function fromArrayParameterCombinations(): iterable
    {
        $messageName = 'foo';
        $causationId = 'ccc32a5b-3fb9-40a8-b366-5d863f536035';
        $correlationId = '9a040030-5a71-4a07-a469-4c005b47c686';

        yield 'missing Message-Name' => [
            [MetadataKey::CAUSATION_ID->value => $causationId, MetadataKey::CORRELATION_ID->value => $correlationId],
            new \InvalidArgumentException('Metadata "Message-Name" is missing.'),
        ];

        yield 'incorrect type for Message-Name' => [
            [MetadataKey::MESSAGE_NAME->value => 0, MetadataKey::CAUSATION_ID->value => $causationId, MetadataKey::CORRELATION_ID->value => $correlationId],
            new \InvalidArgumentException('Metadata "Message-Name" is of the incorrect type. Expected string, got int.'),
        ];

        yield 'missing Causation-Id' => [
            [MetadataKey::CORRELATION_ID->value => $correlationId, MetadataKey::MESSAGE_NAME->value => $messageName],
            new \InvalidArgumentException('Metadata "Causation-Id" is missing.'),
        ];

        yield 'incorrect type for Causation-Id' => [
            [MetadataKey::MESSAGE_NAME->value => $messageName, MetadataKey::CAUSATION_ID->value => true, MetadataKey::CORRELATION_ID->value => $correlationId],
            new \InvalidArgumentException('Metadata "Causation-Id" is of the incorrect type. Expected string, got bool.'),
        ];

        yield 'missing Correlation-Id' => [
            [MetadataKey::CAUSATION_ID->value => $causationId, MetadataKey::MESSAGE_NAME->value => $messageName],
            new \InvalidArgumentException('Metadata "Correlation-Id" is missing.'),
        ];

        yield 'incorrect type for Correlation-Id' => [
            [MetadataKey::MESSAGE_NAME->value => $messageName, MetadataKey::CAUSATION_ID->value => $causationId, MetadataKey::CORRELATION_ID->value => 1.1],
            new \InvalidArgumentException('Metadata "Correlation-Id" is of the incorrect type. Expected string, got float.'),
        ];
    }

    #[Test]
    public function created_from_base(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
            $metadata->all(),
        );
    }

    #[Test]
    public function exposes_all_metadata(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $metadata = $metadata->with('foo', 'bar');

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'foo' => 'bar',
            ],
            $metadata->all(),
        );
    }

    #[Test]
    public function countable(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $metadata = $metadata->with('foo', 'bar');

        self::assertCount(4, $metadata);
    }

    #[Test]
    public function values_obtainable_by_key(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        self::assertSame('foo', $metadata->get(MetadataKey::MESSAGE_NAME->value));
    }

    #[Test]
    public function value_is_null_when_obtained_by_key_if_does_not_exist(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        self::assertNull($metadata->get('bar'));
    }

    #[Test]
    public function exposes_if_metadata_key_exists(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        self::assertFalse($metadata->has('bar'));
        self::assertTrue($metadata->has(MetadataKey::MESSAGE_NAME->value));
    }

    #[Test]
    public function clonable_with_new_metadata_key_value_pair(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $cloned = $metadata->with('bar', 'baz');

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
            $metadata->all(),
        );

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'bar' => 'baz',
            ],
            $cloned->all(),
        );
    }

    #[Test]
    public function clonable_with_multiple_new_metadata_key_value_pairs(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $cloned = $metadata->withMultiple(['bar' => 'baz', 'qux' => 'tux']);

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
            $metadata->all(),
        );

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'bar' => 'baz',
                'qux' => 'tux',
            ],
            $cloned->all(),
        );
    }

    #[Test]
    public function clonable_without_metadata_key(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $metadata = $metadata->with('foo', 'bar');

        $cloned = $metadata->without('foo');

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
                'foo' => 'bar',
            ],
            $metadata->all(),
        );

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
            $cloned->all(),
        );
    }

    #[Test]
    #[DataProvider('mandatoryMetadataKeys')]
    public function cannot_be_without_mandatory_keys(MetadataKey $key): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $this->expectExceptionObject(new \InvalidArgumentException(\sprintf('Metadata "%s" is mandatory.', $key->value)));
        $metadata->without($key->value);
    }

    /**
     * @return iterable<array{MetadataKey}>
     */
    public static function mandatoryMetadataKeys(): iterable
    {
        foreach (MetadataKey::cases() as $case) {
            yield [$case];
        }
    }

    #[Test]
    public function iterable(): void
    {
        $metadata = Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        );

        $foundMetadata = [];

        foreach ($metadata as $key => $value) {
            $foundMetadata[$key] = $value;
        }

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'foo',
                MetadataKey::CAUSATION_ID->value => 'ccc32a5b-3fb9-40a8-b366-5d863f536035',
                MetadataKey::CORRELATION_ID->value => '9a040030-5a71-4a07-a469-4c005b47c686',
            ],
            $foundMetadata,
        );
    }

    #[Test]
    public function throws_when_creating_from_array_with_non_string_keys(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid key "123", must be a string.'));

        Metadata::fromArray([ // @phpstan-ignore argument.type
            MetadataKey::MESSAGE_NAME->value => MessageName::fromString('foo')->toString(),
            MetadataKey::CAUSATION_ID->value => MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035')->toString(),
            MetadataKey::CORRELATION_ID->value => CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686')->toString(),
            123 => 456,
        ]);
    }

    #[Test]
    public function throws_when_creating_from_array_with_non_scalar_values(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid value for key "foo", must be a scalar, got a "array".'));

        Metadata::fromArray([ // @phpstan-ignore argument.type
            MetadataKey::MESSAGE_NAME->value => MessageName::fromString('foo')->toString(),
            MetadataKey::CAUSATION_ID->value => MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035')->toString(),
            MetadataKey::CORRELATION_ID->value => CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686')->toString(),
            'foo' => [1, 2, 3],
        ]);
    }

    #[Test]
    public function throws_when_adding_multiple_new_values_with_non_string_key(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid key "123", must be a string.'));

        Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        )->withMultiple(['foo' => 'bar', 123 => 'baz']); // @phpstan-ignore argument.type
    }

    #[Test]
    public function throws_when_adding_multiple_new_values_when_non_scalar_value(): void
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid value for key "bar", must be a scalar, got a "array".'));

        Metadata::base(
            MessageName::fromString('foo'),
            MessageId::fromString('ccc32a5b-3fb9-40a8-b366-5d863f536035'),
            CorrelationId::fromString('9a040030-5a71-4a07-a469-4c005b47c686'),
        )->withMultiple(['foo' => 'bar', 'bar' => [1, 2, 3]]); // @phpstan-ignore argument.type
    }
}
