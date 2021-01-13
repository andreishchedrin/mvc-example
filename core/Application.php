<?php

namespace app\core;

use app\core\Router;
use app\core\Request;
use app\core\Response;
use app\core\Controller;
use app\core\Database;

/**
 * Class Application
 *
 * @package app\core
 */
class Application
{
    public Request $request;
    public Response $response;
    public Router $router;
    public Controller $controller;
    public Database $db;
    public Session $session;
    public static string $ROOT_DIR;
    public static Application $app;

    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->session = new Session();
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getController(): Controller
    {
        return $this->controller;
    }

    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }
}
