<?php
function connexionBD(): ?mysqli
{
    $DB_HOST = 'localhost';
    $DB_USER = 'equipe105';
    $DB_PASSWORD = 'PWmVgQITNHZA7g6J';
    $DB_NAME = 'equipe105';
    try {
        // Créer la connexion à la base de données directement
        $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

        if ($conn->connect_error !== null) {
            http_response_code(500);
            echo json_encode("Erreur de connexion à la base de données.");
            exit();
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode("Erreur : " . $e->getMessage());
        exit();
    }
    return $conn;
}