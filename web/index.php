<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once '../../vendor/autoload.php';

require_once 'business.php';
require_once 'controller.php';
require_once 'routing.php';
require_once 'functions.php';

$action = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$action = str_replace('/index.php', '', $action);

$action = rtrim($action, '/');



if (empty($action)) {
    $action = '/';
}


echo $action;
require_once '../views/header.php';


dispatch($routing, $action);


require '../views/footer.php';







// ajax wyszkukiwarka zdjęc