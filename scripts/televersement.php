<?php
header('content-type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST') 
{   // Vérifier si le fichier a été envoyé
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
            while(file_exists($nouveauNom)){
                $nouveauNom = mt_rand('100000', '999999') . '.' . $extensionFichier;
            }
            if(file_put_contents('images/'. $nouveauNom, $imageDecode)){
                echo json_encode(['chemin' => $nouveauNom]);
                exit();
            }
             else {
                $erreurs[] = 'Erreur lors du renommage du fichier'; 
                echo json_encode(['erreurs' => $erreurs]);
            }
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
    