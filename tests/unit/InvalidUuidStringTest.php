<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\InvalidUuidString;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidUuidString::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class InvalidUuidStringTest extends TestCase
{
    #[Test]
    public function exposes_debug_messages(): void
    {
        self::assertSame('String "foobar" is not a valid UUID hex string.', InvalidUuidString::hexString('foobar')->getMessage());
        self::assertSame('String "foobar" is not a valid UUID byte string.', InvalidUuidString::binaryString('foobar')->getMessage());
    }

    #[Test]
    public function exposes_previous_exception_if_provided(): void
    {
        self::assertNull(InvalidUuidString::hexString('foobar')->getPrevious());
        self::assertNull(InvalidUuidString::binaryString('foobar')->getPrevious());

        $previous = new \RuntimeException();

        self::assertSame($previous, InvalidUuidString::hexString('foobar', $previous)->getPrevious());
        self::assertSame($previous, InvalidUuidString::binaryString('foobar', $previous)->getPrevious());
    }
}
