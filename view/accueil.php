
<div class="relative">
    <!-- Image de fond avec overlay -->
    <div class="relative h-[500px]">
        <img src="image/librairie.jpg" alt="Bibliothèque" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Contenu superposé -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Bienvenue à Libreria</h1>
            <p class="text-xl md:text-2xl mb-8 text-center max-w-2xl px-4">
                Découvrez notre collection de livres et profitez de notre service de prêt
            </p>
            <div class="space-x-4">
                <a href="index.php?page=catalogue" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                    Parcourir le catalogue
                </a>
                <?php if(!isset($_SESSION['user'])): ?>
                <a href="index.php?page=connexion" class="bg-white hover:bg-gray-100 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                    Se connecter
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Section Caractéristiques -->
<div class="container mx-auto px-4 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Large Collection</h3>
            <p class="text-gray-600">Des milliers de livres à votre disposition</p>
        </div>
        
        <div class="text-center">
            <div class="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Prêt Facile</h3>
            <p class="text-gray-600">Empruntez rapidement et simplement</p>
        </div>
        
        <div class="text-center">
            <div class="bg-blue-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">Communauté Active</h3>
            <p class="text-gray-600">Rejoignez notre communauté de lecteurs</p>
        </div>
    </div>
</div>

