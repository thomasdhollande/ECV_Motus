<?php

declare(strict_types=1);

namespace App\EventsListener;

use App\Controller\GameLoose as ControllerGameLoose;
use App\Infra\EventsDispatcher\Events\ControllerEvent;
use App\Infra\EventsDispatcher\ListenerInterface;

class GameLoose implements ListenerInterface
{
    public function support($event): bool
    {
        return $event instanceof ControllerEvent;
    }

    /** @param ControllerEvent $event */
    public function notify($event): void
    {
        if ('yes' === $event->router->getGameLoose()) {
            $event->controller = new ControllerGameLoose($event->controller);
        }
    }
}
