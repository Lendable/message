<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

use Lendable\Message\Message;

/**
 * Enriches metadata by utilizing multiple other enrichers.
 */
final readonly class ChainEnricher implements MetadataEnricher
{
    /**
     * @var iterable<MetadataEnricher>
     */
    private iterable $enrichers;

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
