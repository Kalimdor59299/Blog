<?php
/**
 * Fichier de la page création de session informatique
 * */
/* Bibliothèques */
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.conf.php';
include_once 'include/header.inc.php';
//print_r2($_SESSION);

/* @var $bdd PDO */
if (isset($_POST['submit'])) {
    /**
     * Si la valeur submit a été postée alors on suit ces
     * instructions.
     */
    /* On récupère les champs envoyés */
    print_r2($_POST);

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $hashed_mdp = sha1($mdp);

    /* On définit la couleur de la notification en rouge par défaut */
    $_SESSION['notification_color'] = FALSE;

    /* Vérifie si les champs user et pass sont vides */
    if (!empty($nom) || !empty($prenom) || !empty($email) || !empty($mdp)) {
        
    }

    $sth = $bdd->prepare("INSERT INTO utilisateur " #Prépare une requête SQL
            . "(nom, prenom, email, mdp) "
            . "VALUES (:nom, :prenom, :email, :mdp)");
    $sth->bindValue(':nom', $nom, PDO::PARAM_STR);                          /* Associe une valeur à un nom correspondant 
      ou à un point d'interrogation (comme paramètre fictif)
      dans la requête SQL qui a été utilisé pour préparer la requête. */
    $sth->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $sth->bindValue(':email', $email, PDO::PARAM_STR);
    $sth->bindValue(':mdp', $hashed_mdp, PDO::PARAM_STR);

    $sth->execute(); #Exécute une requête préparée.
    //déclaration de variable de session
    $message = 'Utilisateur créé'; #Message de confirmation
    $result = 'success'; #Savoir si la requête a été réalisée ou non

    declareNotification($message, $result);

    #header("Location: index.php"); //redirection, elle doit mettre en dernier car le script ne s'arrête pas même après cette ligne, on applique la redirection que lorsque le script fonctionne réellement
    exit(); //permet de stopper le script
}
?>










<!-- Page Content -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <br>
            <p class="lead">Création de session</p>
            <!-- On récupère une notification s'il elle n'est pas vide -->

            <?php
            if (isset($_SESSION['notification'])) {
                $notification_result = $_SESSION['notification_color'] == TRUE ? 'alert-success' : 'alert-danger';
                ?>
                <div class="alert <?= $notification_result; ?> alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?= $_SESSION['notification']; ?>
                </div>
                <?php
                unset($_SESSION['notification']);
                unset($_SESSION['notification_color']);
            }
            ?>

            <!-- Formulaire -->
            <form action="adduser.php" method="post" enctype="multipart/form-data" id="form-connexion">

                <!-- Champs session à créer -->
                <h5>Création de l'utilisateur</h5>
                <!-- Champs nom à informer -->
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input  type="text" class="form-control" name="nom" id="nom" placeholder="Nom" value="" required>
                </div>
                <!-- Champs prenom à informer -->
                <div class="form-group">
                    <label for="prenom">Prenom :</label>
                    <input  type="text" class="form-control" name="prenom" id="prenom" placeholder="Prenom" value="" required>
                </div>
                <!-- Champ mail -->
                <div class="form-group">
                    <label for="email">e-mail :</label>
                    <input  type="email" class="form-control" name="email" id="email" placeholder="Email" value="" required>
                </div>
                <!-- Mot de passe -->
                <div class="form-group">
                    <label for="Mot de passe">Mot de passe : </label>
                    <input  type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" minlength="8" required>
                </div>

                <!-- Boutton créer -->
                <button type="submit" name="submit" class="btn btn-outline-danger btn-lg btn-block">Créer</button><br>
            </form>

            <br>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>