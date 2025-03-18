<?php

class CarManager
{


    /**
     * Récupère toutes les voitures de la base de données.
     *
     * @param PDO $pdo La connexion PDO.
     *
     * @return array Tableau d'instances Car.
     */
    public function selectAllCars(PDO $pdo): array
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
    public function selectCarByID(PDO $pdo, int $id): Car|false
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
    public function insertCar(PDO $pdo, Car $car): bool
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
    public function updateCarByID(PDO $pdo, Car $car): bool
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
    public function deleteCarByID(PDO $pdo, int $id): bool
    {
        $requete = $pdo->prepare("DELETE FROM car WHERE id = :id;");
        $requete->execute([
            ":id" => $id
        ]);

        return $requete->rowCount() > 0;
    }

}
