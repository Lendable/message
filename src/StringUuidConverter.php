<?php

declare(strict_types=1);

namespace Lendable\Message;

final class StringUuidConverter implements UuidConverter
{
    public function convert(string $value, string $target): Uuid
    {
        return $target::fromString($value);
    }
}
