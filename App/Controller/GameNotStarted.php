<?php

declare(strict_types = 1);

namespace App\Controller;

class GameNotStarted implements Controller {
    private Controller $decoratedController;

    public function __construct(Controller $controller)
    {
        $this->decoratedController = $controller;
    }

    public function render(): void {
        $this->decoratedController->render();
        echo "
        <div class='container'>
            <form action='' method='GET' id='form_game_not_started'>
                <input type='hidden' name='game_state' value='on'/>
                <input type='submit' value='Commencer la partie' class='button' />
            </form>
        </div>
        ";
    }
}