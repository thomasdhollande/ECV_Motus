<?php

declare(strict_types = 1);

namespace App\Controller;

class GameStarted implements Controller {
    private Controller $decoratedController;
    private string $grid;

    public function __construct(Controller $controller, string $grid)
    {
        $this->decoratedController = $controller;
        $this->grid = $grid;
    }

    public function render(): void {
        $this->decoratedController->render();
        echo $this->grid;
    }
}