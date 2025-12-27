<?php

function generateThumbnail($src, $dest, $type, $thum_width, $thum_height)
{
    // 1. Wymiary zgodne z instrukcją


    // 2. Pobieramy wymiary oryginału
    list($width, $height) = getimagesize($src);

    // --- POPRAWKA 1: Płótno ma mieć rozmiar miniatury, a nie oryginału! ---
    $thumb = imagecreatetruecolor($thum_width, $thum_height);

    // 3. Wczytywanie (obsługa jpeg i jpg)
    // --- POPRAWKA 2: Spójne sprawdzanie MIME ---
    if ($type === 'image/jpeg' || $type === 'image/jpg') {
        $source = imagecreatefromjpeg($src);
    } elseif ($type === 'image/png') {
        $source = imagecreatefrompng($src);

        // Przezroczystość dla PNG
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
    } else {
        return false;
    }

    // 4. Skalowanie
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

    // 5. Zapis na dysk
    if ($type === 'image/jpeg' || $type === 'image/jpg') {
        imagejpeg($thumb, $dest, 80);
    } elseif ($type === 'image/png') {
        imagepng($thumb, $dest);
    }

    // 6. Sprzątanie


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

    $skip = ($page -1) * $maxShownPhotos;
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




function isChecked($photo){
    $selected_photos = $_SESSION['SELECTED_PHOTOS'] ?? [];
    
    if(in_array($photo, $selected_photos)){
        return true;
    }
    return false;
}