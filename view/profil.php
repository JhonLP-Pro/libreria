<?php
if (!isset($_SESSION['user'])) {
    header('Location: index.php?page=connexion');
    exit();
}
?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg">
            <!-- En-tête du profil -->
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-2xl leading-6 font-semibold text-gray-900">
                    Mon Profil
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Gérez vos informations personnelles
                </p>
            </div>

            <!-- Informations du profil -->
            <div class="px-4 py-5 sm:p-6">
                <form action="controller/utilisateurController.php" method="POST" class="space-y-6">
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Nom -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="nom" id="nom" 
                                   value="<?php echo htmlspecialchars($_SESSION['user']['nom']); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <!-- Prénom -->
                        <div>
                            <label for="prénom" class="block text-sm font-medium text-gray-700">Prénom</label>
                            <input type="text" name="prénom" id="prénom" 
                                   value="<?php echo htmlspecialchars($_SESSION['user']['prénom']); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse email</label>
                            <input type="email" name="adresse" id="adresse" 
                                   value="<?php echo htmlspecialchars($_SESSION['user']['adresse']); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label for="téléphone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" name="téléphone" id="téléphone" 
                                   value="<?php echo htmlspecialchars($_SESSION['user']['téléphone']); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>
                    </div>

                    <!-- Nouveau mot de passe (optionnel) -->
                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Changer le mot de passe</h4>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="ancien_mdp" class="block text-sm font-medium text-gray-700">Ancien mot de passe</label>
                                <input type="password" name="ancien_mdp" id="ancien_mdp" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="nouveau_mdp" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                <input type="password" name="nouveau_mdp" id="nouveau_mdp" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Messages d'erreur ou de succès -->
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end space-x-3">
                        <button type="reset" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Annuler
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section des emprunts en cours -->
            <div class="px-4 py-5 sm:px-6 border-t border-gray-200">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Mes emprunts en cours</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de retour</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">État</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Les emprunts seront affichés ici via PHP -->
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500" colspan="4">
                                    Aucun emprunt en cours
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>