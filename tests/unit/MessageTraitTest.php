<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\CorrelationId;
use Lendable\Message\Message;
use Lendable\Message\MessageId;
use Lendable\Message\MessageTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MessageTrait::class)]
final class MessageTraitTest extends TestCase
{
    #[Test]
    public function exposes_identifiers(): void
    {
        $id = MessageId::generate();
        $causationId = MessageId::generate();
        $correlationId = CorrelationId::generate();

        $message = $this->createMessageUsingTrait($id, $causationId, $correlationId);

        self::assertTrue($id->equals($message->id()));
        self::assertTrue($causationId->equals($message->causationId()));
        self::assertTrue($correlationId->equals($message->correlationId()));
    }

    private function createMessageUsingTrait(
        MessageId $id,
        MessageId $causationId,
        CorrelationId $correlationId
    ): Message {
        return new class ($id, $causationId, $correlationId) implements Message {
            use MessageTrait;

            public function __construct(
                private readonly MessageId $id,
                private readonly MessageId $causationId,
                private readonly CorrelationId $correlationId
            ) {}
        };
    }
}
