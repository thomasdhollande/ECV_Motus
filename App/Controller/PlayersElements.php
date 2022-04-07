<?php

declare(strict_types = 1);

namespace App\Controller;

class PlayersElements implements Controller {
    private Controller $decoratedController;
    private string $playersElements;

    public function __construct(Controller $controller, string $playersElements)
    {
        $this->decoratedController = $controller;
        $this->playersElements = $playersElements;
    }

    public function render(): void {
        $this->decoratedController->render();
        echo $this->playersElements;
    }
}