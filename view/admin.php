<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['type_utilisateur'] != 1) {
    header('Location: index.php?page=accueil');
    exit();
}
?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow rounded-lg">
            <!-- En-tête -->
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Administration</h2>
                <p class="mt-1 text-sm text-gray-500">Gérez les livres et les prêts de la bibliothèque</p>
            </div>

            <!-- Onglets -->
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button onclick="showTab('ajout-livre')" 
                            class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                        Ajouter un livre
                    </button>
                    <button onclick="showTab('voir-prets')" 
                            class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Voir les prêts
                    </button>
                </nav>
            </div>

            <!-- Contenu des onglets -->
            <div class="p-6">
                <!-- Messages de feedback -->
                <?php if(isset($_GET['success'])): ?>
                    <?php if($_GET['success'] == 'success'): ?>
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            Livre ajouté avec succès.
                        </div>
                    <?php elseif($_GET['success'] == 'error'): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            Erreur lors de l'ajout du livre.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Onglet Ajout de livre -->
                <div id="ajout-livre" class="tab-content">
                    <form action="controller/livreController.php" method="POST" class="space-y-6">
                        <input type="hidden" name="action" value="ajouter">
                        
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Titre -->
                            <div>
                                <label for="titre" class="block text-sm font-medium text-gray-700">Titre du livre</label>
                                <input type="text" name="titre" id="titre" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Auteur -->
                            <div>
                                <label for="auteur" class="block text-sm font-medium text-gray-700">Auteur</label>
                                <input type="text" name="auteur" id="auteur" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Année -->
                            <div>
                                <label for="annee" class="block text-sm font-medium text-gray-700">Année de publication</label>
                                <input type="number" name="annee" id="annee" required
                                       min="0" max="<?php echo date('Y'); ?>"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Catégorie -->
                            <div>
                                <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                                <input type="text" name="categorie" id="categorie" required
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Ajouter le livre
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Onglet Voir les prêts -->
                <div id="voir-prets" class="tab-content hidden">
                    <p class="text-gray-500 text-center py-4">
                        La gestion des prêts sera disponible prochainement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabId) {
    // Cacher tous les contenus d'onglets
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Afficher le contenu de l'onglet sélectionné
    document.getElementById(tabId).classList.remove('hidden');
    
    // Mettre à jour les styles des boutons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mettre en évidence le bouton de l'onglet actif
    const activeButton = document.querySelector(`button[onclick="showTab('${tabId}')"]`);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}
</script>