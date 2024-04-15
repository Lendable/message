<?php

declare(strict_types=1);

namespace Tests\Fixtures\Lendable\Message\Metadata;

use Lendable\Message\Message;
use Lendable\Message\Metadata\Metadata;
use Lendable\Message\Metadata\MetadataEnricher;

final class StaticMetadataEnricher implements MetadataEnricher
{
    /**
     * @param array<string, scalar> $metadata
     */
    public function __construct(private readonly array $metadata) {}

    public function enrich(Message $message, Metadata $metadata): Metadata
    {
        foreach ($this->metadata as $key => $value) {
            $metadata = $metadata->with($key, $value);
        }

        return $metadata;
    }
}
