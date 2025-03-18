<?php
require_once("functions.php");
require_once("connectDB.php");
require_once("Car.php"); 
require_once("CarManager.php");


// Vérifier que l'utilisateur est connécté avec la présence
verifySession();
//Vérifier si l'ID est présent dans l'url
if(!isset($_GET["id"])){
    header("Location: admin.php");
}
//Select by id
$pdo = connectDB(); // Un seul connect DB par page

$carManager = new CarManager();
$car = $carManager->selectCarByID($pdo, $_GET["id"]);

//Vérifier si la voiture avec l'ID existe en BDD
if(!$car){
    header("Location: admin.php");
}


//Si le form est validé
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Supprimer la voiture et rediriger
    $carManager = new CarManager();
    $carManager->deleteCarByID($pdo, $car->getId());
    header("Location: admin.php?delete=ok");
}

$title = "Supprimer " . $car->getModel();
require_once("header.php");
?>

<h1>Confirmer la suppression de <?= $car->getBrand() ?> <?= $car->getModel() ?> ?</h1>

<form class="p-3" method="POST" action="delete.php?id=<?= $car->getId(); ?>">
    <!-- Redirection admin -->
    <input class="btn btn-outline-primary me-3" type="submit" value="Annuler" formaction="admin.php">
    <!-- Redirection index -->
    <input class="btn btn-outline-danger" type="submit" value="Confirmer">
</form>


<?php
require_once("footer.php");
?>