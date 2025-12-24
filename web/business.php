
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
    $_SESSION['user'] = 'n';
}



function save_photo($filename, $title, $author) {

    $db = get_db();
    $dokument = [
        "name" => $filename,
        "title" => $title,
        "author" => $author,


    ]; 

    $db->photos->insertOne($dokument);
    
}

