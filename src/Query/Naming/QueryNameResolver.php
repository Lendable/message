<?php

declare(strict_types=1);

namespace Lendable\Message\Query\Naming;

use Lendable\Message\MessageName;
use Lendable\Message\Query\Query;

interface QueryNameResolver
{
    /**
     * @throws QueryNameNotResolvable
     */
    public function resolve(Query $query): MessageName;
}
