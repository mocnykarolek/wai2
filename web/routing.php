<?php

$routing = [
    '/' => 'home_controller',
    '/home' => 'home_controller',
    '/gallery' => 'gallery_controller',
    '/aboutme' => 'aboutme_controller',
    '/recipes' => 'przepisy_controller',
    '/form' => 'form_controller',
    '/answer' => 'answer_controller',
    '/upload' => 'contact_controller',
    '/addPhoto' => 'addPhoto_controller',
    '/logout' => 'logout_controller',
    '/loginpage' => 'loginpage_controller',
    '/signup' => 'signup_controller',
    
    
    

];

function dispatch($routing, $action_url) {
    
    
    if (array_key_exists($action_url, $routing)) {
        $function_name = $routing[$action_url];
        $function_name(); 
    } else {
        echo $action_url;
        http_response_code(404);
        echo "<h1>Błąd 404 - Strona nie istnieje</h1>";
    }
}


