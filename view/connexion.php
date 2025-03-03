<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Formulaire de Connexion -->
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Connexion</h2>
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                <form action="controller/utilisateurController.php" method="POST">
                    <input type="hidden" name="action" value="login">
                    
                    <div class="mb-4">
                        <label for="adresse" class="block text-gray-700 text-sm font-bold mb-2">Adresse email</label>
                        <input type="email" name="adresse" id="adresse" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="mdp" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                        <input type="password" name="mdp" id="mdp" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Se connecter
                    </button>
                </form>
            </div>

            <!-- Formulaire d'Inscription -->
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Inscription</h2>
                <form action="controller/utilisateurController.php" method="POST">
                    <input type="hidden" name="action" value="inscription">
                    
                    <div class="mb-4">
                        <label for="nom" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                        <input type="text" name="nom" id="nom" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="prénom" class="block text-gray-700 text-sm font-bold mb-2">Prénom</label>
                        <input type="text" name="prénom" id="prénom" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="adresse_email" class="block text-gray-700 text-sm font-bold mb-2">Adresse email</label>
                        <input type="email" name="adresse" id="adresse_email" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="téléphone" class="block text-gray-700 text-sm font-bold mb-2">Téléphone</label>
                        <input type="tel" name="téléphone" id="téléphone" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <div class="mb-6">
                        <label for="mdp_inscription" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                        <input type="password" name="mdp" id="mdp_inscription" 
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                    </div>

                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        S'inscrire
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
