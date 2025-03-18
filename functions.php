<?php
/**
 * Récupère toutes les voitures de la base de données.
 *
 * @param PDO $pdo La connexion PDO.
 *
 * @return array Tableau d'instances Car.
 */
function selectAllCars(PDO $pdo): array
{
    $requete = $pdo->prepare("SELECT * FROM car;");
    $requete->execute();
    $arrayCars = $requete->fetchAll();
    //Je parcours le tableau de résultats 
    $cars = [];
    foreach ($arrayCars as $arrayCar) {
        //J'instancie un objet avec les données d'une Voiture ( tableau associatif)
        $cars[] = new Car($arrayCar["id"], $arrayCar["brand"], $arrayCar["model"], $arrayCar["horsePower"], $arrayCar["image"]);
    }

    return $cars;
}

/**
 * Récupère une voiture par ID de la base de données.
 * @param  PDO $pdo
 * @param  int $id
 * @return Car
 */
function selectCarByID(PDO $pdo, int $id): Car|false
{
    $requete = $pdo->prepare("SELECT * FROM car WHERE id = :id;");
    $requete->execute([
        ":id" => $id
    ]);

    $arrayCar = $requete->fetch(); 

    $carObject = new Car($arrayCar["id"], $arrayCar["brand"], $arrayCar["model"], $arrayCar["horsePower"], $arrayCar["image"]);

    //Retourner l'instance de Car créée avec l'occurence Car de la BDD
    return $carObject;
}

/**
 * insertCar
 *
 * @param  PDO $pdo
 * @param  Car $car
 * @return bool
 */
function insertCar(PDO $pdo, Car $car): bool
{
    $requete = $pdo->prepare("INSERT INTO car (model,brand,horsePower,image) VALUES (:model,:brand,:horsePower,:image);");
    
    $requete->execute([
        ":model" => $car->getModel(),
        ":brand" => $car->getBrand(),
        ":horsePower" => $car->getHorsePower(),
        ":image" => $car->getImage()
    ]);

    return $requete->rowCount() > 0;

}

/**
 * updateCarByID
 *
 * @param  PDO $pdo
 * @param  Car $car
 * @return bool
 */
function updateCarByID(PDO $pdo, Car $car): bool
{
    $requete = $pdo->prepare("UPDATE car SET model = :model, brand = :brand, horsePower = :horsePower, image = :image WHERE id = :id;");
    $requete->execute(
        [
            ":model" => $car->getModel(),
            ":brand" => $car->getBrand(),
            ":horsePower" => $car->getHorsePower(),
            ":image" => $car->getImage(),
            ":id" => $car->getId()
        ]
    );

    return $requete->rowCount() > 0;

}

/**
 * deleteCarByID
 *
 * @param  PDO $pdo
 * @param  int $id
 * @return bool
 */
function deleteCarByID(PDO $pdo, int $id): bool
{
    $requete = $pdo->prepare("DELETE FROM car WHERE id = :id;");
    $requete->execute([
        ":id" => $id
    ]);

    return $requete->rowCount() > 0;

}



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