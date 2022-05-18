<?php

declare(strict_types=1);

namespace App\Controller;

class Home implements Controller
{
    public function render(): void
    {
        require_once __DIR__.'/../View/Header.html';
        require_once __DIR__.'/../View/Home.php';
    }
}
