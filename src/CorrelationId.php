<?php

declare(strict_types=1);

namespace Lendable\Message;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

/**
 * An identifier that crosses multiple commands/events.
 *
 * This is generated at the initiation point of a flow
 * and carried through to all subsequent messages to
 * enable tracking of the flow.
 */
final class CorrelationId implements Uuid
{
    private function __construct(private readonly UuidInterface $uuid) {}

    public static function generate(): self
    {
        return new self(RamseyUuid::uuid4());
    }

    public static function fromString(string $id): static
    {
        return new self(RamseyUuid::fromString($id));
    }

    public static function fromBinaryString(string $id): static
    {
        return new self(RamseyUuid::fromBytes($id));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function toBinary(): string
    {
        return $this->uuid->getBytes();
    }

    public function equals(CorrelationId $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
