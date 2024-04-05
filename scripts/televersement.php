<?php
require_once 'configBD.php';
header('content-type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST') 
{   // Vérifier si le fichier a été envoyé
    $conn = connexionBD();
    $donnee = json_decode(file_get_contents('php://input'), true);
    if(isset($donnee['image'])){
        $erreurs = [];
        $imageDecode = base64_decode($donnee['image']);
        $f = finfo_open();
        $typeMime = finfo_buffer($f, $imageDecode, FILEINFO_MIME_TYPE);
        $extensionFichier = explode('/', $typeMime)[1];
        
        // Vérifier si le fichier est une image
        $extensionsValides = ['jpg', 'jpeg', 'png', 'gif'];

        if(!in_array($extensionFichier, $extensionsValides)){
            $erreurs[] = 'Le fichier doit être une image (JPG, JPEG, PNG ou GIF)';
        }

        if(empty($erreurs)){
            // Ne fonctionne pas en raison des permissions du serveur
            $nouveauNom = mt_rand('100000', '999999') . '.' . $extensionFichier;
            
            $requete_preparee = $conn->prepare('INSERT INTO Images (nom, ImageBase64) VALUES (?,?)');
            $requete_preparee->bind_param('ss', $nouveauNom, $donnee['image']);
            $requete_preparee->execute();
            $requete_preparee->close();
            echo json_encode(['NomFichier' => $nouveauNom]);
            
            exit();
        } else {
            echo json_encode(['erreurs' => $erreurs]);
            exit();
        }
    }
    else {
        echo json_encode(['erreurs' => ['Aucun fichier envoyé']]);
        exit();
    }

}
else {
    echo json_encode(['erreurs' => ['Méthode non autorisée']]);
    exit();
}
    