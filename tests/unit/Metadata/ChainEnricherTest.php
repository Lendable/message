<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Metadata;

use Lendable\Message\CorrelationId;
use Lendable\Message\Message;
use Lendable\Message\MessageId;
use Lendable\Message\MessageName;
use Lendable\Message\Metadata\ChainEnricher;
use Lendable\Message\Metadata\Metadata;
use Lendable\Message\Metadata\MetadataEnricher;
use Lendable\Message\Metadata\MetadataKey;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\Event\ExampleFooEvent;
use Tests\Fixtures\Lendable\Message\Metadata\StaticMetadataEnricher;

#[CoversClass(ChainEnricher::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class ChainEnricherTest extends TestCase
{
    #[Test]
    public function enrichers_are_sequentially_called(): void
    {
        /** @var \ArrayObject<int, MetadataEnricher> $calls */
        $calls = new \ArrayObject();

        $event = ExampleFooEvent::fresh(CorrelationId::generate());

        $first = $this->createEnricher($calls, 'Foo', 'Bar');
        $second = $this->createEnricher($calls, 'Bar', 'Foo');

        $metadata = (new ChainEnricher($first, $second))
            ->enrich(
                $event,
                Metadata::base(
                    MessageName::fromString('example.event.foo'),
                    MessageId::fromString($event->causationId()->toString()),
                    $event->correlationId(),
                ),
            );

        self::assertSame([$first, $second], $calls->getArrayCopy());
        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'example.event.foo',
                MetadataKey::CAUSATION_ID->value => $event->causationId()->toString(),
                MetadataKey::CORRELATION_ID->value => $event->correlationId()->toString(),
                'Foo' => 'Bar',
                'Bar' => 'Foo',
            ],
            $metadata->all(),
        );
    }

    /**
     * @param \ArrayObject<int, MetadataEnricher> $calls
     */
    private function createEnricher(\ArrayObject $calls, string $key, string|int|bool|float $value): MetadataEnricher
    {
        $delegate = new StaticMetadataEnricher([$key => $value]);

        return new class ($calls, $delegate) implements MetadataEnricher {
            /**
             * @param \ArrayObject<int, MetadataEnricher> $calls
             */
            public function __construct(
                private readonly \ArrayObject $calls,
                private readonly MetadataEnricher $delegate,
            ) {}

            public function enrich(Message $message, Metadata $metadata): Metadata
            {
                $this->calls->append($this);

                return $this->delegate->enrich($message, $metadata);
            }
        };
    }
}
