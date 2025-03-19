<?php
require_once("functions.php");
require_once("Manager/UserManager.php");


$errors = [];
//Me permet de créer le MDP HASHÉ et de copié coller en bdd
$pass = password_hash("admin",PASSWORD_DEFAULT);
var_dump($pass);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    if (empty($_POST['username']) || strlen($_POST['username']) < 4) {
        $errors[] = 'Votre username doit contenir 4 caracteres';
    }
    if (empty($_POST['password']) || strlen($_POST['password']) < 4) {
        $errors[] = 'Votre password doit contenir 4 caracteres';
    }
    
    if(count($errors) == 0){
        
        $userManager = new UserManager();
        $user = $userManager->selectUserByUsername($_POST["username"]);

        //Vérification si User trouvée avec le Username
        if($user != false){
            //Sinon vérificaiton mot de passe Formulaire et Hash BDD
            if(password_verify($_POST["password"], $user->getPassword())){ 
                // Je connecte l'utilisateur
                session_start();
                $_SESSION["username"] = $user->getUsername();
                header('Location: admin.php');
                exit();
            }
        }
        //Afficher la même erreur si le problème vient du MDP ou Username
        // Pour ne pas donner trop d'informations
        $errors["login"] = 'Identifiants ou mot de passe incorrecte';
    }
}


$title = "Connexion";
require_once("header.php");
?>
<h1>Login</h1>
<form method="POST" action="login.php">
    <label>Username</label>
    <input required type="text" name="username">
    <label>Password</label>
    <input required type="password" name="password">
    <button class="btn btn-outline-success">Se connecter</button>
</form>

<?php
include("footer.php");
