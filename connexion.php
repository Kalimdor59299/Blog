<?php
/* Bibliothèques */
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.conf.php';
include_once 'include/header.inc.php';

/* var @bdd PDO */




if (isset($_POST['submit'])) {
    /**
     * Si la valeur submit a été postée alors on suit ces
     * instructions.
     */
    /* On récupère le nom et le mdp saisis par l'utilisateur */
    $email = $_POST['email'];
    $mdp = sha1($_POST['mdp']);

    $sth = $bdd->prepare("SELECT * "
            . "FROM utilisateur "
            . "WHERE email = :email AND mdp = :mdp");
    
    $sth->bindValue(':email', $email, PDO::PARAM_STR);
    $sth->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $sth->execute();

    if ($sth->rowCount() > 0) {
        //La connexion est OK
        $donnees = $sth->fetch(PDO::FETCH_ASSOC);
        //print_r2($donnees);
        $sid = $donnees['email'] . time();
        $sid_hache = md5($sid);
        //echo $sid_hache;

        setcookie('sid', $sid_hache, time() + 3600);

        $sth_update = $bdd->prepare("UPDATE utilisateur "
                . "SET sid = :sid "
                . "WHERE id = :id ");

        $sth_update->bindValue(':sid', $sid_hache, PDO::PARAM_STR);
        $sth_update->bindValue(':id', $donnees['id'], PDO::PARAM_INT);

        $result_connexion = $sth_update->execute();
        //var_dump($sth_update);

        /*         * *** NOTIFICATIONS *** */
        if ($result_connexion == TRUE) {
            $_SESSION['notification']['result'] = 'success';
            $_SESSION['notification']['message'] = '<b>Félicitations !</b> Vous êtes connecté';
        } else {
            $_SESSION['notification']['result'] = 'danger';
            $_SESSION['notification']['message'] = '<b>Attention</b> Une erreur est survenue.';
        }

        print_r2($_SESSION);
        //Redirection vers l'accueil
        //header("Location : index.php");
        exit();
    }
}
?>







<!-- Page Content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mt-5"><center>Connexion utilisateur</center></h1>
            <!-- On récupère une notification s'il elle n'est pas vide -->


            <br>
            <!-- Formulaire de connexion -->
            <form action="connexion.php" method="post" enctype="multipart/form-data" id="form-connexion">
                <!-- Champs nom de session -->
                <div class="form-group">
                    <label for="email">email :</label>
                    <input  type="text" class="form-control" name="email" id="email" placeholder="Veuillez saisir votre adresse mail" required>
                </div>
                <!-- Champs mot de passe -->
                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input  type="password" class="form-control" name="mdp" id="mdp" placeholder="Veuillez saisir votre mot de passe" required>
                </div>
                <!-- Bouton se connecter -->
                <div class="row justify-content-center">
                    <button type="submit" name="submit" class="btn btn-secondary btn-lg">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>