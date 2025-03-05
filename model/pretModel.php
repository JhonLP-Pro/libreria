<?php
class Pret {
    private $bdd;

    public function __construct($bdd) {
        $this->bdd = $bdd;
    }

    /**
     * Vérifie si un utilisateur peut emprunter des livres
     */
    public function peutEmprunter($id_utilisateur) {
        try {
            // Vérifier le nombre de prêts en cours
            $req = $this->bdd->prepare('SELECT COUNT(*) as nb_prets FROM Prêt WHERE id_utilisateur = ? AND état = "en cours"');
            $req->execute([$id_utilisateur]);
            $result = $req->fetch();

            if($result['nb_prets'] >= 3) {
                return false;
            }

            // Vérifier s'il y a des retards
            $req = $this->bdd->prepare('
                SELECT COUNT(*) as nb_retards 
                FROM Prêt 
                WHERE id_utilisateur = ? 
                AND état = "en cours" 
                AND DATEDIFF(NOW(), date_emprunt) > 14
            ');
            $req->execute([$id_utilisateur]);
            $result = $req->fetch();

            return $result['nb_retards'] == 0;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Crée un nouveau prêt
     */
    public function creerPret($id_utilisateur, $id_livre) {
        try {
            // Vérifier si le livre est déjà emprunté
            $req = $this->bdd->prepare('SELECT id_prêt FROM Prêt WHERE id_livre = ? AND état = "en cours"');
            $req->execute([$id_livre]);
            if($req->fetch()) {
                throw new Exception("Ce livre est déjà emprunté");
            }

            // Créer le prêt
            $req = $this->bdd->prepare('INSERT INTO Prêt (id_utilisateur, id_livre, date_emprunt, état) VALUES (?, ?, NOW(), "en cours")');
            return $req->execute([$id_utilisateur, $id_livre]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Retourne un livre
     */
    public function retournerLivre($id_pret) {
        try {
            $req = $this->bdd->prepare('UPDATE Prêt SET date_retour = CURRENT_DATE(), état = "retourné" WHERE id_prêt = ?');
            return $req->execute([$id_pret]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors du retour du livre : " . $e->getMessage());
        }
    }

    /**
     * Récupère les informations d'un prêt
     */
    public function getPretById($id_pret) {
        try {
            $req = $this->bdd->prepare('SELECT * FROM Prêt WHERE id_prêt = ?');
            $req->execute([$id_pret]);
            return $req->fetch();
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Récupère les prêts d'un utilisateur
     */
    public function getPretsByUser($id_utilisateur) {
        try {
            $req = $this->bdd->prepare('
                SELECT p.*, l.titre, l.auteur, u.nom, u.prénom as prenom
                FROM Prêt p
                JOIN Livre l ON p.id_livre = l.id_livre
                JOIN Utilisateur u ON p.id_utilisateur = u.id_utilisateur
                WHERE p.id_utilisateur = ? AND p.état = "en cours"
                ORDER BY p.date_emprunt DESC
            ');
            $req->execute([$id_utilisateur]);
            return $req->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Récupère les prêts selon leur statut
     */
    public function getPretsByStatus($status = 'en cours') {
        try {
            $req = $this->bdd->prepare('
                SELECT p.*, l.titre, l.auteur, u.nom, u.prénom as prenom,
                       DATEDIFF(NOW(), p.date_emprunt) > 14 as est_en_retard,
                       DATE_ADD(p.date_emprunt, INTERVAL 14 DAY) as date_limite
                FROM Prêt p
                JOIN Livre l ON p.id_livre = l.id_livre
                JOIN Utilisateur u ON p.id_utilisateur = u.id_utilisateur
                WHERE p.état = ?
                ORDER BY p.date_emprunt DESC
            ');
            $req->execute([$status]);
            return $req->fetchAll();
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Récupère tous les prêts en cours
     */
    public function getPretEnCours() {
        try {
            $req = $this->bdd->prepare('
                SELECT p.*, l.titre, l.auteur, u.nom, u.prénom 
                FROM Prêt p
                JOIN Livre l ON p.id_livre = l.id_livre
                JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur
                WHERE p.état = "en cours"
                ORDER BY p.date_emprunt DESC
            ');
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des prêts en cours : " . $e->getMessage());
        }
    }

    /**
     * Récupère l'historique des prêts
     */
    public function getHistoriquePrets($limit = 50) {
        try {
            $req = $this->bdd->prepare('
                SELECT p.*, l.titre, l.auteur, u.nom, u.prénom 
                FROM Prêt p
                JOIN Livre l ON p.id_livre = l.id_livre
                JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur
                ORDER BY p.date_emprunt DESC
                LIMIT ?
            ');
            $req->execute([$limit]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'historique des prêts : " . $e->getMessage());
        }
    }

    /**
     * Récupère les prêts d'un utilisateur
     */
    public function getPretsByUserOld($id_utilisateur) {
        try {
            $req = $this->bdd->prepare('
                SELECT p.*, l.titre, l.auteur
                FROM Prêt p
                JOIN Livre l ON p.id_livre = l.id_livre
                WHERE p.id_utilisateur = ?
                ORDER BY p.date_emprunt DESC
            ');
            $req->execute([$id_utilisateur]);
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des prêts de l'utilisateur : " . $e->getMessage());
        }
    }

    /**
     * Récupère les prêts en retard
     */
    public function getPretEnRetard() {
        try {
            $req = $this->bdd->prepare('
                SELECT p.*, l.titre, l.auteur, u.nom, u.prénom 
                FROM Prêt p
                JOIN Livre l ON p.id_livre = l.id_livre
                JOIN utilisateur u ON p.id_utilisateur = u.id_utilisateur
                WHERE p.état = "en cours" 
                AND DATEDIFF(NOW(), p.date_emprunt) > 14
                ORDER BY p.date_emprunt ASC
            ');
            $req->execute();
            return $req->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des prêts en retard : " . $e->getMessage());
        }
    }

    /**
     * Vérifie si un utilisateur a des prêts en retard
     */
    public function hasPretsEnRetard($id_utilisateur) {
        try {
            $req = $this->bdd->prepare('
                SELECT COUNT(*) as nb_retard
                FROM Prêt
                WHERE id_utilisateur = ?
                AND état = "en cours"
                AND DATEDIFF(NOW(), date_emprunt) > 14
            ');
            $req->execute([$id_utilisateur]);
            $result = $req->fetch(PDO::FETCH_ASSOC);
            return $result['nb_retard'] > 0;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la vérification des retards : " . $e->getMessage());
        }
    }
}
?>