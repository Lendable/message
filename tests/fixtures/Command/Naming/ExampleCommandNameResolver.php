<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Command\Naming;

use Lendable\Message\Command\Command;
use Lendable\Message\Command\Naming\CommandNameNotResolvable;
use Lendable\Message\Command\Naming\CommandNameResolver;
use Lendable\Message\MessageName;

final class ExampleCommandNameResolver implements CommandNameResolver
{
    public function resolve(Command $command): MessageName
    {
        return MessageName::fromString(
            ExampleCommandMapping::MAP[$command::class] ?? throw CommandNameNotResolvable::for($command),
        );
    }
}
