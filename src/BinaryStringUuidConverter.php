<?php

declare(strict_types=1);

namespace Lendable\Message;

final class BinaryStringUuidConverter implements UuidConverter
{
    public function convert(string $value, string $target): Uuid
    {
        return $target::fromBinaryString($value);
    }
}
