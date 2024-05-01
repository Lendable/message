<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Event\Naming;

use Lendable\Message\CorrelationId;
use Lendable\Message\Event\Event;
use Lendable\Message\Event\Naming\EventNameNotResolvable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\Event\ExampleFooEvent;

#[CoversClass(EventNameNotResolvable::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class EventNameNotResolvableTest extends TestCase
{
    #[Test]
    public function it_can_be_constructed_from_an_event(): void
    {
        $event = ExampleFooEvent::fresh(CorrelationId::generate());
        $exception = EventNameNotResolvable::for($event);

        self::assertSame($this->expectedExceptionMessage($event), $exception->getMessage());
        self::assertNull($exception->getPrevious());
    }

    #[Test]
    public function it_can_be_constructed_from_an_event_and_triggering_throwable(): void
    {
        $event = ExampleFooEvent::fresh(CorrelationId::generate());
        $previous = new \RuntimeException();
        $exception = EventNameNotResolvable::for($event, $previous);

        self::assertSame($this->expectedExceptionMessage($event), $exception->getMessage());
        self::assertSame($previous, $exception->getPrevious());
    }

    private function expectedExceptionMessage(Event $event): string
    {
        return \sprintf('Event message name for %s<%s> could not be resolved.', $event::class, $event->id()->toString());
    }
}
