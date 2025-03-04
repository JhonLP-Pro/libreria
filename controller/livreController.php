<?php
require_once(__DIR__ . '/../model/livreModel.php');
require_once(__DIR__ . '/../bdd/bdd.php');

if(isset($_POST['action'])) {
    $livreController = new LivreController($bdd);

    switch($_POST['action']) {
        case 'ajouter':
            $livreController->ajouterLivre();
            break;
        case 'modifier':
            $livreController->modifierLivre();
            break;
        case 'supprimer':
            $livreController->supprimerLivre();
            break;
        case 'rechercher':
            $livreController->rechercherLivres();
            break;
        default:
            header('Location: /libreria/index.php?page=catalogue');
            exit();
    }
}

class LivreController {
    private $livre;

    public function __construct($bdd) {
        $this->livre = new Livre($bdd);
    }

    public function ajouterLivre() {
        try {
            if(empty($_POST['titre']) || empty($_POST['auteur']) || empty($_POST['annee']) || empty($_POST['categorie'])) {
                header('Location: /libreria/index.php?page=admin&success=error');
                exit();
            }

            if(!is_numeric($_POST['annee']) || $_POST['annee'] < 0 || $_POST['annee'] > date('Y')) {
                header('Location: /libreria/index.php?page=admin&success=error');
                exit();
            }

            $result = $this->livre->ajouterLivre(
                $_POST['titre'],
                $_POST['auteur'],
                $_POST['annee'],
                $_POST['categorie']
            );

            if($result) {
                header('Location: /libreria/index.php?page=admin&success=success');
            } else {
                header('Location: /libreria/index.php?page=admin&success=error');
            }
        } catch (Exception $e) {
            header('Location: /libreria/index.php?page=admin&success=error');
        }
        exit();
    }

    public function modifierLivre() {
        try {
            if(empty($_POST['id_livre'])) {
                header('Location: /libreria/index.php?page=admin&success=error');
                exit();
            }

            if(empty($_POST['titre']) || empty($_POST['auteur']) || empty($_POST['annee']) || empty($_POST['categorie'])) {
                header('Location: /libreria/index.php?page=admin&success=error');
                exit();
            }

            if(!is_numeric($_POST['annee']) || $_POST['annee'] < 0 || $_POST['annee'] > date('Y')) {
                header('Location: /libreria/index.php?page=admin&success=error');
                exit();
            }

            $result = $this->livre->modifierLivre(
                $_POST['id_livre'],
                $_POST['titre'],
                $_POST['auteur'],
                $_POST['annee'],
                $_POST['categorie']
            );

            header('Location: /libreria/index.php?page=admin&success=' . ($result ? 'success' : 'error'));
        } catch (Exception $e) {
            header('Location: /libreria/index.php?page=admin&success=error');
        }
        exit();
    }

    public function supprimerLivre() {
        try {
            if(empty($_POST['id_livre'])) {
                header('Location: /libreria/index.php?page=admin&success=error');
                exit();
            }

            $result = $this->livre->supprimerLivre($_POST['id_livre']);
            header('Location: /libreria/index.php?page=admin&success=' . ($result ? 'success' : 'error'));
        } catch (Exception $e) {
            header('Location: /libreria/index.php?page=admin&success=error');
        }
        exit();
    }

    public function rechercherLivres() {
        try {
            $terme = isset($_POST['terme']) ? $_POST['terme'] : '';
            $livres = empty($terme) ? $this->livre->getAllLivres() : $this->livre->rechercherLivres($terme);
            header('Location: /libreria/index.php?page=catalogue&q=' . urlencode($terme));
            exit();
        } catch (Exception $e) {
            header('Location: /libreria/index.php?page=catalogue&error=1');
            exit();
        }
    }

    public function getLivresRecents() {
        try {
            return $this->livre->getAllLivres();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getCatalogueData() {
        $terme = isset($_GET['q']) ? $_GET['q'] : '';
        try {
            return empty($terme) ? $this->livre->getAllLivres() : $this->livre->rechercherLivres($terme);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>