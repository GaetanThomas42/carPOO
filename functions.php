<?php

// Class CarForm... ?
function validateCarForm(array $errors, array $carForm): array
{
    if (empty($carForm["model"])) {
        $errors["model"] = "le modele de voiture est manquant";
    }
    if (empty($carForm["brand"])) {
        $errors["brand"] = "la marque de la voiture est manquante";
    }
    if (empty($carForm["horsePower"])) {
        $errors["horsePower"] = "la puissance du vehicule est manquante";
    }
    if (empty($carForm["image"])) {
        $errors["image"] = "l'image de la voiture est manquante";
    }
    //Démo class CarFormValidator
    
    return $errors;
}

//Class UserManager
function selectUserByUsername(PDO $pdo, string $username): array|false
{
    $requete = $pdo->prepare("SELECT * FROM user WHERE username = :username;");
    $requete->execute([
        ":username" => $username
    ]);
    return $requete->fetch();
}

//Class SessionChecker
function verifySession(): void
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit();
    }
}