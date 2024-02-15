<?php

declare(strict_types=1);

namespace Lendable\Message;

interface Uuid
{
    /**
     * @throws InvalidUuidString If the string is not a UUID.
     */
    public static function fromBinaryString(string $value): static;

    /**
     * @throws InvalidUuidString If the string is not a UUID.
     */
    public static function fromString(string $value): static;

    /**
     * @return non-empty-string
     */
    public function toString(): string;

    /**
     * @return non-empty-string
     */
    public function toBinary(): string;
}
