<?php
require_once 'config/init.conf.php';
require_once 'include/fonctions.inc.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.conf.php';
include_once 'include/header.inc.php';
//print_r2($_SESSION);
/* @var $bdd PDO */

//Tableau vide
$array = array("id" => "", "titre" => "", "texte" => "", "date" => "", "publie" => "");


//On récupère les valeurs de la table article pour les modifier
if (!empty($_GET['action']) AND $_GET['action'] == "modifier") {
    $modifierid = $_GET['id'];
    $sth = $bdd->prepare("SELECT id, "
            . "titre, "
            . "texte, "
            . "date, "
            . "publie "
            . "FROM table1 "
            . "WHERE id = :id ");
    $sth->bindValue(":id", $modifierid, PDO::PARAM_INT);
    $sth->execute();
//on push les valeurs dans le tableau
    $array = $sth->fetch(PDO::FETCH_ASSOC);
    
    //print_r2($array);
}

/*  MODIF DE L'ARTICLE  */


if (!empty($_POST['submit']) AND $_POST['submit'] == 'modifier') {
    $sth = $bdd->prepare("UPDATE table1 "
            . "SET titre = :titre, texte = :texte, publie = :publie "
            . "WHERE id = :id");
    $sth->bindValue(":titre", $_POST['titre'], PDO::PARAM_STR);
    $sth->bindValue(":texte", $_POST['texte'], PDO::PARAM_STR);
    $sth->bindValue(":publie", $_POST['publie'], PDO::PARAM_BOOL);
    $sth->bindValue(":id", $_POST['id'], PDO::PARAM_INT);
    $sth->execute();

    //déclaration de variable de session
    $message = 'Votre article a été modifié.'; #Message de confirmation
    $result = 'success'; #Savoir si la requête a été réalisée ou non

    declareNotification($message, $result);

    header("Location: index.php"); //redirection, elle doit mettre en dernier car le script ne s'arrête pas même après cette ligne, on applique la redirection que lorsque le script fonctionne réellement
    exit(); //permet de stopper le script
}

/*  MODIF DE L'ARTICLE  */



if (!empty($_POST['submit']) AND $_POST['submit'] == 'ajouter') {
    print_r2($_POST);
    print_r2($_FILES);

    $titre = $_POST['titre'];
    $texte = $_POST['texte'];

    $publie = isset($_POST['publie']) ? 1 : 0; #Cette commande est une version simplifiée de la suivante

    /* if (isset($_POST['publie'])) {
      $publie = 1;
      } else {
      $publie = 0;
      } */

    $date = date('Y-m-d');

    $sth = $bdd->prepare("INSERT INTO table1 " #Prépare une requête SQL
            . "(titre, texte, publie, date) "
            . "VALUES (:titre, :texte, :publie, :date)");
    $sth->bindValue(':titre', $titre, PDO::PARAM_STR);                          /* Associe une valeur à un nom correspondant 
      ou à un point d'interrogation (comme paramètre fictif)
      dans la requête SQL qui a été utilisé pour préparer la requête. */
    $sth->bindValue(':texte', $texte, PDO::PARAM_STR);
    $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
    $sth->bindValue(':date', $date, PDO::PARAM_STR);

    $sth->execute(); #Exécute une requête préparée.

    $id_article = $bdd->lastInsertId();

    if ($_FILES['img']['error'] == 0) {
        move_uploaded_file($_FILES['img']['tmp_name'], 'img/' . $id_article . '.jpg'); #Récupère l'image où elle est située et la place dans le répertoire img/ et seulement du jpg
    }

    //déclaration de variable de session
    $message = 'Votre article a été ajouté.'; #Message de confirmation
    $result = 'success'; #Savoir si la requête a été réalisée ou non

    declareNotification($message, $result);

    header("Location: index.php"); //redirection, elle doit mettre en dernier car le script ne s'arrête pas même après cette ligne, on applique la redirection que lorsque le script fonctionne réellement
    exit(); //permet de stopper le script
}
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">

            <h1 class="mt-5">Ajouter un article</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form method="POST" action="articles.php" enctype="multipart/form-data" >
                <input id="id" name="id" type="hidden" value="<?php echo $array['id'] ?>">
                <div class="form-group">
                    <label for="titre">Titre de votre article</label>
                    <input type="text" class="form-control" id="titre" placeholder="Titre" name='titre' value="<?php echo $array['titre'] ?>"> 
                </div>
                <div class="form-group">
                    <label for="texte">Contenu de l'article</label>
                    <textarea class="form-control" id="texte" rows="3" name='texte'> <?php echo $array['texte'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="img">Image de l'article</label>
                    <input type="file" class="form-control-file" id="img" name='img'>
                </div>
          <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="publie" name="publie" <?php if ($array['publie'] == '1') { ?>checked<?php }; ?>>
                           <label class="form-check-label" for="publie">Publié</label>
                </div>
                
                
                
                <?php if ($_GET['action'] == "modifier") { ?>

                    <button type = "submit" class = "btn btn-primary" name = "submit" value = "modifier" >Modifier</button>
                <?php } else {
                    ?>
                    <button type = "submit" class = "btn btn-primary" name = "submit" value = "ajouter" >Ajouter</button>
                    <?php
                }
                ?>   


            </form>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.slim.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>