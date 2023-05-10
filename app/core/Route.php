<?php

namespace App\Core;

define('CONTROLLERS_NAMESPACE', 'App\\controllers\\');
use App\controllers;

class Route
{

    public static function start()
    {
        $controllerClassname = 'home';
        $actionName = 'index';
        $payload = [];

        $routes = explode(DIRECTORY_SEPARATOR, $_SERVER["REQUEST_URL"]);

        if (!empty($routes[1])) {
            $controllerClassname = $routes[1];
        }

        $actionName = empty($routes[2]) ? 'index' : $routes[2];

        if (!empty($routes[3])) {
            $payload = array_slice($routes, 3);
        }

        $controllerName = CONTROLLERS_NAMESPACE . ucfirst($controllerClassname);

        $controllerFile = ucfirst(strtolower($controllerClassname)) . '.php';

        $controller_path = CONTROLLER . $controllerFile;

        if (file_exists($controller_path)) {
            include_once CONTROLLER . $controllerFile;
        } else {
            Route::Error();
        }

        $controller = new $controllerName();

        $method = $actionName;
        if (method_exists($controller, $method)) {
            $controller->$method($payload);
        } else {
            Route::Error();
        }
    }

    public static function Error()
    {
        header("HTTP 404 Not Found");
        header("Status: 404 Not Found");
        header('Location:/error');
    }
}
