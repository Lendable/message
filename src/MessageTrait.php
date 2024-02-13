<?php

declare(strict_types=1);

namespace Lendable\Message;

/**
 * @mixin Message
 */
trait MessageTrait
{
    private readonly MessageId $id;

    private readonly MessageId $causationId;

    private readonly CorrelationId $correlationId;

    final public function id(): MessageId
    {
        return $this->id;
    }

    final public function causationId(): MessageId
    {
        return $this->causationId;
    }

    final public function correlationId(): CorrelationId
    {
        return $this->correlationId;
    }
}
