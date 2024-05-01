<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

use Lendable\Message\Command\Command;
use Lendable\Message\Command\Naming\CommandNameResolver;
use Lendable\Message\Event\Event;
use Lendable\Message\Event\Naming\EventNameResolver;
use Lendable\Message\Message;
use Lendable\Message\MessageId;
use Lendable\Message\MessageName;

/**
 * Creates {@see Metadata} for different types of messages.
 *
 * @template T of Message
 */
final readonly class MetadataFactory
{
    /**
     * @param \Closure(T): MessageName $messageNameFactory
     */
    private function __construct(
        private \Closure $messageNameFactory,
        private MetadataEnricher $enricher,
    ) {}

    /**
     * @param T $message
     */
    public function for(Message $message): Metadata
    {
        return $this->enricher->enrich(
            $message,
            Metadata::base(
                ($this->messageNameFactory)($message),
                MessageId::fromString($message->causationId()->toString()),
                $message->correlationId(),
            ),
        );
    }

    /**
     * @return self<Command>
     */
    public static function commands(CommandNameResolver $nameResolver, MetadataEnricher ...$enricher): self
    {
        return new self($nameResolver->resolve(...), new ChainEnricher(...$enricher));
    }

    /**
     * @return self<Event>
     */
    public static function events(EventNameResolver $nameResolver, MetadataEnricher ...$enricher): self
    {
        return new self($nameResolver->resolve(...), new ChainEnricher(...$enricher));
    }
}
