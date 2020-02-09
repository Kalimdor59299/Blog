<?php

        #On inclut les fichiers de configuration
        require_once 'config/init.conf.php';
        require_once 'config/bdd.conf.php';
        require_once 'include/fonctions.inc.php';
        require_once 'config/connexion.conf.php';
        require_once('libs/Smarty.class.php');

        $page_courante = !empty($_GET['p']) ? $_GET['p'] : 1;

        $SELECT_COUNT = "SELECT COUNT(*) AS total FROM table1"; 
        $result = $bdd->query($SELECT_COUNT); 
        $count = $result->fetch(PDO::FETCH_ASSOC); 

        $nb_total_articles = implode($count);

        $index_depart = returnIndex($page_courante, _nb_articles_par_page);

        $nb_total_pages = ceil($nb_total_articles / _nb_articles_par_page);

        #On prépare la base de données dont les données de la table1
        $sth = $bdd->prepare("SELECT id,"
                . "titre,"
                . "texte,"
                . "DATE_FORMAT(date, '%d/%m/%Y')AS date_fr,"
                . "publie "
                . "FROM table1 "
                . "WHERE publie = :publie "
                . "LIMIT :index_depart, :nb_articles_par_page");
        $sth->bindValue(":publie", 1, PDO::PARAM_BOOL);
        $sth->bindValue(":index_depart", $index_depart, PDO::PARAM_INT);
        $sth->bindValue(":nb_articles_par_page", _nb_articles_par_page, PDO::PARAM_INT);
        $sth->execute();
        $tab_result = $sth->fetchAll(PDO::FETCH_ASSOC); /* Pousse les résultats de notre requete SQL */

        $smarty = new Smarty();

        $smarty->setTemplateDir('templates/');
        $smarty->setCompileDir('templates_c/');

        $smarty->assign('tab_result', $tab_result);
        $smarty->assign('nb_total_pages', $nb_total_pages);
        $smarty->assign('nb_total_pages', $page_courante);

        include_once 'include/header.inc.php';
        $smarty->display('index.tpl');

        unset($_SESSION['notification']);
?>