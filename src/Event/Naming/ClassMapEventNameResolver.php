<?php

declare(strict_types=1);

namespace Lendable\Message\Event\Naming;

use Lendable\Message\Event\Event;
use Lendable\Message\InvalidMessageName;
use Lendable\Message\MessageName;

final readonly class ClassMapEventNameResolver implements EventNameResolver
{
    /**
     * @param array<class-string<Event>, non-empty-string> $map
     */
    public function __construct(private array $map) {}

    public function resolve(Event $event): MessageName
    {
        try {
            return MessageName::fromString($this->map[$event::class] ?? throw EventNameNotResolvable::for($event));
        } catch (InvalidMessageName $e) {
            throw EventNameNotResolvable::for($event, $e);
        }
    }
}
