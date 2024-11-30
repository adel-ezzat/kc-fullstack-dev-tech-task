<?php

declare(strict_types=1);

namespace Core\Router;

/**
 * HTTP Router
 */
class Router
{
    private array $handlers = [];
    private const string METHOD_GET = 'GET';
    private const string METHOD_POST = 'POST';

    /**
     * Handle GET requests
     * @param string $path
     * @param $handler
     * @return void
     */
    public function get(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_GET, $path, $handler);
    }

    /**
     * Handle POST requests
     * @param string $path
     * @param $handler
     * @return void
     */
    public function post(string $path, $handler): void
    {
        $this->addHandler(self::METHOD_POST, $path, $handler);
    }

    /**
     * Add handler before processing
     * @param string $method
     * @param string $path
     * @param $handler
     * @return void
     */
    private function addHandler(string $method, string $path, $handler): void
    {
        $this->handlers[$method . $path] = compact('path', 'method', 'handler');
    }

    /**
     * Process request
     * @return void
     */
    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;

        foreach ($this->handlers as $handler) {
            // If the path has parameters, match dynamically
            if ($this->matchPath($handler['path'], $requestPath) && $handler['method'] === $method) {
                $callback = $handler['handler'];
                break;
            }
        }

        if (gettype($callback) === 'array') {
            $class = new $callback[0]() ?? '';
            $method = $callback[1] ?? '';

            if (!method_exists($class, $method)) {
                die("Class Method $method Not Found");
            }

            $callback = [(new $class()), $method];
        }

        if (!$callback) {
            die('404 Page Not Found');
        }

        // Call the handler with parameters (merged from GET and POST)
        call_user_func_array($callback, [
            array_merge($_GET, $_POST)
        ]);
    }

    /**
     * Match the request path with the route path (supporting dynamic segments)
     * @param string $routePath
     * @param string $requestPath
     * @return bool
     */
    private function matchPath(string $routePath, string $requestPath): bool
    {
        // Check if route path has dynamic segments in { }
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false; // The number of segments do not match
        }

        // Iterate through each segment of the route
        foreach ($routeParts as $index => $part) {
            // If part is dynamic, we treat it as a variable (e.g., {id})
            if (preg_match('/^{\w+}$/', $part)) {
                // Extract parameter name (e.g., id from {id})
                $paramName = substr($part, 1, -1);
                // Assign the value from the request to $_GET (or to your params array)
                $_GET[$paramName] = $requestParts[$index];
            } elseif ($part !== $requestParts[$index]) {
                return false; // Static part does not match
            }
        }

        return true;
    }

    /**
     * Run the process method
     */
    public function __destruct()
    {
        $this->run();
    }
}
