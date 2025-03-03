<?php
session_start();

include 'view/commun/header.php';

//system de routing

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
	case 'connexion':
        include('view/connexion.php');
		break;

    case 'profil':
        include('view/profil.php');    
        break;
    
    case 'deconnexion':
        session_destroy();
        header('Location: index.php?page=accueil');
        break;

	default:
		include('view/accueil.php');
		break;
}


include 'view/commun/footer.php';

?>