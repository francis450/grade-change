<?php
class Router {
    protected $request;
    protected $routes = [];

    public function __construct($request) {
        $this->request = $request;
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function resolve() {
        $method = $this->request->method();
        $path = $this->request->path();

        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            http_response_code(404);
            require_once 'views/errors/404.php';
            return;
        }

        if (is_string($callback)) {
            $parts = explode('@', $callback);
            $controller = new $parts[0];
            $method = $parts[1];
            echo call_user_func_array([$controller, $method], $this->request->params());
        } else {
            echo call_user_func($callback);
        }
    }
}
?>
