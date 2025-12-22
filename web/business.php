
<?php
function get_db()
{

    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]
    );
    
    $db = $mongo->wai;

    return $db;
}



function save_photo($filename, $title, $author) {

    $db = get_db();
    $dokument = [
        "name" => $filename,
        "title" => $title,
        "author" => $author,


    ];

    $db->products->insertOne($dokument);
    

    return;
}

