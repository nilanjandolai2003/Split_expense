<?php
namespace App;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, callable|array $handler): void
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            if (is_array($handler)) {
                [$controller, $action] = $handler;
                if (!class_exists($controller)) {
                    http_response_code(500);
                    echo 'Controller not found';
                    return;
                }
                $controllerInstance = new $controller();
                call_user_func([$controllerInstance, $action]);
                return;
            }
            call_user_func($handler);
            return;
        }

        http_response_code(404);
        echo 'Not Found';
    }
}
