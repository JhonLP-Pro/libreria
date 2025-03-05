<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../model/pretModel.php');
require_once(__DIR__ . '/../bdd/bdd.php');

if(isset($_POST['action'])) {
    $pretController = new PretController($bdd);

    switch($_POST['action']) {
        case 'emprunter':
            $pretController->emprunterLivre();
            break;
        case 'retourner':
            $pretController->retournerLivre();
            break;
        default:
            header('Location: ../index.php?page=catalogue');
            exit();
    }
}

class PretController {
    private $pret;
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
        $this->pret = new Pret($bdd);
    }

    /**
     * Vérifie si un utilisateur peut emprunter des livres
     */
    public function peutEmprunter($id_utilisateur) {
        return $this->pret->peutEmprunter($id_utilisateur);
    }

    /**
     * Récupère les prêts selon leur statut
     */
    public function getPretsByStatus($status = 'en cours') {
        try {
            return $this->pret->getPretsByStatus($status);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Emprunter un livre
     */
    public function emprunterLivre() {
        try {
            // Vérifier si l'utilisateur est connecté
            if(!isset($_SESSION['user'])) {
                throw new Exception("Vous devez être connecté pour emprunter un livre");
            }

            // Vérifier les paramètres
            if(empty($_POST['id_livre'])) {
                throw new Exception("ID du livre manquant");
            }

            $id_utilisateur = $_SESSION['user']['id_utilisateur'];
            $id_livre = $_POST['id_livre'];

            // Vérifier si l'utilisateur peut emprunter
            if(!$this->peutEmprunter($id_utilisateur)) {
                throw new Exception("Vous ne pouvez pas emprunter plus de livres pour le moment");
            }

            // Créer le prêt
            $result = $this->pret->creerPret($id_utilisateur, $id_livre);
            
            if($result) {
                header('Location: ../index.php?page=mes-emprunts&success=emprunt');
            } else {
                throw new Exception("Erreur lors de l'emprunt");
            }
        } catch (Exception $e) {
            header('Location: ../index.php?page=catalogue&error=' . urlencode($e->getMessage()));
        }
        exit();
    }

    /**
     * Retourner un livre
     */
    public function retournerLivre() {
        try {
            // Vérifier si l'utilisateur est connecté
            if(!isset($_SESSION['user'])) {
                throw new Exception("Vous devez être connecté pour retourner un livre");
            }

            // Vérifier les paramètres
            if(empty($_POST['id_pret'])) {
                throw new Exception("ID du prêt manquant");
            }

            // Vérifier si l'utilisateur est admin ou si c'est son propre prêt
            $is_admin = isset($_SESSION['user']['type_utilisateur']) && $_SESSION['user']['type_utilisateur'] === 1;
            
            if(!$is_admin) {
                // Vérifier si le prêt appartient à l'utilisateur
                $pret_info = $this->pret->getPretById($_POST['id_pret']);
                if(!$pret_info || $pret_info['id_utilisateur'] != $_SESSION['user']['id_utilisateur']) {
                    throw new Exception("Vous n'avez pas les droits pour retourner ce livre");
                }
            }

            // Retourner le livre
            $result = $this->pret->retournerLivre($_POST['id_pret']);
            
            if($result) {
                header('Location: ../index.php?page=admin&success=retour');
                exit();
            } else {
                throw new Exception("Erreur lors du retour du livre");
            }
        } catch (Exception $e) {
            header('Location: ../index.php?page=admin&error=' . urlencode($e->getMessage()));
            exit();
        }
    }

    /**
     * Récupérer les prêts d'un utilisateur
     */
    public function getPretsByUser($id_utilisateur = null) {
        try {
            if($id_utilisateur === null && isset($_SESSION['user'])) {
                $id_utilisateur = $_SESSION['user']['id_utilisateur'];
            }
            
            if($id_utilisateur === null) {
                throw new Exception("Utilisateur non spécifié");
            }

            return $this->pret->getPretsByUser($id_utilisateur);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>