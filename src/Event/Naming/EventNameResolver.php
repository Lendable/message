<?php

declare(strict_types=1);

namespace Lendable\Message\Event\Naming;

use Lendable\Message\Event\Event;
use Lendable\Message\MessageName;

interface EventNameResolver
{
    /**
     * @throws EventNameNotResolvable
     */
    public function resolve(Event $event): MessageName;
}
