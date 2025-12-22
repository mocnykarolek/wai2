<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');





require_once 'business.php';
require_once 'controller.php';
require_once 'routing.php';

$action = $_SERVER['REQUEST_URI'];
$action = str_replace('/index.php', '', $action); // Czyścimy śmieci
$action = strtok($action, '?'); // Odcinamy parametry

// 2. RATUNEK DLA STARYCH LINKÓW:
// Jeśli adres jest pusty (czyli jesteś na index.php), ale masz stary parametr ?action=...
// To zamień go ręcznie na nowy format (np. z "gallery" zrób "/gallery")
if (($action == '' || $action == '/') && isset($_GET['action'])) {
    $action = '/' . $_GET['action'];
}

// 3. Domyślna strona główna
if ($action == '') {
    $action = '/';
}

require_once '../views/header.php';


dispatch($routing, $action);

require '../views/footer.php';


