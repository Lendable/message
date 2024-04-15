<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

use Lendable\Message\Message;

/**
 * Metadata enrichers add new key-value pairs into an existing {@see Metadata}, providing a new instance of the
 * metadata.
 */
interface MetadataEnricher
{
    public function enrich(Message $message, Metadata $metadata): Metadata;
}
