<?php

declare(strict_types=1);

use App\EventsListener\GameLoose;
use App\EventsListener\GameNotStarted;
use App\EventsListener\GameStarted;
use App\EventsListener\GameWin;
use App\EventsListener\WordIsProposed;
use App\Infra\EventsDispatcher\Dispatcher;
use App\Infra\EventsDispatcher\Events\ControllerEvent;
use App\Infra\EventsDispatcher\Events\RouterEvent;
use App\Routing\Router;

if (isset($_SERVER['HTTPS']) && 'on' === $_SERVER['HTTPS']) {
    $url = 'https';
} else {
    $url = 'http';
}
$url .= '://';
$url .= $_SERVER['HTTP_HOST'];
$url .= $_SERVER['REQUEST_URI'];

define('SITE_URL', $url);

session_start();

if (!isset($_COOKIE['gameState'])) {
    setcookie('gameState', 'off');
}

spl_autoload_register(function ($fqcn): void {
    $path = str_replace('\\', '/', $fqcn);
    require_once __DIR__.'/../'.$path.'.php';
});

$eventDispatcher = new Dispatcher();
$eventDispatcher->addListeners(new GameNotStarted(), new GameStarted(), new WordIsProposed(), new GameWin(), new GameLoose());

$router = Router::getFromGlobals();

$eventDispatcher->dispatch($routerEvent = new RouterEvent($router));
$router = $routerEvent->router;

$controller = $router->getController();

$eventDispatcher->dispatch($controllerEvent = new ControllerEvent($controller, $router));
$controller = $controllerEvent->controller;

ob_start();
$controller->render();
$content = ob_get_clean();

echo $content;
