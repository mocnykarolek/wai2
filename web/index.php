<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');



require_once 'business.php';
require_once 'controller.php';
require_once 'routing.php';


// $action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);



// $action = str_replace('/index.php', '', $action);


// $action = rtrim($action, '/');

// // /recipes
// if (empty($action)) {
//     $action = '/';
// }



// echo $action;
$action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$script_name = dirname($_SERVER['SCRIPT_NAME']);
if (strpos($action, $script_name) === 0) {
    $action = substr($action, strlen($script_name));
}
$action = rtrim($action, '/');
if (empty($action)) {
    $action = '/';
}

echo $action;

require_once '../views/header.php';


dispatch($routing, $action);


require '../views/footer.php';


