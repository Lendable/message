<?php

declare(strict_types=1);

namespace Lendable\Message\Command\Naming;

use Lendable\Message\Command\Command;
use Lendable\Message\InvalidMessageName;
use Lendable\Message\MessageName;

final readonly class ClassMapCommandNameResolver implements CommandNameResolver
{
    /**
     * @param array<class-string<Command>, non-empty-string> $map
     */
    public function __construct(private array $map) {}

    public function resolve(Command $command): MessageName
    {
        try {
            return MessageName::fromString($this->map[$command::class] ?? throw CommandNameNotResolvable::for($command));
        } catch (InvalidMessageName $e) {
            throw CommandNameNotResolvable::for($command, $e);
        }
    }
}
