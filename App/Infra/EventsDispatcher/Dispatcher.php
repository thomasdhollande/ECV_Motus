<?php

declare(strict_types=1);

namespace App\Infra\EventsDispatcher;

class Dispatcher
{
    /**
     * @var array<ListenerInterface>
     */
    private array $listeners = [];

    public function addListeners(ListenerInterface ...$listeners): void
    {
        $this->listeners = array_merge($this->listeners, $listeners);
    }

    public function dispatch(EventInterface $event): void
    {
        foreach ($this->listeners as $listener) {
            if ($listener->support($event)) {
                $listener->notify($event);
            }

            if ($event->isPropagationStopped()) {
                break;
            }
        }
    }
}
