<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');





require_once 'business.php';
require_once 'controller.php';
require_once 'routing.php';

$action = $_GET['action'] ?? 'home';

require_once '../views/header.php';


dispatch($routing, $action);

require '../views/footer.php';


