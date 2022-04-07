<?php

declare(strict_types=1);

namespace App\EventsListener;

use App\Controller\GameNotStarted as ControllerGameNotStarted;
use App\Infra\EventsDispatcher\Events\ControllerEvent;
use App\Infra\EventsDispatcher\ListenerInterface;
use App\Motus\Game\Game;
use App\Motus\Word\Word;

class GameNotStarted implements ListenerInterface
{
    public function support($event): bool
    {
        return $event instanceof ControllerEvent;
    }

    /** @param ControllerEvent $event */
    public function notify($event): void
    {
        if ($event->router->getGameState() === 'off') {
            $objWord = new Word();
            $word = $objWord->getWord();
            unset($objWord);
            if (isset($word) && $word !== '') {
                setcookie('word', strtolower($word));
                $_COOKIE['word'] = $word;
                setcookie('gameState', 'on');
                $_COOKIE['gameState'] = 'on';
                setcookie('gameWin', 'no');
                $_COOKIE['gameWin'] = 'no';
                setcookie('gameLoose', 'no');
                $_COOKIE['gameLoose'] = 'no';
                $objGame = new Game();
                $max_turns = $objGame->getMaxTurns();
                for ($i = 1; $i <= $max_turns; $i++) {
                    setcookie("try$i", " ");
                    $_COOKIE["try$i"] = " ";
                }
                $_SESSION['turns'] = 0;
                $event->controller = new ControllerGameNotStarted($event->controller);
            }
        }
    }
}