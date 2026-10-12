<?php

declare(strict_types=1);

namespace Lendable\Message;

final readonly class MessageContext
{
    public function __construct(
        public MessageId $id,
        public MessageId $causationId,
        public CorrelationId $correlationId,
    ) {}

    public static function generate(): self
    {
        $id = MessageId::generate();

        return new self($id, $id, CorrelationId::generate());
    }

    public static function generateChild(MessageId $causationId, CorrelationId $correlationId): self
    {
        return new self(MessageId::generate(), $causationId, $correlationId);
    }

    public function child(): self
    {
        return self::generateChild($this->id, $this->correlationId);
    }
}
