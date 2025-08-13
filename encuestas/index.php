<?php
date_default_timezone_set('America/Costa_Rica');
session_start();
require_once 'app/config/autoload.php';
require_once 'app/config/database.php';

// Obtener la URL y dividirla en partes
$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';

$url = explode('/', rtrim($url, '/'));

$controllerName = ucfirst($url[0]) . 'Controller';
$methodName = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Instanciar el controlador y llamar al método
if (file_exists('app/controllers/' . $controllerName . '.php')) {
    $controller = new $controllerName();
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "Método no encontrado.";
        print_r($url);
        print_r($params);
    }
} else {
    // Redireccionar al login si no se encuentra el controlador y no hay sesión
    if (!isset($_SESSION['user_id'])) {
        header("Location: /encuestas/auth/login");
        exit();
    }
    // O mostrar un 404
    echo "Controlador no encontrado.";
    print_r($url);

}