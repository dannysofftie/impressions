<?php
namespace Libraries;

use Controllers\Products;

/**
 * A top level utility class that provides routing capability
 */
class Router
{
    /**
     * Routes table
     *
     * @var array
     */
    private static $routes = [];

    /**
     * Incoming url
     *
     * @var string
     */
    private static $incomingUrl = '';

    /**
     * Will contain routes with user params
     *
     * e.g. /:username , /products/:product-name
     *
     * @var array
     */
    private static $userParamRoutes = [];

    /**
     * Handle all get requests to the server
     */
    public static function get($url, $method = null)
    {
        self::checkRoutes($url, 'GET');
        self::$routes[] = array('path' => $url, 'method' => $method, 'request' => 'GET');
    }

    /**
     * Handle post requests to server
     */
    public static function post($url, $method)
    {
        if (!isset($method)) {
            throw new \Exception('Post request requires a method to execute');
        }

        self::checkRoutes($url, 'POST');
        self::$routes[] = array('path' => $url, 'method' => $method, 'request' => 'POST');
    }

    /**
     * Handle patch requests to server
     */
    public static function patch($url, $method)
    {
        if (!isset($method)) {
            throw new \Exception('Patch request requires a method to execute');
        }

        self::checkRoutes($url, 'PATCH');
        self::$routes[] = array('path' => $url, 'method' => $method, 'request' => 'PATCH');
    }

    /**
     * Handle delete requests to server
     */
    public static function delete($url, $method)
    {
        if (!isset($method)) {
            throw new \Exception('Delete requests requires a method to execute');
        }

        self::checkRoutes($url, 'DELETE');
        self::$routes[] = array('path' => $url, 'method' => $method, 'request' => 'DELETE');
    }

    /**
     * Handle put requests to server
     */
    public static function put($url, $method)
    {
        if (!isset($method)) {
            throw new \Exception('Put requests requires a method to execute');
        }

        self::checkRoutes($url, 'PUT');
        self::$routes[] = ['path' => $url, 'method' => $method, 'request' => 'PUT'];
    }

    /**
     * Check routes before they are added to router table
     *
     * Will throw an exception when trying to add multiple routes,
     * with similar signature. e.g
     * /example/user and /example/user
     *
     * Will only allow unique routes
     */
    private static function checkRoutes($url, $methodType)
    {
        if (!isset($url)) {
            throw new \ErrorException('A string argument expected. Cannot initialize an empty route');
        }
        foreach (self::$routes as $value) {
            if ($value['path'] == $url && $value['request'] == $methodType) {
                throw new \Exception('Cannot add a route multiple times ' . $value['path'] . ' with similar request type of ' . $methodType);
            }
        }
    }

    /**
     * Starts routing, and respond to client requests.
     *
     * Called at the bottom after adding all routes. Routes added after calling this method will not be recognized
     *
     * Anonymous callback functions are given precedence when passed as second,
     * arguments when adding routes to the self::$routes instance (router table)
     */
    public static function startRouter()
    {
        self::$incomingUrl = sizeof($_GET) < 1? '/': rtrim('/' . array_keys($_GET)[0], '/');

        $method = '';
        // check if incoming uri path exists in routes table
        foreach (self::$routes as $value) {
            // group paths when url has user defined parameters
            // e.g. http://example.com/categories/:productname
            // to accept http://example.com/categories/shoes
            if (preg_match('/\:/', strval($value['path']))):
                self::$userParamRoutes[] = $value;
            endif;

            if (strval($value['path']) === self::$incomingUrl && $value['request'] === $_SERVER['REQUEST_METHOD']):
                $method = $value['method'];
            endif;
        }

        // check if there are routes with user params in route table
        if (count(self::$userParamRoutes)) {
            self::groupUserParams();
        }

        // give precedence to anonymous functions if added
        if (is_callable($method)):
            call_user_func($method);
        // fallback for when route definition has no anonymous function
        else:
            self::groupControllerAndMethods();
        endif;
    }

    /**
     *
     * This method will be executed when the url exceedes one path specification
     * takes first value as the base controller, second path value is assumed to be
     * a method in base controller
     *
     * @return void
     */
    private static function groupControllerAndMethods()
    {
        $method = '';
        // fallback for when route's second argument is a string,
        // referring to a method in base controller.
        @list($controller, $methodToExecute) = explode('/', filter_var(trim(self::$incomingUrl, '/'), FILTER_SANITIZE_URL));

        $controller = ucfirst($controller);

        $matchedController = '';

        foreach (self::$routes as $value) {
            if (strval($value['path']) === self::$incomingUrl && $value['request'] === $_SERVER['REQUEST_METHOD']) {
                $matchedController = $controller;
                $method = $value['method'];
            }
        }

        if (class_exists($controller) && !class_exists($matchedController)) {
            throw new \Exception("Method $method in base controller $controller not found ");
        } elseif (!class_exists($matchedController)) {
            throw new \Exception('Base controller ' . $controller . ' not found');
        } else {
            // if second argument in path is a method in base controller
            if (method_exists($matchedController, $methodToExecute)):
                return (new $matchedController())->$methodToExecute();
            // if second argument in path is not a method in base controller,
            // take the second parameter and find a method in base controller
            elseif (method_exists($matchedController, $method)):
                (new $matchedController)->$method();
            // when second argument in path / and second parameter in route are not functions in base controller
            throw new \BadMethodCallException('Method ' . $method . ' not found in class ' . $matchedController);
            endif;
        }
    }

    /**
     * Group user parameters and pass to called function as a parameter with all the defined parameters
     *
     * @return void
     */
    private static function groupUserParams()
    {
        // $method = '';
        $path = '';

        foreach (self::$userParamRoutes as $value) {
            if (strval($value['path']) === self::$incomingUrl && $value['request'] === $_SERVER['REQUEST_METHOD']) {
                $path = $value['path'];
            }
        }

        $index = array_search($path, array_column(self::$userParamRoutes, 'path'));

        echo $index;
    }
}
