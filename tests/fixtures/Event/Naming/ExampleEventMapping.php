<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Event\Naming;

use Tests\Fixtures\Lendable\Message\Event\ExampleBarEvent;
use Tests\Fixtures\Lendable\Message\Event\ExampleBazEvent;
use Tests\Fixtures\Lendable\Message\Event\ExampleFooEvent;

final class ExampleEventMapping
{
    /** @codeCoverageIgnore  */
    private function __construct() {}

    public const MAP = [
        ExampleFooEvent::class => 'example.event.foo',
        ExampleBarEvent::class => 'example.event.bar',
        ExampleBazEvent::class => 'example.event.baz',
    ];
}
