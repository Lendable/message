<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Event;

use Lendable\Message\CorrelationId;
use Lendable\Message\Event\Event;
use Lendable\Message\MessageId;
use Lendable\Message\MessageTrait;

final readonly class ExampleBarEvent implements Event
{
    use MessageTrait;

    private function __construct(MessageId $id, CorrelationId $correlationId, MessageId $causationId)
    {
        $this->id = $id;
        $this->correlationId = $correlationId;
        $this->causationId = $causationId;
    }

    public static function fresh(?CorrelationId $correlationId = null, ?MessageId $causationId = null): self
    {
        $messageId = MessageId::generate();

        return new self($messageId, $correlationId ?? CorrelationId::generate(), $causationId ?? $messageId);
    }

    public static function existing(MessageId $id, CorrelationId $correlationId, MessageId $causationId): self
    {
        return new self($id, $correlationId, $causationId);
    }
}
