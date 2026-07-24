<?php

declare(strict_types=1);

use Lendable\PHPUnitExtensions\Rector\EnforceDisableReturnValueGenerationForTestDoublesRector;
use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\Config\RectorConfig;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([__DIR__.'/src', __DIR__.'/tests'])
    ->withPhpVersion(PhpVersion::PHP_84)
    ->withPHPStanConfigs([__DIR__.'/phpstan-rector.neon'])
    ->withCache(__DIR__.'/tmp/rector', FileCacheStorage::class)
    ->withComposerBased(phpunit: true)
    ->withPhpSets(php84: true)
    ->withPreparedSets(codeQuality: true)
    ->withRules([EnforceDisableReturnValueGenerationForTestDoublesRector::class])
    ->withSkip([
        // Wants to propagate exception codes and does not appear to understand named parameters.
        ThrowWithPreviousExceptionRector::class,
    ]);
