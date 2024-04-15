<?php

declare(strict_types=1);

namespace Lendable\Message\Event\Naming;

use Lendable\Message\Event\Event;

final class EventNameNotResolvable extends \RuntimeException
{
    private function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, previous: $previous);
    }

    public static function for(Event $event, ?\Throwable $previous = null): self
    {
        return new self(
            \sprintf('Event message name for %s<%s> could not be resolved.', $event::class, $event->id()->toString()),
            $previous,
        );
    }
}
