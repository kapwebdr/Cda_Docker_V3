<?php
namespace App\Controller;

// https://github.com/nikic/FastRoute
class Main
{
    static function Router(array $routes=[])
    {
        $dispatcher = \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) use($routes) {
            
            foreach($routes as $uri => $route)
            {
                $r->addRoute($route['method'], $uri, $route['controller']);
            }
        });

        // Fetch method and URI from somewhere
        $httpMethod     = $_SERVER['REQUEST_METHOD'];
        $uri            = $_SERVER['REQUEST_URI'];

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                echo '404 page non trouvée';
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                // ... 405 Method Not Allowed
                echo 'Methode interdite';
                break;
            case \FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                $handler[0] = new $handler[0];
                call_user_func($handler, ...$vars);

                break;
        }
    }
}
