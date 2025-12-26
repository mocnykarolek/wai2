<?php

function generateThumbnail($src, $dest, $type) {
    // 1. Wymiary zgodne z instrukcją
    $thum_width = 200;
    $thum_height = 125;
    
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
        $thumb, $source, 
        0, 0, 0, 0, 
        $thum_width, $thum_height, 
        $width, $height
    );

    // 5. Zapis na dysk
    if ($type === 'image/jpeg' || $type === 'image/jpg') {
        imagejpeg($thumb, $dest, 80);
    } elseif ($type === 'image/png') {
        imagepng($thumb, $dest);
    }

    // 6. Sprzątanie
    imagedestroy($thumb);
    imagedestroy($source);

    return true;
}