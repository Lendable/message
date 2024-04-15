<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Command\Naming;

use Tests\Fixtures\Lendable\Message\Command\ExampleBarCommand;
use Tests\Fixtures\Lendable\Message\Command\ExampleBazCommand;
use Tests\Fixtures\Lendable\Message\Command\ExampleFooCommand;

final class ExampleCommandMapping
{
    public const MAP = [
        ExampleFooCommand::class => 'example.command.foo',
        ExampleBarCommand::class => 'example.command.bar',
        ExampleBazCommand::class => 'example.command.baz',
    ];
}
