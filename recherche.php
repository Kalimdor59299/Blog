<?php
	require_once 'config/init.conf.php';
	require_once 'include/fonctions.inc.php';
	require_once 'config/bdd.conf.php';
	require_once 'config/connexion.conf.php';
	include_once 'include/header.inc.php';
	require_once('libs/Smarty.class.php');

	$page_courante = !empty($_GET['p']) ? $_GET['p'] : 0;

	$nb_total_articles = countArticle($bdd);

	$index_depart = returnIndex($page_courante, _nb_articles_par_page);

	$nb_total_pages = ceil($nb_total_articles / _nb_articles_par_page);

	$tab_result = array();

	if (isset($_GET['recherche'])) {
    	?>
    	<div class="container" ></div>
    	<div class="row"></div>
    	<h3 class =" mt-5"> Résultat de votre recherche:</h3>
    	<?php

    	if ($_GET['recherche'] != ''){
    		$sth = $bdd->prepare("SELECT id, "
        	. "titre, "
        	. "texte, "
        	. "DATE_FORMAT(date, '%d/%m/%Y')AS date_fr, "
        	. "publie "
        	. "FROM table1 "
        	. "WHERE (titre LIKE '%".$_GET['recherche']."%' OR texte LIKE '%".$_GET['recherche']."%') "
    		. "AND publie = 1");
    		$sth->execute();

			$tab_result = $sth->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	else{
		?>
		<div class="container" ></div>
		<div class="row"></div>
		<h3 class =" mt-5">Rechercher:</h3>
		
	<?php
	}

	//smarty
	$smarty = new Smarty();

	$smarty->assign('tab_result', $tab_result);
	$smarty->assign('nb_total_pages', $nb_total_pages);
	$smarty->assign('nb_total_pages', $page_courante);

	if (isset($_GET['recherche'])) {
		if ($_GET['recherche'] != ''){
			$smarty->assign('tab_result', $tab_result);
			$smarty->assign('nb_total_pages', $nb_total_pages);
			$smarty->assign('nb_total_pages', $page_courante);
		}
	}

	include_once 'include/header.inc.php';

	$smarty->display('recherche.tpl');

	unset($_SESSION['notification']);

?>