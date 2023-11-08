<?php

namespace iutnc\touiteur\action;

use iutnc\touiteur\db\ConnectionFactory;

require_once "vendor/autoload.php";

class SuivreUtilAction extends Action {

    /**
     * Méthode qui permet à utilisateur de suivre un autre utilisateur
     * Dans la base de donné modifie la table suivis
     * @return string : l'utilisateur ou suis un autre ou demande au premier de se connecter
     */
    public function execute(): string {

        $html = "";

        if(isset($_SESSION['user'])){
            try{
                ConnectionFactory::makeConnection();
                $bdd = ConnectionFactory::$bdd;
            } catch(Exception $e){
                die('erreur :'.$e->getMessage());
            }
            // on récupère le mail de celui qui s'abonne et de la l'abonnement
            $emailUtil = unserialize($_SESSION['user'])->__get('email');
            $emailSuivi = $_GET['emailSuivi'];
            $req = $bdd->prepare("INSERT INTO suivis VALUES (:emailUtil, :emailSuivi)");
            $req->bindValue(":emailUtil", $emailUtil);
            $req->bindValue(":emailSuivi", $emailSuivi);
            $result = $req->execute();

            $html = "<p>Vous suivez {$emailSuivi}</p>";
        } else {
            header('Location:?action=sign-in');
            $html = "<p>veuillez vous connecter</p>";
        }

        return $html;
    }
}