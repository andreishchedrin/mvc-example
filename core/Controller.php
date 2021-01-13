<?php

namespace app\core;

use app\core\Application;

/**
 * Class Controller
 *
 * @package app\core
 */

class Controller
{
    public string $layout = 'main';

    public array $middlewares = [];

    public function render(string $view, array $params = []): string
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }
}
