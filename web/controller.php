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
    if($page < 1) $page = 1;
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
        
        
        $result = process_photo_upload(
            $_FILES['file'], 
            $_POST, 
            $_SESSION['username'] ?? null
        );

        if ($result['success']) {
            
            header("Location: /gallery");
            exit;
        } else {
            
            $status = $result['message'];
        }
    }

    $data = showUsersPhotos($page);
    $photos = $data['photos'];
    $totalPages = $data['pages'];
    
    require_once '../views/galeria.php';
    
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