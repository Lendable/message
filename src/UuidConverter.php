<?php

declare(strict_types=1);

namespace Lendable\Message;

interface UuidConverter
{
    /**
     * @template T of Uuid
     *
     * @param class-string<T> $target
     *
     * @return T
     */
    public function convert(string $value, string $target): Uuid;
}
