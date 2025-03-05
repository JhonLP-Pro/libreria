<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['type_utilisateur'] != 1) {
    header('Location: index.php?page=accueil');
    exit();
}

// Inclure les contrôleurs nécessaires
require_once('controller/pretController.php');
$pretController = new PretController($bdd);

// Récupérer les prêts en cours
$emprunts = $pretController->getPretsByStatus('en cours');
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
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Emprunteur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date limite</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach($emprunts as $emprunt): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($emprunt['titre']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($emprunt['nom']) . ' ' . htmlspecialchars($emprunt['prenom']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo date('d/m/Y', strtotime($emprunt['date_emprunt'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo $emprunt['est_en_retard'] ? 'text-red-600 font-semibold' : 'text-gray-900'; ?>">
                                        <?php echo date('d/m/Y', strtotime($emprunt['date_limite'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($emprunt['est_en_retard']): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                En retard
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                En cours
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="controller/pretController.php" method="POST">
                                            <input type="hidden" name="action" value="retourner">
                                            <input type="hidden" name="id_pret" value="<?php echo $emprunt['id_prêt']; ?>">
                                            <button type="submit" 
                                                    class="text-green-600 hover:text-green-900">
                                                Marquer comme retourné
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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