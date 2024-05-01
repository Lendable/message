<?php

declare(strict_types=1);

namespace Lendable\Message;

use Ramsey\Uuid\Exception\InvalidArgumentException;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;

final readonly class MessageId implements Uuid
{
    private function __construct(private RamseyUuidInterface $uuid) {}

    public static function fromString(string $value): static
    {
        try {
            return new self(RamseyUuid::fromString($value));
        } catch (InvalidUuidStringException $exception) {
            throw InvalidUuidString::hexString($value, $exception);
        }
    }

    public static function generate(): self
    {
        return new self(RamseyUuid::uuid4());
    }

    public static function fromBinaryString(string $value): static
    {
        try {
            return new self(RamseyUuid::fromBytes($value));
        } catch (InvalidArgumentException $exception) {
            throw InvalidUuidString::binaryString($value, $exception);
        }
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function toBinary(): string
    {
        return $this->uuid->getBytes();
    }

    public function equals(MessageId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
