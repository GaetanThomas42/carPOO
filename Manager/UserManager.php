<?php
require_once("DatabaseManager.php");
require_once("Model/User.php");


class UserManager extends DatabaseManager{

    public function selectUserByUsername(string $username): User|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM user WHERE username = :username;");
        $requete->execute([
            ":username" => $username
        ]);

        $arrayUser = $requete->fetch();
        //Si pas de résultat fetch()
        if(!$arrayUser) {

            return false;
        }
        //Renvoyer l'instance d'un objet Car avec les données du tableau associatif
        return new User($arrayUser["id"], $arrayUser["username"], $arrayUser["password"]);
    
    }

   public function insertUser(User $user): bool
   {
       $requete = self::getConnexion()->prepare("INSERT INTO user (username,password,email) VALUES (:username,:password,:email);");

       $requete->execute([
           "username" => $user->getUsername(),
           "password" => $user->getPassWord()
       ]);
       return $requete->rowCount() > 0;
   }
}