<?php
require_once("CarManager.php");
require_once("connectDB.php");
require_once("Car.php");

$pdo = connectDB();
$carManager = new CarManager();
$cars = $carManager->selectAllCars($pdo);

$title = "Bienvenue dans le Garage";
require_once("header.php");
?>
<h1>Listes des Voitures</h1>
<div class="d-flex flex-wrap">
    <?php foreach ($cars as $car): ?>
        <div class="col-4 d-flex p-3 justify-content-center">
            <img src="images/<?= $car->getImage() ?>" alt="<?= $car->getModel() ?>">
            <div class="p-2">
                <h2><?= $car->getModel() ?></h2>
                <p><?= $car->getBrand() ?>, <?= $car->getHorsePower() ?> chevaux</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
require_once("footer.php");
?>