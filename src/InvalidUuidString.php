<?php

declare(strict_types=1);

namespace Lendable\Message;

final class InvalidUuidString extends \InvalidArgumentException
{
    private function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, previous: $previous);
    }

    public static function hexString(string $string, ?\Throwable $previous = null): self
    {
        return new self(\sprintf('String "%s" is not a valid UUID hex string.', $string), $previous);
    }

    public static function binaryString(string $string, ?\Throwable $previous = null): self
    {
        return new self(\sprintf('String "%s" is not a valid UUID byte string.', $string), $previous);
    }
}
