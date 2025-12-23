<?php

function home_controller() {
    require_once '../views/home_view.php';
}

function gallery_controller() {
    require_once '../views/galeria.php';
}

function aboutme_controller() {
    require_once '../views/aboutme.php';
}

function form_controller() {
    require_once '../views/form.php';
}
function przepisy_controller() {
    require_once '../views/przepisy.php';
}

function answer_controller(){

    echo "niggerr";

}


function recipes_controller() {
    // Jeśli nie masz widoku przepisów, wyświetlimy tymczasowy tekst
    echo "<h1>Strona z przepisami w budowie</h1>"; 
}

// Funkcja obsługująca wysyłanie zdjęć (logikę dodamy za chwilę)
function upload_controller() {

    require_once '../views/upload_view.php';
}