<?php

declare(strict_types=1);

namespace Tests\Unit\Lendable\Message;

use Lendable\Message\InvalidMessageName;
use Lendable\Message\MessageName;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(MessageName::class)]
final class MessageNameTest extends TestCase
{
    #[Test]
    public function it_can_be_constructed_from_a_valid_string(): void
    {
        $name = MessageName::fromString('foo');

        self::assertSame('foo', $name->toString());
    }

    /**
     * @return iterable<list{string}>
     */
    public static function exampleEmptyStrings(): iterable
    {
        yield [''];
        yield [' '];
        yield ['   '];
    }

    #[Test]
    #[DataProvider('exampleEmptyStrings')]
    public function it_throws_when_constructing_from_string_if_the_string_is_empty(string $emptyString): void
    {
        $this->expectException(InvalidMessageName::class);
        $this->expectExceptionMessage('Message name cannot be empty.');

        MessageName::fromString($emptyString);
    }

    #[Test]
    public function it_equals_other_message_names_with_the_same_name(): void
    {
        $name = MessageName::fromString('foo');
        $nameSameValue = MessageName::fromString('foo');
        $nameDifferentValue = MessageName::fromString('bar');

        self::assertTrue($name->equals($nameSameValue));
        self::assertTrue($nameSameValue->equals($name));
        self::assertFalse($name->equals($nameDifferentValue));
        self::assertFalse($nameDifferentValue->equals($name));
    }
}
