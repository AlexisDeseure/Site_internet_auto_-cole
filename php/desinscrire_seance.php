<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/php/desinscription_seance.php');
?>
<!-- permet de renvoyer vers le lien ci-dessus au bout de 5secondes -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="inscription">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
        $dbhost = 'tuxa.sme.utc';
        $dbuser = 'nf92a019';
        $dbpass = 'rO3CseyW';
        $dbname = 'nf92a019';
        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
        mysqli_set_charset($connect, 'utf8');
        $eleve = mysqli_real_escape_string($connect, $_POST['eleve']);  
        $seance = mysqli_real_escape_string($connect, $_POST['seance']);
        // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
        $query = "DELETE FROM inscription WHERE idseance = $seance and ideleve = $eleve";
        // supprime l'inscription du couple (idseance, ideleve)
        $result = mysqli_query($connect, $query);
        if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
        }
        else{
            echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
            echo "<p>La désinscription a été effectuée avec succès</p>";
        }
        mysqli_close($connect);
        ?>
        <p>Vous allez être redirigé dans quelques secondes</p>
        <a href="../php/desinscription_seance.php">Retour</a>
      </div>
    </section>
  </body>
</html>
