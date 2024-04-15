<?php

declare(strict_types=1);

namespace Lendable\Message\Metadata;

/**
 * Mandatory metadata keys.
 */
enum MetadataKey: string
{
    case MESSAGE_NAME = 'Message-Name';
    case CAUSATION_ID = 'Causation-Id';
    case CORRELATION_ID = 'Correlation-Id';
}
