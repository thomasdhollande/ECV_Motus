<?php

declare(strict_types = 1);

namespace App\Controller;

class GameLoose implements Controller {
    private Controller $decoratedController;

    public function __construct(Controller $controller)
    {
        $this->decoratedController = $controller;
    }

    public function render(): void {
        $this->decoratedController->render();
        echo "Gros naze !";
    }
}