<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\MessageId;
use Lendable\Message\StringUuidConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(StringUuidConverter::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class StringUuidConverterTest extends TestCase
{
    #[Test]
    public function converts_strings_to_uuid_instances(): void
    {
        $converter = new StringUuidConverter();
        $id = $converter->convert('ddb802d4-3bfb-44c0-a257-eb6178791259', MessageId::class);

        self::assertInstanceOf(MessageId::class, $id);
        self::assertSame('ddb802d4-3bfb-44c0-a257-eb6178791259', $id->toString());
    }
}
