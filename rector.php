<?php

declare(strict_types=1);

use Lendable\PHPUnitExtensions\Rector\EnforceDisableReturnValueGenerationForTestDoublesRector;
use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->paths([__DIR__.'/src', __DIR__.'/tests']);
    $rectorConfig->phpVersion(PhpVersion::PHP_82);
    $rectorConfig->phpstanConfig(__DIR__.'/phpstan-rector.neon');
    $rectorConfig->cacheClass(FileCacheStorage::class);
    $rectorConfig->cacheDirectory(__DIR__.'/tmp/rector');

    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        LevelSetList::UP_TO_PHP_82,
        PHPUnitSetList::PHPUNIT_100,
    ]);

    $rectorConfig->rule(EnforceDisableReturnValueGenerationForTestDoublesRector::class);

    $rectorConfig->skip(
        [
            // Wants to propagate exception codes and does not appear to understand named parameters.
            ThrowWithPreviousExceptionRector::class,
        ]
    );
};
