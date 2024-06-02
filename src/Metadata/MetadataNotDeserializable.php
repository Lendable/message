<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

final class MetadataNotDeserializable extends \InvalidArgumentException
{
    private function __construct(string $message, ?\Throwable $previous = null)
    {
        parent::__construct($message, previous: $previous);
    }

    public static function dueTo(\Throwable $cause): self
    {
        return new self('Metadata was not deserializable.', $cause);
    }
}
