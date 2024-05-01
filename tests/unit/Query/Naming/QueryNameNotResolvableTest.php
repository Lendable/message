<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Query\Naming;

use Lendable\Message\CorrelationId;
use Lendable\Message\Query\Naming\QueryNameNotResolvable;
use Lendable\Message\Query\Query;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\Query\ExampleFooQuery;

#[CoversClass(QueryNameNotResolvable::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class QueryNameNotResolvableTest extends TestCase
{
    #[Test]
    public function it_can_be_constructed_from_a_query(): void
    {
        $query = ExampleFooQuery::fresh(CorrelationId::generate());
        $exception = QueryNameNotResolvable::for($query);

        self::assertSame($this->expectedExceptionMessage($query), $exception->getMessage());
        self::assertNull($exception->getPrevious());
    }

    #[Test]
    public function it_can_be_constructed_from_a_query_and_triggering_throwable(): void
    {
        $query = ExampleFooQuery::fresh(CorrelationId::generate());
        $previous = new \RuntimeException();
        $exception = QueryNameNotResolvable::for($query, $previous);

        self::assertSame($this->expectedExceptionMessage($query), $exception->getMessage());
        self::assertSame($previous, $exception->getPrevious());
    }

    private function expectedExceptionMessage(Query $query): string
    {
        return \sprintf('Query message name for %s<%s> could not be resolved.', $query::class, $query->id()->toString());
    }
}
