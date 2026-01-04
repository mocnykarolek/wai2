<?php

function generateThumbnail($src, $dest, $type, $thum_width, $thum_height)
{




    list($width, $height) = getimagesize($src);


    $thumb = imagecreatetruecolor($thum_width, $thum_height);


    if ($type === 'image/jpeg' || $type === 'image/jpg') {
        $source = imagecreatefromjpeg($src);
    } elseif ($type === 'image/png') {
        $source = imagecreatefrompng($src);


        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    } else {
        return false;
    }


    imagecopyresampled(
        $thumb,
        $source,
        0,
        0,
        0,
        0,
        $thum_width,
        $thum_height,
        $width,
        $height
    );

    
    if ($type === 'image/jpeg' || $type === 'image/jpg') {
        imagejpeg($thumb, $dest, 80);
    } elseif ($type === 'image/png') {
        imagepng($thumb, $dest);
    }

    


    return true;
}


function showUsersPhotos($page)
{
    $db = get_db();


    $currentUser = $_SESSION['username'] ?? null;
    $maxShownPhotos = 6;


    $filter = [
        '$or' => [
            ['visibility' => 'public'],
            ['visibility' => 'private', 'author' => $currentUser]
        ]
    ];

    $totalPhotos = $db->photos->count($filter);

    $pagesToRender = ceil($totalPhotos / $maxShownPhotos);

    $skip = ($page - 1) * $maxShownPhotos;
    $options = [
        'skip' => $skip,
        'limit' => $maxShownPhotos,
    ];

    $photos = $db->photos->find($filter, $options);

    return [
        'photos' => $photos,
        'pages' => $pagesToRender
    ];
}




function isChecked($photo)
{
    $selected_photos = $_SESSION['SELECTED_PHOTOS'] ?? [];

    if (in_array($photo, $selected_photos)) {
        return true;
    }
    return false;
}


function process_photo_upload($file, $postData, $username)
{
   
    if ($file['error'] !== UPLOAD_ERR_OK) {
        switch ($file['error']) {
            case UPLOAD_ERR_NO_FILE:
                $message = "Nie wybrano żadnego pliku!";
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = "Plik jest za duży dla serwera (przekracza upload_max_filesize lub post_max_size)!";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "Plik został przesłany tylko częściowo (błąd sieci?).";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Błąd serwera: Brak folderu tymczasowego.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Błąd serwera: Nie udało się zapisać pliku na dysk.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "Rozszerzenie PHP zablokowało przesyłanie pliku.";
                break;
            default:
                $message = "Wystąpił nieznany błąd przesyłania: kod " . $file['error'];
                break;
        }
        
        return ['success' => false, 'message' => $message];
    }

    
    if ($file['size'] > 1048576) {
        return ['success' => false, 'message' => "Plik jest za duży!"];
    }

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $type = finfo_file($fileInfo, $file['tmp_name']);


    if (!in_array($type, ['image/jpeg', 'image/png'])) {
        return ['success' => false, 'message' => "Tylko JPG i PNG!"];
    }

    
    $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/images/input/';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $photoName = uniqid() . '.' . $ext;
    $target = $uploadDirectory . $photoName;
    $thumbnailPath = $uploadDirectory . 't_' . $photoName;

    $author = !empty($username) ? $username : ('Anonim' . uniqid());
    $visibility = $postData['visibility'] ?? 'public';
    if (empty($username)) {
        $visibility = 'public';
    } 

    
    if (move_uploaded_file($file['tmp_name'], $target)) {
        save_photo($photoName, $postData['title'], $author, $visibility);
        generateThumbnail($target, $thumbnailPath, $type, 200, 125);

        return ['success' => true, 'message' => 'Udało się!'];
    }

    return ['success' => false, 'message' => "Błąd zapisu na dysku."];
}
