<?php
session_start();

include 'view/commun/header.php';

//system de routing

$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

switch ($page) {
	case 'connexion':
        include('view/connexion.php');
		break;

    case 'catalogue':
        include('view/catalogue.php');
        break;

    case 'profil':
        include('view/profil.php');    
        break;

    case 'admin':
        include('view/admin.php');
        break;
        
    case 'deconnexion':
        session_destroy();
        header('Location: /libreria/index.php?page=accueil');
        break;

	default:
		include('view/accueil.php');
		break;
}

include 'view/commun/footer.php';

?>