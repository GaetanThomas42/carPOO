<?php
// 
require_once("header.php");
require_once("Manager/UserManager.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $errors = [];

    if (empty($_POST["username"])) {
        $errors["username"] = "Le username est vide";
    }

    if (empty($_POST["password"]) || strlen($_POST["password"]) < 8) {
        $errors["password"] = "le mot de passe est trop court !";
    }

    if (empty($errors)) {
        $userManager = new UserManager();

        $usernameExist = $userManager->selectUserByUsername($_POST["username"]);

        if ($usernameExist != false) {
            $errors["username"] = "Le username existe déja !";
        }

        if (empty($errors)) {

            $pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

            $user = new User(null, $_POST["username"], $pass);
            $userManager->insertUser($user);

            session_start();
            $_SESSION["username"] = $user->getUsername();
            header("Location: admin.php");
        }
    }
}

?>

<form method="POST" action="inscription.php">

    <span class="d-block p-2 text-bg-dark">

        <label for="Username">Username</label>
        <input type="text" name="username">

        <?php if (isset($errors["username"])) {
            echo ($errors["username"]);
        } ?>

    </span>

    <span class="d-block p-2 text-bg-dark">

        <label for="password">Mot de passe</label>
        <input type="password" name="password">

        <?php if (isset($errors["password"])) {
            echo ($errors["password"]);
        } ?>

    </span>
    <span class="d-block p-2 text-bg-dark">

        <button>Valider</button>
        <button formaction="index.php">Annuler</button>

    </span>

</form>

<a href="login.php">Se connecter</a>

<?php
require_once("footer.php");