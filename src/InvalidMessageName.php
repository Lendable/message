<?php

declare(strict_types=1);

namespace Lendable\Message;

final class InvalidMessageName extends \InvalidArgumentException
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function empty(): self
    {
        return new self('Message name cannot be empty.');
    }
}
