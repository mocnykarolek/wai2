<?php

function generateThumbnail($src, $dest, $type){

    $thum_width = 200;
    $thum_height = 125;
    
    list($width, $height) = getimagesize($src);

    $m = imagecreatetruecolor($width, $height);


    //TODO: finish thumb function




}