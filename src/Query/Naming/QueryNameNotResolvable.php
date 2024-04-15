<?php

declare(strict_types=1);

namespace Lendable\Message\Query\Naming;

use Lendable\Message\Query\Query;

final class QueryNameNotResolvable extends \RuntimeException
{
    private function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, previous: $previous);
    }

    public static function for(Query $query, ?\Throwable $previous = null): self
    {
        return new self(
            \sprintf('Query message name for %s<%s> could not be resolved.', $query::class, $query->id()->toString()),
            $previous,
        );
    }
}
