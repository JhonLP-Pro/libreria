<?php
require_once('controller/livreController.php');
$livreController = new LivreController($bdd);
$livres = $livreController->getCatalogueData();
$searchTerm = isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '';
?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- En-tête et barre de recherche -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Catalogue</h2>
            <div class="flex items-center">
                <div class="flex-1">
                    <form action="controller/livreController.php" method="POST" class="flex gap-4">
                        <input type="hidden" name="action" value="rechercher">
                        <input type="text" 
                               name="terme"
                               value="<?php echo $searchTerm; ?>"
                               placeholder="Rechercher par titre, auteur ou catégorie..." 
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Rechercher
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                Une erreur est survenue lors de la recherche.
            </div>
        <?php endif; ?>

        <!-- Liste des livres -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <?php if(empty($livres)): ?>
                <div class="col-span-full text-center py-8 text-gray-500">
                    Aucun livre trouvé<?php echo !empty($searchTerm) ? ' pour la recherche "' . $searchTerm . '"' : ''; ?>.
                </div>
            <?php else: ?>
                <?php foreach($livres as $livre): ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-xl font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($livre['titre']); ?></h4>
                        <p class="text-gray-600 mb-2">Par <?php echo htmlspecialchars($livre['auteur']); ?></p>
                        <p class="text-gray-500 mb-4">
                            <span class="mr-4">Année: <?php echo htmlspecialchars($livre['année']); ?></span>
                            <span>Catégorie: <?php echo htmlspecialchars($livre['catégorie']); ?></span>
                        </p>
                        <?php if(isset($_SESSION['user'])): ?>
                            <button onclick="emprunterLivre(<?php echo $livre['id_livre']; ?>)"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Emprunter
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function emprunterLivre(idLivre) {
    // À implémenter plus tard
    alert('La fonctionnalité d\'emprunt sera bientôt disponible !');
}
</script>