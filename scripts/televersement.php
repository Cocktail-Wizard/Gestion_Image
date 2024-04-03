<?php
header('content-type: application/json');
if($_SERVER['REQUEST_METHOD'] == 'POST') 
{   // Vérifier si le fichier a été envoyé
    if(isset($_FILES['image'])){
        $erreurs = [];
        $image = $_FILES['image'];
        $cheminTemporaire = $image['tmp_name'];
        $nomFichier = $image['name'];
        
        
        // Vérifier si le fichier est une image
        $extensionsValides = ['jpg', 'jpeg', 'png', 'gif'];
        $extensionFichier = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));

        if(!in_array($extensionFichier, $extensionsValides)){
            $erreurs[] = 'Le fichier doit être une image (JPG, JPEG, PNG ou GIF)';
        }

        if(empty($erreurs)){
            $chemin = 'images/'.$nomFichier;
            move_uploaded_file($cheminTemporaire, $chemin);
            
            $nouveauNom = 'images/' . mt_rand('100000', '999999') . '.' . $extensionFichier;
            while(file_exists($nouveauNom)){
                $nouveauNom = mt_rand('100000', '999999') . '.' . $extensionFichier;
            }
            if(rename($chemin,'images/' . $nouveauNom)){
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
    