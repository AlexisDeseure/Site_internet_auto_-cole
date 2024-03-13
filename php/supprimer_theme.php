<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/php/suppression_theme.php');
?>
<!-- permet de renvoyer vers le lien ci-dessus au bout de 5secondes -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="ajouter_theme">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a019';
            $dbpass = 'rO3CseyW';
            $dbname = 'nf92a019';
            date_default_timezone_set('Europe/Paris');
            $dateIns = date("Y-m-d");
            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
            mysqli_set_charset($connect, 'utf8');
            $theme = mysqli_real_escape_string($connect, $_POST['theme']);  
            // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
            $query = "update themes set supprime= '1' where idtheme='$theme'";
            //modifie le themes de sorte à le supprimer
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                mysqli_close($connect);
                exit;
            }
            $query = "DELETE FROM seances WHERE (idtheme = $theme and DateSeance>='$dateIns')";
            // supprime les seances dotée du theme choisi où la date n'est pas passée
            $result = mysqli_query($connect, $query);
            if (!$result)
            {
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                mysqli_close($connect);
                exit;
            }
            echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
            echo "<p>Le thème a bien été supprimé</p>";
            mysqli_close($connect);
            ?>
        <p>Vous allez être redirigé dans quelques secondes</p>
        <a href="../php/suppression_theme.php">Retour</a>
      </div>
    </section>
  </body>
</html>
