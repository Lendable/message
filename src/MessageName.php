<?php

declare(strict_types=1);

namespace Lendable\Message;

final class MessageName
{
    /**
     * @var non-empty-string
     */
    private readonly string $name;

    /**
     * @throws InvalidMessageName If the message name is empty.
     */
    private function __construct(string $name)
    {
        if (\trim($name) === '') {
            throw InvalidMessageName::empty();
        }
        /** @var non-empty-string $name */
        $this->name = $name;
    }

    /**
     * @throws InvalidMessageName If the message name is empty.
     */
    public static function fromString(string $name): self
    {
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
