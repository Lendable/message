<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

use Lendable\Message\Message;

/**
 * Enriches metadata by utilising multiple other enrichers.
 */
final class ChainEnricher implements MetadataEnricher
{
    /**
     * @var iterable<MetadataEnricher>
     */
    private readonly iterable $enrichers;

    public function __construct(MetadataEnricher ...$enrichers)
    {
        $this->enrichers = $enrichers;
    }

    public function enrich(Message $message, Metadata $metadata): Metadata
    {
        foreach ($this->enrichers as $enricher) {
            $metadata = $enricher->enrich($message, $metadata);
        }

        return $metadata;
    }
}
