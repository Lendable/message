<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message;

use Ramsey\Uuid\Uuid as RamseyUuid;

final class UuidGenerator
{
    private function __construct() {}

    public static function string(): string
    {
        return RamseyUuid::uuid4()->toString();
    }

    public static function binaryString(): string
    {
        return RamseyUuid::uuid4()->getBytes();
    }

    public static function stringFromBinaryString(string $string): string
    {
        return RamseyUuid::fromBytes($string)->toString();
    }

    public static function binaryStringFromString(string $string): string
    {
        return RamseyUuid::fromString($string)->getBytes();
    }
}
