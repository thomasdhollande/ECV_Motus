<?php

declare(strict_types=1);

namespace App\Infra\EventsDispatcher;

interface EventInterface
{
    /**
     * Is propagation stopped?
     *
     * This will typically only be used by the Dispatcher to determine if the
     * previous listener halted propagation.
     *
     * @return bool
     *              True if the Event is complete and no further listeners should be called.
     *              False to continue calling listeners.
     */
    public function isPropagationStopped(): bool;
}
