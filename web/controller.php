<?php

function home_controller() {
    require_once '../views/home_view.php';
}

function gallery_controller() {


    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if($page <1) {
        $page = 1;
    }


    $data = showUsersPhotos($page);
    $photos = $data['photos'];
    $totalPages = $data['pages'];
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
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    if($page <1) {
        $page = 1;
    }


    $data = showUsersPhotos($page);
    $photos = $data['photos'];
    $totalPages = $data['pages'];




    $response_photo = $_FILES['file'];
    $response_title = $_POST['title'];
    $response_visibility = $_POST['visibility'];

    if ($response_photo['error'] !== UPLOAD_ERR_OK) {
        switch ($response_photo['error']) {
            case UPLOAD_ERR_NO_FILE:
                $status = "Nie wybrano pliku!";
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $status = "Plik jest za duży dla serwera (przekracza upload_max_filesize)!";
                break;
            default:
                $status = "Wystąpił błąd przesyłania: kod " . $response_photo['error'];
                break;
        }
        require_once '../views/galeria.php';
        return; 
    }

    if($response_photo['size'] > 1048576){
        $status = "Plik jest za duży! Maksymalnie 1MB.";
        require_once '../views/galeria.php';
        return;

    }
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($fileInfo, $response_photo['tmp_name']);

    $allowedTypes = ['image/jpeg', 'image/png'];

    

    if(!in_array($type, $allowedTypes)){
        $status = "Niedozwolony format! Tylko JPG i PNG.";
        require_once '../views/galeria.php';
        return;

    }

    
    $checkImage = getimagesize($response_photo['tmp_name']);
    if($checkImage === false) {
        $status = "To nie jest poprawny plik graficzny!";
        require_once '../views/galeria.php';
        return;
    }


    $uploadDirectory = 'images/input/';
    $file_name = $response_photo['name'];
    
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $photoName = uniqid() . '.' . $ext;

    $target = $uploadDirectory . $photoName;
    $thumbnailPath = $uploadDirectory . 't_' . $photoName;

    $author = $_POST['author'];
    if($author === ''){
        $author = 'Anonim' . uniqid();
    }

    if(move_uploaded_file($response_photo['tmp_name'], $target)){
        save_photo($photoName, $response_title, $author, $response_visibility);
        generateThumbnail($target, $thumbnailPath, $type, 200, 125);

        header("Location: /gallery");
        exit;

    }else{
        $status = "Przesyłanie nie powidło się!";
        header("Location: /gallery");
    }
    
    
}

function savephotosview_controller(){
    $photos = selectedPageViewPhoto();
    load_selected();
    
    require_once '../views/savedPhotosview.php';


}


function contact_controller() {
    $response = $_POST;

    save_contact($response['name'],$response['email'],$response['phone'], $response['message'],$response['preferences'],$response['consent'],$response['gender'] );


    require_once '../views/upload_view.php';
}