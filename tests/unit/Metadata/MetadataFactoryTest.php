<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message\Metadata;

use Lendable\Message\CorrelationId;
use Lendable\Message\Metadata\MetadataFactory;
use Lendable\Message\Metadata\MetadataKey;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\Command\ExampleFooCommand;
use Tests\Fixtures\Lendable\Message\Command\Naming\ExampleCommandNameResolver;
use Tests\Fixtures\Lendable\Message\Event\ExampleFooEvent;
use Tests\Fixtures\Lendable\Message\Event\Naming\ExampleEventNameResolver;
use Tests\Fixtures\Lendable\Message\Metadata\StaticMetadataEnricher;

#[CoversClass(MetadataFactory::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class MetadataFactoryTest extends TestCase
{
    #[Test]
    public function creates_metadata_for_command(): void
    {
        $message = ExampleFooCommand::fresh(CorrelationId::generate());

        $factory = MetadataFactory::commands(
            new ExampleCommandNameResolver(),
            new StaticMetadataEnricher(['foo' => 'bar', 'baz' => 'qux']),
        );

        $metadata = $factory->for($message);

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'example.command.foo',
                MetadataKey::CAUSATION_ID->value => $message->causationId()->toString(),
                MetadataKey::CORRELATION_ID->value => $message->correlationId()->toString(),
                'foo' => 'bar',
                'baz' => 'qux',
            ],
            $metadata->all(),
        );
    }

    #[Test]
    public function creates_metadata_for_event(): void
    {
        $message = ExampleFooEvent::fresh(CorrelationId::generate());

        $factory = MetadataFactory::events(
            new ExampleEventNameResolver(),
            new StaticMetadataEnricher(['foo' => 'bar', 'baz' => 'qux']),
        );

        $metadata = $factory->for($message);

        self::assertSame(
            [
                MetadataKey::MESSAGE_NAME->value => 'example.event.foo',
                MetadataKey::CAUSATION_ID->value => $message->causationId()->toString(),
                MetadataKey::CORRELATION_ID->value => $message->correlationId()->toString(),
                'foo' => 'bar',
                'baz' => 'qux',
            ],
            $metadata->all(),
        );
    }
}
