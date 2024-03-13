<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/html/ajout_eleve.html');
?>
<!-- permet de renvoyer vers le lien ci-dessus au bout de 5secondes -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="ajout_eleve">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a019';
            $dbpass = 'rO3CseyW';
            $dbname = 'nf92a019';
            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
            mysqli_set_charset($connect, 'utf8');
            if (mysqli_real_escape_string($connect,$_POST["result"])=="oui"){
              $nom = mysqli_real_escape_string($connect,$_POST['nom']);
              $prenom = mysqli_real_escape_string($connect,$_POST['prenom']);
              $dateIns = mysqli_real_escape_string($connect,$_POST['dateIns']);
              $date = mysqli_real_escape_string($connect, $_POST['date']);  
              // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
              $query = "insert into eleves values (null, '$nom', '$prenom', '$date', '$dateIns')";
              //ajoute une nouvelle ligne à la table
              $result = mysqli_query($connect, $query);
              if (!$result){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
              }
              else{
                echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
                echo "<p>L'élève a bien été ajouté</p>";
              }

            }
            else{
              echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
              echo "<p>L'enregistrement a été abandonné</p>";
            }
            mysqli_close($connect);
            echo "<p>Vous allez être redirigé dans quelques secondes</p>";

        ?>
        <a href="../html/ajout_eleve.html">Retour</a>
      </div>
    </section>
  </body>
</html>
