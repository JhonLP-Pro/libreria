<?php
session_start();
require_once(__DIR__ . '/../model/utilisateurModel.php');
require_once(__DIR__ . '/../bdd/bdd.php');

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
        try {
            // Vérifier que tous les champs sont remplis
            if(empty($_POST['nom']) || empty($_POST['prénom']) || empty($_POST['adresse']) || empty($_POST['téléphone']) || empty($_POST['mdp'])) {
                $_SESSION['error'] = "Tous les champs sont obligatoires";
                header('Location: ../index.php?page=connexion');
                exit();
            }

            // Vérifier que l'adresse est un email valide
            if (!filter_var($_POST['adresse'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "L'adresse email n'est pas valide";
                header('Location: ../index.php?page=connexion');
                exit();
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
                $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                header('Location: ../index.php?page=connexion');
                exit();
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors de l'inscription";
                header('Location: ../index.php?page=connexion');
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
            header('Location: ../index.php?page=connexion');
            exit();
        }
    }

    public function login()
    {
        try {
            if(empty($_POST['adresse']) || empty($_POST['mdp'])) {
                $_SESSION['error'] = "Tous les champs sont obligatoires";
                header('Location: ../index.php?page=connexion');
                exit();
            }

            $user = $this->utilisateur->login($_POST['adresse'], $_POST['mdp']);
            
            if($user) {
                $_SESSION['user'] = $user;
                header('Location: ../index.php?page=accueil');
                exit();
            } else {
                $_SESSION['error'] = "Email ou mot de passe incorrect";
                header('Location: ../index.php?page=connexion');
                exit();
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Une erreur est survenue lors de la connexion";
            header('Location: ../index.php?page=connexion');
            exit();
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