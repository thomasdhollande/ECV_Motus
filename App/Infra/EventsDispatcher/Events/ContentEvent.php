<?php

declare(strict_types=1);

namespace App\Infra\EventsDispatcher\Events;

use App\Infra\EventsDispatcher\Event;

class ContentEvent extends Event
{
    public function __construct(public string $content)
    {
    }
}
