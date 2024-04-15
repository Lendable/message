<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

use Lendable\Message\CorrelationId;
use Lendable\Message\InvalidMessageName;
use Lendable\Message\InvalidUuidString;
use Lendable\Message\MessageId;
use Lendable\Message\MessageName;

/**
 * Metadata associated with a message.
 *
 * @template-implements \IteratorAggregate<string, scalar>
 */
final class Metadata implements \Countable, \IteratorAggregate
{
    /**
     * @var array<string, scalar>
     */
    private readonly array $additionalMetadata;

    /**
     * @param array<string, scalar> $metadata
     */
    private function __construct(
        public readonly MessageName $messageName,
        public readonly MessageId $causationId,
        public readonly CorrelationId $correlationId,
        array $metadata,
    ) {
        unset(
            $metadata[MetadataKey::MESSAGE_NAME->value],
            $metadata[MetadataKey::CAUSATION_ID->value],
            $metadata[MetadataKey::CORRELATION_ID->value],
        );

        $this->additionalMetadata = $metadata;
    }

    /**
     * Creates metadata with only the mandatory values set.
     */
    public static function base(MessageName $messageName, MessageId $causationId, CorrelationId $correlationId): self
    {
        return new self($messageName, $causationId, $correlationId, []);
    }

    /**
     * Constructs metadata from an array, the array must contain the keys "Message-Name", "Correlation-Id" and
     * "Causation-Id", containing their respective values.
     *
     * @param array<string, scalar> $metadata
     *
     * @throws \InvalidArgumentException If "Message-Name", "Causation-Id" and/or "Correlation-Id" are missing from
     * the array, or are not string values.
     * @throws InvalidMessageName If the "Message-Name" key is invalid.
     * @throws InvalidUuidString If the "Message-Id" key is not a hex encoded UUID string.
     * @throws InvalidUuidString If the "Correlation-Id" key is not a hex encoded UUID string.
     */
    public static function fromArray(array $metadata): self
    {
        return new self(
            MessageName::fromString(self::extractValue($metadata, MetadataKey::MESSAGE_NAME)),
            MessageId::fromString(self::extractValue($metadata, MetadataKey::CAUSATION_ID)),
            CorrelationId::fromString(self::extractValue($metadata, MetadataKey::CORRELATION_ID)),
            $metadata,
        );
    }

    /**
     * @return array<string, scalar>
     */
    public function all(): array
    {
        return $this->flatten();
    }

    public function count(): int
    {
        return \count($this->additionalMetadata) + \count(MetadataKey::cases());
    }

    public function get(string $key): string|int|bool|float|null
    {
        return match ($key) {
            MetadataKey::CORRELATION_ID->value => $this->correlationId->toString(),
            MetadataKey::CAUSATION_ID->value => $this->causationId->toString(),
            MetadataKey::MESSAGE_NAME->value => $this->messageName->toString(),
            default => $this->additionalMetadata[$key] ?? null,
        };
    }

    public function has(string $key): bool
    {
        return MetadataKey::tryFrom($key) instanceof MetadataKey || isset($this->additionalMetadata[$key]);
    }

    public function with(string $key, string|int|bool|float $value): self
    {
        return new self(
            $this->messageName,
            $this->causationId,
            $this->correlationId,
            \array_merge($this->additionalMetadata, [$key => $value]),
        );
    }

    /**
     * @param array<string, scalar> $pairs
     */
    public function withMultiple(array $pairs): self
    {
        return new self(
            $this->messageName,
            $this->causationId,
            $this->correlationId,
            \array_merge($this->additionalMetadata, $pairs),
        );
    }

    /**
     * @throws \InvalidArgumentException If the metadata key is mandatory.
     */
    public function without(string $key): self
    {
        if (MetadataKey::tryFrom($key) instanceof MetadataKey) {
            throw new \InvalidArgumentException(\sprintf('Metadata "%s" is mandatory.', $key));
        }

        $metadata = $this->additionalMetadata;
        unset($metadata[$key]);

        return new self($this->messageName, $this->causationId, $this->correlationId, $metadata);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->flatten());
    }

    /**
     * @param array<string, scalar> $metadata
     */
    private static function extractValue(array $metadata, MetadataKey $key): string
    {
        $value = $metadata[$key->value] ?? throw new \InvalidArgumentException(\sprintf('Metadata "%s" is missing.', $key->value));

        if (!\is_string($value)) {
            throw new \InvalidArgumentException(
                \sprintf(
                    'Metadata "%s" is of the incorrect type. Expected string, got %s.',
                    $key->value,
                    \get_debug_type($value),
                ),
            );
        }

        return $value;
    }

    /**
     * @return array<string, scalar>
     */
    private function flatten(): array
    {
        return \array_merge(
            [
                MetadataKey::MESSAGE_NAME->value => $this->messageName->toString(),
                MetadataKey::CAUSATION_ID->value => $this->causationId->toString(),
                MetadataKey::CORRELATION_ID->value => $this->correlationId->toString(),
            ],
            $this->additionalMetadata,
        );
    }
}