<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Query\Naming;

use Lendable\Message\Query\Naming\ClassMapQueryNameResolver;
use Lendable\Message\Query\Naming\QueryNameNotResolvable;
use Lendable\PHPUnitExtensions\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures\Lendable\Message\Query\ExampleBarQuery;
use Tests\Fixtures\Lendable\Message\Query\ExampleFooQuery;

#[CoversClass(ClassMapQueryNameResolver::class)]
final class ClassMapQueryNameResolverTest extends TestCase
{
    #[Test]
    public function resolves_name_for_known_queries(): void
    {
        $resolver = new ClassMapQueryNameResolver([ExampleBarQuery::class => 'query.bar']);

        self::assertSame('query.bar', $resolver->resolve(ExampleBarQuery::fresh())->toString());
    }

    #[Test]
    public function throws_for_unknown_queries(): void
    {
        $resolver = new ClassMapQueryNameResolver([ExampleBarQuery::class => 'query.bar']);
        $query = ExampleFooQuery::fresh();

        $this->expectExceptionObject(QueryNameNotResolvable::for($query));

        $resolver->resolve($query);
    }
}
