<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Event\Naming;

use Lendable\Message\Event\Naming\ClassMapEventNameResolver;
use Lendable\Message\Event\Naming\EventNameNotResolvable;
use Lendable\PHPUnitExtensions\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use Tests\Fixtures\Lendable\Message\Event\ExampleBarEvent;
use Tests\Fixtures\Lendable\Message\Event\ExampleFooEvent;

#[CoversClass(ClassMapEventNameResolver::class)]
final class ClassMapEventNameResolverTest extends TestCase
{
    #[Test]
    public function resolves_name_for_known_events(): void
    {
        $resolver = new ClassMapEventNameResolver([ExampleBarEvent::class => 'event.bar']);

        self::assertSame('event.bar', $resolver->resolve(ExampleBarEvent::fresh())->toString());
    }

    #[Test]
    public function throws_for_unknown_events(): void
    {
        $resolver = new ClassMapEventNameResolver([ExampleBarEvent::class => 'event.bar']);
        $event = ExampleFooEvent::fresh();

        $this->expectExceptionObject(EventNameNotResolvable::for($event));

        $resolver->resolve($event);
    }
}
