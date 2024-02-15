<?php

declare(strict_types=1);

namespace Lendable\Message;

interface MessageAware
{
    public function message(): Message;
}
