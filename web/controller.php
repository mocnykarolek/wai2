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

function addPhoto_controller(){
    
    $response_photo = $_FILES['file'];

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($fileInfo, $response_photo['tmp_name']);

    $allowedTypes = ['image/jpg', 'image/png', 'image/jpeg'];

    if(!in_array($type, $allowedTypes)){
        die("Błędny format pliku! Plik jaki dodałeś: " . $type);

    }


    $uploadDirectory = 'images/input/';
    $file_name = $response_photo['name'];
    
    $target = $uploadDirectory . $file_name;

    if(move_uploaded_file($response_photo['tmp_name'], $target)){
        save_photo($file_name, 'test', 'Karol');
        header("Location: /gallery");
        exit;

    }else{
        echo "niepoprawne przeslanie pliku";
    }

    
}


function recipes_controller() {
    // Jeśli nie masz widoku przepisów, wyświetlimy tymczasowy tekst
    echo "<h1>Strona z przepisami w budowie</h1>"; 
}

// Funkcja obsługująca wysyłanie zdjęć (logikę dodamy za chwilę)
function contact_controller() {
    $response = $_POST;

    save_contact($response['name'],$response['email'],$response['phone'], $response['message'],$response['preferences'],$response['consent'],$response['gender'] );


    require_once '../views/upload_view.php';
}