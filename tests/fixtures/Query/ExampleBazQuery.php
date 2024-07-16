<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Query;

use Lendable\Message\CorrelationId;
use Lendable\Message\MessageId;
use Lendable\Message\MessageTrait;
use Lendable\Message\Query\Query;

final readonly class ExampleBazQuery implements Query
{
    use MessageTrait;

    private function __construct(MessageId $id, CorrelationId $correlationId, MessageId $causationId)
    {
        $this->id = $id;
        $this->correlationId = $correlationId;
        $this->causationId = $causationId;
    }

    public static function fresh(CorrelationId $correlationId, ?MessageId $causationId = null): self
    {
        $messageId = MessageId::generate();

        return new self($messageId, $correlationId, $causationId ?? $messageId);
    }

    public static function existing(MessageId $id, CorrelationId $correlationId, MessageId $causationId): self
    {
        return new self($id, $correlationId, $causationId);
    }
}
