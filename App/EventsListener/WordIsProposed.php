<?php

declare(strict_types=1);

namespace App\EventsListener;

use App\Controller\GameStarted as ControllerGameStarted;
use App\Controller\PlayersElements;
use App\Infra\EventsDispatcher\Events\ControllerEvent;
use App\Infra\EventsDispatcher\ListenerInterface;
use App\Motus\Player\Player;
use App\Motus\Word\Word;

class WordIsProposed implements ListenerInterface
{
    public function support($event): bool
    {
        return $event instanceof ControllerEvent;
    }

    /** @param ControllerEvent $event */
    public function notify($event): void
    {
        if (('on' === $event->router->getGameState() || (isset($_GET['gameState']) && 'on' === $_GET['gameState'])) && isset($_POST['players_word'])) {
            ++$_SESSION['turns'];
            setcookie('try'.$_SESSION['turns'].'', strtolower($_POST['players_word']));
            $_COOKIE['try'.$_SESSION['turns'].''] = strtolower($_POST['players_word']);

            $objWord = new Word();
            $word = $objWord->getWord();
            unset($objWord);

            $objPlayer = new Player();
            $grid = $objPlayer->getGrid($word);
            unset($objPlayer);
            $event->controller = new ControllerGameStarted($event->controller, $grid);

            $objPlayer = new Player();
            $playersElements = $objPlayer->getPlayersElements();
            unset($objLetters);
            $event->controller = new PlayersElements($event->controller, $playersElements);
        }
    }
}
