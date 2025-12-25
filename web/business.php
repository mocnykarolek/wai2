
<?php
function get_db()
{

    $mongo = new MongoDB\Client(
        "mongodb://127.0.0.1:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]
    );
    
    $db = $mongo->wai;

    return $db;
}

function save_contact($name, $email, $phone, $message, $contact, $consent, $sex){

    $db = get_db();
    $document = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'message' => $message,
        'contact' => $contact,
        'consent' => $consent,
        'sex' => $sex,

    ];
    $db->contacts->insertOne($document);

}

function addNewUser(){


    $db = get_db();
    
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = [
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'password' => $hash,
    ];

    $user = $db->users->findOne(['username' => $query['username']]);
    $email = $db->users->findOne(['email' => $query['email']]);

    
    if($user !== null){
        $status = 'Użytkownik o takiej nazwie juz istnieje!';
        
        require_once '../views/loginpage.php';
        return;
    }
    if($email !== null){
        $status = 'Użytkownik z takim emailem juz istnieje!';
        
        require_once '../views/loginpage.php';
        return;
    }

    $db->users->insertOne($query);

    $_SESSION['user_id'] = $user['_id'];
    $_SESSION['username'] = $query['username'];
    $status = 'Utworzono konto poprawnie!';
    header("Refresh: 3; url=/home");

    require_once '../views/validlogin.php';
    


    

}

function loginAuth(){

    $db = get_db();
    

    $query = [
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'password' => $_POST['password'],
    ];

    $user = $db->users->findOne(['username' => $query['username']]);
    
    
    if($user === null){
        $status = 'Nie znaleziono takiej użytkowanika!';
        
        require_once '../views/loginpage.php';
        return;
    }
    if($user['email'] !== $query['email']){
        $status = 'Błędny email!';
        
        require_once '../views/loginpage.php';
        return;
    }
    if(!password_verify($query['password'], $user['password'] )){
        $status = 'Błędne hasło!';
        
        require_once '../views/loginpage.php';
        return;
    }
    

    $_SESSION['user_id'] = $user['_id'];
    $_SESSION['username'] = $query['username'];
    $status = 'Zalogowano!';
    
    header("Refresh: 3; url=/home");

    require_once '../views/validlogin.php';
    


    



}



function save_photo($filename, $title, $author, $visibility) {

    $db = get_db();
    $dokument = [
        "filename" => $filename,
        "title" => $title,
        "author" => $author,
        "visibility" => $visibility,

    ]; 

    $db->photos->insertOne($dokument);
    
}

