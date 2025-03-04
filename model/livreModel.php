<?php

class Livre {
    private $bdd;
    
    function __construct($bdd)
    {
        $this->bdd = $bdd;   
    }

    public function ajouterLivre($titre, $auteur, $annee, $categorie)
    {
        try {
            $req = $this->bdd->prepare('INSERT INTO Livre(titre, auteur, année, catégorie) 
                                      VALUES(:titre, :auteur, :annee, :categorie)');
            $req->bindParam(':titre', $titre);
            $req->bindParam(':auteur', $auteur);
            $req->bindParam(':annee', $annee);
            $req->bindParam(':categorie', $categorie);
            return $req->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du livre : " . $e->getMessage());
            return false;
        }
    }

    public function getLivreById($id)
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM Livre WHERE id_livre = :id');
            $req->bindParam(':id', $id);
            $req->execute();
            return $req->fetch();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération du livre : " . $e->getMessage());
            return false;
        }
    }

    public function getAllLivres()
    {
        try {
            $req = $this->bdd->prepare('SELECT * FROM Livre ORDER BY titre');
            $req->execute();
            return $req->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des livres : " . $e->getMessage());
            return false;
        }
    }

    public function modifierLivre($id, $titre, $auteur, $annee, $categorie)
    {
        try {
            $req = $this->bdd->prepare('UPDATE Livre 
                                      SET titre = :titre, 
                                          auteur = :auteur, 
                                          année = :annee, 
                                          catégorie = :categorie 
                                      WHERE id_livre = :id');
            $req->bindParam(':id', $id);
            $req->bindParam(':titre', $titre);
            $req->bindParam(':auteur', $auteur);
            $req->bindParam(':annee', $annee);
            $req->bindParam(':categorie', $categorie);
            return $req->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification du livre : " . $e->getMessage());
            return false;
        }
    }

    public function supprimerLivre($id)
    {
        try {
            // Vérifier d'abord s'il y a des prêts en cours pour ce livre
            $req = $this->bdd->prepare('SELECT COUNT(*) FROM Prêt WHERE id_livre = :id AND date_retour IS NULL');
            $req->bindParam(':id', $id);
            $req->execute();
            if ($req->fetchColumn() > 0) {
                return false; // Le livre est actuellement emprunté
            }

            // Si pas de prêts en cours, on peut supprimer
            $req = $this->bdd->prepare('DELETE FROM Livre WHERE id_livre = :id');
            $req->bindParam(':id', $id);
            return $req->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du livre : " . $e->getMessage());
            return false;
        }
    }

    public function rechercherLivres($terme)
    {
        try {
            $terme = "%$terme%";
            $req = $this->bdd->prepare('SELECT * FROM Livre 
                                      WHERE titre LIKE :terme 
                                      OR auteur LIKE :terme 
                                      OR catégorie LIKE :terme 
                                      ORDER BY titre');
            $req->bindParam(':terme', $terme);
            $req->execute();
            return $req->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche de livres : " . $e->getMessage());
            return false;
        }
    }

    public function getLivresDisponibles()
    {
        try {
            $req = $this->bdd->prepare('SELECT Livre.* FROM Livre 
                                      LEFT JOIN Prêt ON Livre.id_livre = Prêt.id_livre 
                                      AND Prêt.date_retour IS NULL 
                                      WHERE Prêt.id_livre IS NULL 
                                      ORDER BY Livre.titre');
            $req->execute();
            return $req->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des livres disponibles : " . $e->getMessage());
            return false;
        }
    }
}
?>