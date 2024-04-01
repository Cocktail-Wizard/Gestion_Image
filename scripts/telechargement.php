<?php
$nomImage = $_GET['image'];
$chemin = 'images/'.$nomImage;

if(file_exists($chemin)){
    $imageInfo = getimagesize($chemin);
    header('Content-Type: '.$imageInfo['mime']);
    readfile($chemin);
    exit;
} else {
    echo 'Fichier non trouvé';
}