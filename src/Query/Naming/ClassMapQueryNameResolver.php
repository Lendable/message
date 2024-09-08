<?php

declare(strict_types=1);

namespace Lendable\Message\Query\Naming;

use Lendable\Message\MessageName;
use Lendable\Message\Query\Query;

final readonly class ClassMapQueryNameResolver implements QueryNameResolver
{
    /**
     * @param array<class-string<Query>, non-empty-string> $map
     */
    public function __construct(private array $map) {}

    public function resolve(Query $query): MessageName
    {
        return MessageName::fromString($this->map[$query::class] ?? throw QueryNameNotResolvable::for($query));
    }
}
