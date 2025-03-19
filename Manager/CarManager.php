<?php
require_once("DatabaseManager.php");

/**
 * CarManager
 * Représente un gestionnaire de la table Car
 * Contient les méthodes et requêtes pour la table Car
 * Hérite de DatabaseManager, donc accès à la connexion PDO
 * via la méthode héritée statique getConnexion()
 */
class CarManager extends DatabaseManager
{
    /**
     * Récupère toutes les lignes de la table Car
     * @return array Tableau d'instances Car.
     */
    public function selectAll(): array
    {
        //Récupération de la connexion PDO et requête SQL
        $requete = self::getConnexion()->prepare("SELECT * FROM car;");
        $requete->execute();

        $arrayCars = $requete->fetchAll();
        //Créer un tableau qui contiendra les objets Car
        $cars = [];
        //Boucle sur le tableau $arrayCars pour créer les objets Car 
        // Chaque élément du tableau $arrayCar est un tableau associatif
        foreach ($arrayCars as $arrayCar) {
            //Istantiation d'un objet Car avec les données du tableau associatif  
            $cars[] = new Car($arrayCar["id"], $arrayCar["brand"], $arrayCar["model"], $arrayCar["horsePower"], $arrayCar["image"]);
        }

        return $cars;
    }

    /**
     * Récupère une ligne de la table Car par ID
     * @param  int $id
     * @return Car
     */
    public function selectByID(int $id): Car|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM car WHERE id = :id;");
        $requete->execute([
            ":id" => $id
        ]);

        $arrayCar = $requete->fetch();

        //Si pas de résultat fetch()
        if(!$arrayCar) {

            return false;
        }
        //Renvoyer l'instance d'un objet Car avec les données du tableau associatif
        return new Car($arrayCar["id"], $arrayCar["brand"], $arrayCar["model"], $arrayCar["horsePower"], $arrayCar["image"]);
    }

    /**
     * insertCar
     *
     * @param  Car $car
     * @return bool
     */
    public function insert(Car $car): bool
    {
        $requete = self::getConnexion()->prepare("INSERT INTO car (model,brand,horsePower,image) VALUES (:model,:brand,:horsePower,:image);");

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
     * @param  Car $car
     * @return bool
     */
    public function update(Car $car): bool
    {
        $requete = self::getConnexion()->prepare("UPDATE car SET model = :model, brand = :brand, horsePower = :horsePower, image = :image WHERE id = :id;");
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
     * @param  int $id
     * @return bool
     */
    public function deleteByID(int $id): bool
    {
        $requete = self::getConnexion()->prepare("DELETE FROM car WHERE id = :id;");
        $requete->execute([
            ":id" => $id
        ]);

        return $requete->rowCount() > 0;
    }
}
