<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
// Server
// !Change URL for every site!
// $path = str_replace("/webdev/SteveHarvey/mvc-autoload/", "/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// Local
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


spl_autoload_register(function (string $class_name) {

    require "src/" . str_replace("\\", "/", $class_name) . ".php";
});

$router = new Framework\Router;

// Routes
$router->add("/product/{slug:[\w-]+}", ["controller" => "products", "action" => "show"]);
$router->add("/{controller}/{id:\d+}/{action}");
$router->add("/home/index", ["controller" => "home", "action" => "index"]);
$router->add("/products", ["controller" => "products", "action" => "index"]);
$router->add("/products/show", ["controller" => "products", "action" => "show"]);
$router->add("/", ["controller" => "home", "action" => "index"]);
$router->add("/{controller}/{action}");

$params = $router->matchRoute($path);
if ($params === false) {

    exit("No matching route");
}

$controller = "App\Controllers\\" . ucwords($params["controller"]);
$action = $params["action"];


$controller_object = new $controller;

$controller_object->$action();
