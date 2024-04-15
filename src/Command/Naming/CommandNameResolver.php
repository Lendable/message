<?php

declare(strict_types=1);

namespace Lendable\Message\Command\Naming;

use Lendable\Message\Command\Command;
use Lendable\Message\MessageName;

interface CommandNameResolver
{
    /**
     * @throws CommandNameNotResolvable
     */
    public function resolve(Command $command): MessageName;
}
