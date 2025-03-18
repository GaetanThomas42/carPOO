<?php
require_once("functions.php");
require_once("Car.php");
require_once("CarManager.php");

// Vérifier que l'utilisateur est connécté avec la présence
// D'un "username" en SESSION
verifySession();
//Vérifier si l'ID est présent dans l'url
if(!isset($_GET["id"])){
    header("Location: admin.php");
}

$carManager = new CarManager();
$car = $carManager->selectCarByID($_GET["id"]); // Un seul connect DB par page

//Vérifier si la voiture avec l'ID existe en BDD
if(!$car){
    header("Location: admin.php");
}

$errors = [];
// Si le formulaire est validé
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Vérifier les champs du formulaire
    $errors = validateCarForm($errors,$_POST);
    // Si le formulaire n'a pas renvoyé d'erreurs
    if (empty($errors)) {
        
        // Mettre à jour la voiture $car et rediriger
        $car->setModel($_POST["model"]);
        $car->setBrand($_POST["brand"]);
        $car->setImage($_POST["image"]);
        $car->setHorsePower($_POST["horsePower"]);

        $carManager->updateCarByID($car);
        header("Location: admin.php");
        exit();

    }

}


$title = "Modifier " . $car->getModel();
require_once("header.php");

?>

<h1 class="text-primary">Modifier <?= $car->getBrand() ?> <?= $car->getModel() ?> </h1>

<img src="images/<?= $car->getBrand() ?>" alt="<?= $car->getModel() ?>">


<form method="POST" action="update.php?id=<?= ($car->getId()) ?>">

    <label for="model">Model</label>
    <input id="model" type="text" name="model" value="<?= ($car->getModel())  ?>">
    <?php if (isset($errors['model'])): ?>
        <p class="text-danger"><?= $errors['model'] ?></p>
    <?php endif; ?>

    <label for="brand">Brand</label>
    <input type="text" name="brand" value="<?= $car->getBrand()  ?>">
    <?php if (isset($errors['brand'])): ?>
        <p class="text-danger"><?= $errors['brand'] ?></p>
    <?php endif; ?>

    <label for="horsePower">HorsePower</label>
    <input id="horsePower" type="number" name="horsePower" value="<?= $car->getHorsePower()  ?>">
    <?php if (isset($errors['horsePower'])): ?>
        <p class="text-danger"><?= $errors['horsePower'] ?></p>
    <?php endif; ?>

    <label for="image">Image</label>
    <input id="image" type="text" name="image">
    <?php if (isset($errors['image'])): ?>
        <p class="text-danger"><?= $errors['image'] ?></p>
    <?php endif; ?>

    <button class="btn btn-outline-success">Valider</button>

</form>
<?php
require_once("footer.php");
?>