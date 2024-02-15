<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\BinaryStringUuidConverter;
use Lendable\Message\MessageId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\Fixtures\Lendable\Message\UuidGenerator;

#[CoversClass(BinaryStringUuidConverter::class)]
final class BinaryStringUuidConverterTest extends TestCase
{
    #[Test]
    public function converts_binary_strings_to_uuid_instances(): void
    {
        $binaryString = UuidGenerator::binaryStringFromString('70d99e3b-af6e-4174-8982-e32890cffb02');

        $converter = new BinaryStringUuidConverter();
        $id = $converter->convert($binaryString, MessageId::class);

        self::assertInstanceOf(MessageId::class, $id); // @phpstan-ignore-line we want to not trust phpdoc generics here.
        self::assertSame('70d99e3b-af6e-4174-8982-e32890cffb02', $id->toString());
    }
}
