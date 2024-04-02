<?php
if(empty($_GET['image'])){
    $imageInfo = getimagesize('images/defaut.jpg');
    header('Content-Type: '.$imageInfo['mime']);
    readfile('images/defaut.jpg');
    exit();
}
$nomImage = $_GET['image'];
$chemin = 'images/'.$nomImage;


if(file_exists($chemin)){
    $imageInfo = getimagesize($chemin);
    header('Content-Type: '.$imageInfo['mime']);
    readfile($chemin);
    exit();
} else {
    $imageInfo = getimagesize('images/defaut.jpg');
    header('Content-Type: '.$imageInfo['mime']);
    readfile('images/defaut.jpg');
    exit();
}