<?php

declare(strict_types=1);

namespace Lendable\Message;

final readonly class MessageName
{
    /**
     * @param non-empty-string $name
     */
    private function __construct(private string $name) {}

    /**
     * @throws InvalidMessageName If the message name is empty.
     *
     * @phpstan-assert non-empty-string $name
     */
    public static function fromString(string $name): self
    {
        if (\trim($name) === '') {
            throw InvalidMessageName::empty();
        }

        /** @var non-empty-string $name */

        return new self($name);
    }

    /**
     * @return non-empty-string
     */
    public function toString(): string
    {
        return $this->name;
    }

    public function equals(MessageName $other): bool
    {
        return $this->name === $other->name;
    }
}
