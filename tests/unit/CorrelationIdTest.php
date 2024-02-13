<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\CorrelationId;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Tests\Fixtures\Lendable\Message\UuidGenerator;

#[CoversClass(CorrelationId::class)]
final class CorrelationIdTest extends TestCase
{
    #[Test]
    public function it_can_be_generated(): void
    {
        $instance = CorrelationId::generate();

        self::assertTrue(Uuid::isValid($instance->toString()));
    }

    #[Test]
    public function it_can_be_constructed_from_a_string(): void
    {
        $string = UuidGenerator::string();
        $instance = CorrelationId::fromString($string);

        self::assertSame($string, $instance->toString());
        self::assertSame(UuidGenerator::binaryStringFromString($string), $instance->toBinary());
    }

    #[Test]
    public function it_can_be_constructed_from_a_binary_string(): void
    {
        $string = UuidGenerator::binaryString();
        $instance = CorrelationId::fromBinaryString($string);

        self::assertSame(UuidGenerator::stringFromBinaryString($string), $instance->toString());
        self::assertSame($string, $instance->toBinary());
    }

    #[Test]
    public function it_equals_other_correlation_ids_with_same_value(): void
    {
        $id = CorrelationId::generate();
        $idDifferentValue = CorrelationId::generate();
        $idSameReference = $id;
        $idSameValue = CorrelationId::fromString($id->toString());

        self::assertTrue($id->equals($idSameReference));
        self::assertTrue($idSameReference->equals($id));
        self::assertTrue($id->equals($idSameValue));
        self::assertTrue($idSameValue->equals($id));
        self::assertFalse($id->equals($idDifferentValue));
        self::assertFalse($idDifferentValue->equals($id));
    }
}
