<?php

declare(strict_types=1);

namespace Lendable\Message\Command\Naming;

use Lendable\Message\Command\Command;

final class CommandNameNotResolvable extends \RuntimeException
{
    private function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, previous: $previous);
    }

    public static function for(Command $command, ?\Throwable $previous = null): self
    {
        return new self(
            \sprintf('Command message name for %s<%s> could not be resolved.', $command::class, $command->id()->toString()),
            $previous,
        );
    }
}
