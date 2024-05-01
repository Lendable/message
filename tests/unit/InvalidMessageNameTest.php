<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\InvalidMessageName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidMessageName::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class InvalidMessageNameTest extends TestCase
{
    #[Test]
    public function exposes_debug_messages(): void
    {
        $exception = InvalidMessageName::empty();

        self::assertSame('Message name cannot be empty.', $exception->getMessage());
    }
}
