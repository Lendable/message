<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\ContextAwareMessageTrait;
use Lendable\Message\Message;
use Lendable\Message\MessageContext;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ContextAwareMessageTrait::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class ContextAwareMessageTraitTest extends TestCase
{
    #[Test]
    public function exposes_context_identifiers(): void
    {
        $context = MessageContext::generate();

        $message = $this->createMessageUsingTrait($context);

        self::assertTrue($context->id->equals($message->id()));
        self::assertTrue($context->causationId->equals($message->causationId()));
        self::assertTrue($context->correlationId->equals($message->correlationId()));
    }

    private function createMessageUsingTrait(
        MessageContext $context,
    ): Message {
        return new class ($context) implements Message {
            use ContextAwareMessageTrait;

            public function __construct(
                public readonly MessageContext $context,
            ) {}
        };
    }
}
