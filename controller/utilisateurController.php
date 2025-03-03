<?php
require_once('../model/utilisateurModel.php');
require_once('../bdd/bdd.php');

if(isset($_POST['action'])){
    $utilisateurController = new UtilisateurController($bdd);

    switch($_POST['action']){
        case 'inscription':
            $utilisateurController->create();
            break;
        
        case 'login':
            $utilisateurController->login();
            break;
        
        case 'rechercher':
            $utilisateurController->getUserbyid();
            break;
        default:
            break;
    }
}

class UtilisateurController{

    private $utilisateur;

    public function __construct($bdd)
    {
        $this->utilisateur = new Utilisateur($bdd);
    }

    public function create()
    {    
        // Vérifier que tous les champs sont remplis
        if(empty($_POST['nom']) || empty($_POST['prénom']) || empty($_POST['adresse']) || empty($_POST['téléphone']) || empty($_POST['mdp'])) {
            die("Tous les champs sont obligatoires");
        }

        // Vérifier que l'adresse est un email valide
        if (!filter_var($_POST['adresse'], FILTER_VALIDATE_EMAIL)) {
            die("L'adresse email n'est pas valide");
        }

        // Tenter d'ajouter l'utilisateur
        $result = $this->utilisateur->ajouterUtilisateur(
            $_POST['nom'], 
            $_POST['prénom'], 
            $_POST['adresse'],
            $_POST['téléphone'],
            $_POST['mdp']
        );
        
        if($result) {
            header('Location: /libreria/index.php?page=connexion');
        } else {
            die("Erreur lors de l'inscription. Veuillez réessayer.");
        }    
    }

    public function login()
    {    
        if (!isset($_POST['adresse']) || !isset($_POST['mdp'])) {
            die("Veuillez remplir tous les champs du formulaire");
        }

        $user = $this->utilisateur->login($_POST['adresse'], $_POST['mdp']);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header('Location: /libreria/index.php?page=accueil');
        } else {
            die("Adresse email ou mot de passe incorrect");
        }
    }

    public function getUserbyid()
    {
        if (!isset($_POST['id_utilisateur'])) {
            die("Veuillez fournir un id");
        }

        $user = $this->utilisateur->getUserById($_POST['id_utilisateur']);
        return $user;
    }
}
?>