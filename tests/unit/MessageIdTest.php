<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\InvalidUuidString;
use Lendable\Message\MessageId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DisableReturnValueGenerationForTestDoubles;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Fixtures\Lendable\Message\UuidGenerator;

#[CoversClass(MessageId::class)]
#[DisableReturnValueGenerationForTestDoubles]
final class MessageIdTest extends TestCase
{
    #[Test]
    public function generatable(): void
    {
        self::assertTrue(Uuid::isValid(MessageId::generate()->toString()));
    }

    #[Test]
    public function creatable_from_a_hex_string(): void
    {
        $string = UuidGenerator::string();
        $id = MessageId::fromString($string);

        self::assertSame($string, $id->toString());
    }

    #[Test]
    public function creatable_from_a_binary_string(): void
    {
        $string = UuidGenerator::binaryString();
        $id = MessageId::fromBinaryString($string);

        self::assertSame($string, $id->toBinary());
    }

    #[Test]
    public function throws_when_created_from_invalid_hex_string(): void
    {
        $this->expectExceptionObject(InvalidUuidString::hexString('foobar'));

        MessageId::fromString('foobar');
    }

    #[Test]
    public function throws_when_created_from_invalid_binary_string(): void
    {
        $this->expectExceptionObject(InvalidUuidString::binaryString('foobar'));

        MessageId::fromBinaryString('foobar');
    }

    #[Test]
    public function equals_other_message_ids_with_same_value(): void
    {
        $id = MessageId::generate();
        $idDifferentValue = MessageId::generate();
        $idSameReference = $id;
        $idSameValue = MessageId::fromString($id->toString());

        self::assertTrue($id->equals($idSameReference));
        self::assertTrue($idSameReference->equals($id));
        self::assertTrue($id->equals($idSameValue));
        self::assertTrue($idSameValue->equals($id));
        self::assertFalse($id->equals($idDifferentValue));
        self::assertFalse($idDifferentValue->equals($id));
    }
}
