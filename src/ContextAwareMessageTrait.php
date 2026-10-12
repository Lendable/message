<?php

declare(strict_types=1);

namespace Lendable\Message;

trait ContextAwareMessageTrait
{
    public readonly MessageContext $context;

    public function id(): MessageId
    {
        return $this->context->id;
    }

    public function causationId(): MessageId
    {
        return $this->context->causationId;
    }

    public function correlationId(): CorrelationId
    {
        return $this->context->correlationId;
    }
}
