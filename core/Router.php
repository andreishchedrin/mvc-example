<?php

namespace app\core;

use app\core\Request;
use app\core\Application;

/**
* Class Router
* 
* @package app\core
*/
class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();       
        $callback = $this->routes[$method][$path] ?? false;       
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderContent("Not found");
        }
        if (is_string($callback)) {
            return $this->renderView($callback);                
        }
        if (is_array($callback)) {            
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
            foreach (Application::$app->controller->middlewares as $route => $middleware) 
            {
                if ($route === substr($path, 0 , 1)) {
                    new $middleware->execute();
                }                
            }
        }
        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);       
    }

    public function renderContent($content)
    {
        $layoutContent = $this->layoutContent();     
        return str_replace('{{content}}', $content, $layoutContent);        
    }

    protected function layoutContent()
    {
        $layout = Application::$app->controller->layout ?? 'main';
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/{$layout}.php";
        return ob_get_clean();
    }

    protected function viewContent($view, $params = [])
    { 
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/{$view}.php";
        return ob_get_clean();
    }
}