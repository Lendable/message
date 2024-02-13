<?php

declare(strict_types=1);

namespace Lendable\Message;

interface Message
{
    /**
     * The identifier for this message.
     */
    public function id(): MessageId;

    /**
     * The identifier of the previous message within a conversation.
     *
     * If this message is the initiator of the conversation, this will be the
     * message identifier of the message.
     */
    public function causationId(): MessageId;

    /**
     * The identifier of the conversation this message is within.
     */
    public function correlationId(): CorrelationId;
}
