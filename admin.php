<?php
require_once("functions.php");
require_once("Manager/DatabaseManager.php");
require_once("Manager/CarManager.php");
require_once("Model/Car.php");

// Vérifier que l'utilisateur est connecté
verifySession();

$carManager = new CarManager();
$cars = $carManager->selectAll();

$title = "Administration Garage";
require_once("header.php");
?>

<div class="container mt-4">
    <h1 class="text-center mb-4"><?= $title ?></h1>

    <div class="m-5">
        <a class="btn btn-success" href="add.php">Ajouter une Voiture</a>
    </div>

    <div class="d-flex flex-wrap justify-content-evenly gap-4">
        <?php foreach ($cars as $car): ?>
            <div class="col-md-4 mb-4 col-sm-6">
                <div class="card shadow-sm">
                    <img src="images/<?= $car->getImage() ?>" 
                         alt="<?= $car->getModel() ?>" 
                         class="card-img-top img-fluid rounded col-md-4 col-sm-6" style="height: 200px; width: auto;">                    
                    <div class="card-body">
                        <h5 class="card-title"><?= $car->getModel() ?></h5>
                        <p class="card-text"><?= $car->getBrand() ?> - <?= $car->getHorsePower() ?> chevaux</p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-primary" href="update.php?id=<?= $car->getId() ?>">Modifier</a>
                            <a class="btn btn-danger" href="delete.php?id=<?= $car->getId() ?>">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once("footer.php");