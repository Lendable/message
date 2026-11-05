<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\CorrelationId;
use Lendable\Message\MessageContext;
use Lendable\Message\MessageId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MessageContext::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class MessageContextTest extends TestCase
{
    #[Test]
    public function generatable(): void
    {
        $context = MessageContext::generate();

        self::assertTrue($context->id->equals($context->causationId));

        $anotherContext = MessageContext::generate();

        self::assertFalse($context->id->equals($anotherContext->id));
        self::assertFalse($context->correlationId->equals($anotherContext->correlationId));
    }

    #[Test]
    public function generatable_as_child(): void
    {
        $causationId = MessageId::generate();
        $correlationId = CorrelationId::generate();

        $context = MessageContext::generateChild($causationId, $correlationId);

        self::assertFalse($context->id->equals($causationId));
        self::assertTrue($context->causationId->equals($causationId));
        self::assertTrue($context->correlationId->equals($correlationId));
    }

    #[Test]
    public function creates_child_context(): void
    {
        $parentContext = MessageContext::generate();
        $childContext = $parentContext->child();

        self::assertFalse($childContext->id->equals($parentContext->id));
        self::assertTrue($childContext->causationId->equals($parentContext->id));
        self::assertTrue($childContext->correlationId->equals($parentContext->correlationId));
    }
}
