<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Event\Naming;

use Lendable\Message\Event\Event;
use Lendable\Message\Event\Naming\EventNameNotResolvable;
use Lendable\Message\Event\Naming\EventNameResolver;
use Lendable\Message\MessageName;

final class ExampleEventNameResolver implements EventNameResolver
{
    public function resolve(Event $event): MessageName
    {
        return MessageName::fromString(
            ExampleEventMapping::MAP[$event::class] ?? throw EventNameNotResolvable::for($event),
        );
    }
}
