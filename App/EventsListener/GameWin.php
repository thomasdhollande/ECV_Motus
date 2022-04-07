<?php

declare(strict_types=1);

namespace App\EventsListener;

use App\Controller\GameWin as ControllerGameWin;
use App\Infra\EventsDispatcher\Events\ControllerEvent;
use App\Infra\EventsDispatcher\ListenerInterface;

class GameWin implements ListenerInterface
{
    public function support($event): bool
    {
        return $event instanceof ControllerEvent;
    }

    /** @param ControllerEvent $event */
    public function notify($event): void
    {
        if ($event->router->getGameWin() === 'yes') {
            $event->controller = new ControllerGameWin($event->controller);
        }
    }
}