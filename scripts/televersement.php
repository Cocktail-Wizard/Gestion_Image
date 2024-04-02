<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_FILES['image'])){
        $erreurs = [];
        $image = $_FILES['image'];
        $cheminTemporaire = $image['tmp_name'];
        $nomFichier = $image['name'];
        

    
    }

}
    