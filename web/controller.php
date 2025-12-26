<?php

function home_controller() {
    require_once '../views/home_view.php';
}

function gallery_controller() {

    $photos = showUsersPhotos();
    load_selected();
    
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

function logout_controller(){
    $_SESSION = [];

    session_destroy();
    $params = session_get_cookie_params();
    setcookie(session_name(), "", time() - 42000, $params['path'], $params["domain"],$params["secure"], $params["httponly"]);
    header('Location: /home');
}

function loginpage_controller(){

    require_once '../views/loginpage.php';

}

function signup_controller(){
    if($_POST['signup'] === 'register'){
        addNewUser();
    }
    else if($_POST['signup'] === 'login'){
        loginAuth();
    }
    
    

}

function saveSelected_controller(){


    handleSelected();
    header("Location: /gallery");
    

}

function addPhoto_controller(){
    $photos = showUsersPhotos();
    if(!isset($_SESSION['username'])){
        $status = "Musisz być zalogowany aby móc dodać zdjęcie!";
        require_once '../views/galeria.php';
        return;
    }


    $response_photo = $_FILES['file'];
    $response_title = $_POST['title'];
    $response_visibility = $_POST['visibility'];

    if($response_photo['error'] === UPLOAD_ERR_NO_FILE){
        $status = "Nie dodałeś pliku!";
        require_once '../views/galeria.php';
        return;
    }

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($fileInfo, $response_photo['tmp_name']);

    $allowedTypes = ['image/jpeg', 'image/png'];

    if($response_photo['size'] > 1048576){
        $status = "Plik jest za duży! Maksymalnie 1MB.";
        require_once '../views/galeria.php';
        return;

    }

    if(!in_array($type, $allowedTypes)){
        $error = "Niedozwolony format! Tylko JPG i PNG.";
        require_once '../views/galeria.php';
        return;

    }


    $uploadDirectory = 'images/input/';
    $file_name = $response_photo['name'];
    
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $photoName = uniqid() . '.' . $ext;

    $target = $uploadDirectory . $photoName;
    $thumbnailPath = $uploadDirectory . 't_' . $photoName;

    if(move_uploaded_file($response_photo['tmp_name'], $target)){
        save_photo($photoName, $response_title, $_SESSION['username'], $response_visibility);
        generateThumbnail($target, $thumbnailPath, $type, 200, 125);

        header("Location: /gallery");
        exit;

    }else{
        $status = "Przesyłanie nie powidło się!";
        header("Location: /gallery");
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