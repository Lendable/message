<?php

declare(strict_types=1);

use Lendable\ComposerLicenseChecker\LicenseConfigurationBuilder;

return (new LicenseConfigurationBuilder())
    ->addLicenses(
        'BSD-2-Clause',
        'BSD-3-Clause',
        'MIT',
        'LGPL-2.1-or-later'
    )
    ->build();
