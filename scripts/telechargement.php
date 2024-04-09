<?php
require_once 'configBD.php';
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(empty($_GET['image'])){
        $imageInfo = getimagesize(__DIR__.'/images/defaut.jpg');
        header('Content-Type: '.$imageInfo['mime']);
        readfile(__DIR__ . '/images/defaut.jpg');
        exit();
    }
    $conn = connexionBD();
    $nomImage = trim($_GET['image']);
    
    $requete_preparee = $conn->prepare('SELECT ImageBase64 FROM Images WHERE nom = ?');
    $requete_preparee->bind_param('s', $nomImage);
    $requete_preparee->execute();
    $resultat = $requete_preparee->get_result();
    $requete_preparee->close();
    if($resultat->num_rows === 0){
        $imageInfo = getimagesize(__DIR__.'/images/defaut.jpg');
        header('Content-Type: '.$imageInfo['mime']);
        readfile(__DIR__ . '/images/defaut.jpg');
        exit();
    } else {
        $image = $resultat->fetch_assoc();
    }
    $typeImage = explode('.', $nomImage)[1];
    header('Content-Type: image/'.$typeImage); 
    echo base64_decode($image['ImageBase64']);

} else {
    header('CONTENT-TYPE: application/json');
    echo json_encode(['erreurs' => ['Méthode non autorisée']]);
    exit();
    
}
