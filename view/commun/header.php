
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libreria - Bibliothèque en ligne</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .profile-menu {
            z-index: 50;
            position: absolute;
            right: 0;
            margin-top: 0.5rem;
            width: 12rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md relative">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="index.php?page=accueil" class="text-2xl font-bold text-blue-600">
                        Libreria
                    </a>
                </div>

                <!-- Navigation principale -->
                <div class="hidden md:flex md:items-center md:space-x-8">
                    <a href="index.php?page=accueil" class="text-gray-600 hover:text-blue-600 transition">Accueil</a>
                    <a href="index.php?page=catalogue" class="text-gray-600 hover:text-blue-600 transition">Catalogue</a>
                    <?php if(isset($_SESSION['user'])): ?>
                        <?php if($_SESSION['user']['type_utilisateur'] == 1): ?>
                            <a href="index.php?page=admin" class="text-gray-600 hover:text-blue-600 transition">Administration</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Boutons de connexion/profil -->
                <div class="flex items-center space-x-4">
                    <?php if(isset($_SESSION['user'])): ?>
                        <div class="relative">
                            <button onclick="toggleProfileMenu()" class="flex items-center space-x-1 text-gray-700 hover:text-blue-600">
                                <span><?php echo htmlspecialchars($_SESSION['user']['prénom']); ?></span>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <!-- Menu déroulant -->
                            <div id="profileMenu" class="profile-menu hidden bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="index.php?page=profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Mon profil
                                    </a>
                                    <a href="index.php?page=mes-emprunts" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Mes emprunts
                                    </a>
                                    <hr class="my-1">
                                    <a href="index.php?page=deconnexion" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Déconnexion
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="index.php?page=connexion" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Connexion
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <script>
        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('hidden');
        }

        // Fermer le menu si on clique ailleurs sur la page
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('profileMenu');
            const button = event.target.closest('button');
            const menuContent = event.target.closest('.profile-menu');
            
            if (!button && !menuContent && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });
    </script>

    <main class="container mx-auto px-4 py-8">