<?php
require_once('controller/pretController.php');

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['user'])) {
    header('Location: index.php?page=connexion');
    exit();
}

$pretController = new PretController($bdd);
$emprunts = $pretController->getPretsByUser($_SESSION['user']['id_utilisateur']);

// Messages de succès/erreur
$error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
$success = isset($_GET['success']) ? $_GET['success'] : '';
?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Mes Emprunts</h2>
            <p class="mt-2 text-gray-600">Gérez vos emprunts en cours</p>
        </div>

        <?php if($error_message): ?>
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if($success === 'retour'): ?>
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                Le livre a été retourné avec succès !
            </div>
        <?php endif; ?>

        <?php if(empty($emprunts)): ?>
            <div class="bg-white rounded-lg shadow-sm p-6 text-center text-gray-500">
                Vous n'avez aucun emprunt en cours.
                <a href="index.php?page=catalogue" class="text-blue-600 hover:text-blue-800 ml-2">
                    Parcourir le catalogue
                </a>
            </div>
        <?php else: ?>
            <div class="bg-white shadow-sm rounded-lg divide-y divide-gray-200">
                <?php foreach($emprunts as $emprunt): ?>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-900">
                                    <?php echo htmlspecialchars($emprunt['titre']); ?>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Par <?php echo htmlspecialchars($emprunt['auteur']); ?>
                                </p>
                                <div class="mt-2 text-sm text-gray-500">
                                    <p>Emprunté le : <?php echo date('d/m/Y', strtotime($emprunt['date_emprunt'])); ?></p>
                                    <?php
                                    $date_emprunt = new DateTime($emprunt['date_emprunt']);
                                    $date_retour = $date_emprunt->add(new DateInterval('P14D'));
                                    $aujourd_hui = new DateTime();
                                    $jours_restants = $aujourd_hui->diff($date_retour)->days;
                                    $est_en_retard = $aujourd_hui > $date_retour;
                                    ?>
                                    <p class="mt-1">
                                        À retourner avant le : 
                                        <span class="<?php echo $est_en_retard ? 'text-red-600 font-semibold' : 'text-gray-700'; ?>">
                                            <?php echo $date_retour->format('d/m/Y'); ?>
                                        </span>
                                    </p>
                                    <?php if($est_en_retard): ?>
                                        <p class="mt-1 text-red-600">
                                            En retard de <?php echo abs($jours_restants); ?> jour<?php echo abs($jours_restants) > 1 ? 's' : ''; ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="mt-1 text-gray-600">
                                            Il vous reste <?php echo $jours_restants; ?> jour<?php echo $jours_restants > 1 ? 's' : ''; ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>