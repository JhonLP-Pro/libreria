<?php

class Utilisateur{
    
    function __construct($bdd)
    {
        $this->bdd = $bdd;   
    }

    public function ajouterUtilisateur($nom, $prenom, $adresse, $telephone, $password)
    {
        try {
            $hashPassword = sha1($password);
            $type_utilisateur = 2; // Type par défaut pour les nouveaux utilisateurs

            $req = $this->bdd->prepare('INSERT INTO utilisateur(nom, prénom, adresse, téléphone, mdp, type_utilisateur) 
                                      VALUES(:nom, :prenom, :adresse, :telephone, :password, :type_utilisateur)');
            $req->bindParam(':nom', $nom);
            $req->bindParam(':prenom', $prenom);
            $req->bindParam(':adresse', $adresse);
            $req->bindParam(':telephone', $telephone);
            $req->bindParam(':password', $hashPassword);
            $req->bindParam(':type_utilisateur', $type_utilisateur);
            return $req->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    public function login($adresse, $password)
    {
        try {
            $hashPassword = sha1($password);
            $req = $this->bdd->prepare('SELECT * FROM utilisateur WHERE adresse = :adresse AND mdp = :password');
            $req->bindParam(':adresse', $adresse);
            $req->bindParam(':password', $hashPassword);
            $req->execute();
            return $req->fetch();
        } catch (PDOException $e) {
            error_log("Erreur lors de la connexion : " . $e->getMessage());
            return false;
        }
    }

    public function getAllUsers()
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM utilisateur');
            $req->execute();
            return $req->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
            return false;
        }
    }
    
    public function getUserById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
            $req->bindParam(':id', $id);
            $req->execute();
            return $req->fetch();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }
}

?>