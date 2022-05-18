<?php

declare(strict_types=1);

namespace App\Routing;

use App\Controller\Controller;
use App\Controller\Error404;
use App\Controller\Home;

class Router
{
    private array $routes = [
        '/' => Home::class,
        '/404' => Error404::class,
    ];

    private static string $path;

    private static ?Router $router = null;


    // c'est pas leur place :/ c'est le role d'un objet game
    private static string $gameState;
    private static string $gameWin;
    private static string $gameLoose;

    private function __construct()
    {
        self::$path = $_SERVER['PATH_INFO'] ?? '/';
        self::$gameState = $_COOKIE['gameState'] ?? 'off';
        self::$gameWin = $_COOKIE['gameWin'] ?? 'no';
        self::$gameLoose = $_COOKIE['gameLoose'] ?? 'no';
    }

    public static function getFromGlobals(): self
    {
        if (null === self::$router) {
            self::$router = new self();
        }

        return self::$router;
    }

    public function getController(): Controller
    {
        $controllerClass = $this->routes[self::$path] ?? $this->routes['/404'];
        $controller = new $controllerClass();

        if (!$controller instanceof Controller) {
            throw new \LogicException("controller $controllerClass should implement ".Controller::class);
        }

        return $controller;
    }

    public function getGameState(): string
    {
        return self::$gameState;
    }

    public function getGameWin(): string
    {
        return self::$gameWin;
    }

    public function getGameLoose(): string
    {
        return self::$gameLoose;
    }
}
