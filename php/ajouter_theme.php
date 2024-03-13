<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/html/ajout_theme.html');
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
            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
            mysqli_set_charset($connect, 'utf8');
            $nom = mysqli_real_escape_string($connect, $_POST['nom']);
            $desc = mysqli_real_escape_string($connect, $_POST['descriptif']);
            // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
            if (!empty($nom)){
              $query = 'select * from themes where nom="'.$nom.'"';
              // sélectionne tous les thèmes qui ont le même nom pour vérifier qu'il n'y a pas de doublons
              $result = mysqli_query($connect, $query);
              if (!$result)
              {
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                exit;
              }
              $compteur = mysqli_num_rows($result);
              $supprime = mysqli_fetch_row($result)[2];
              if ($compteur==0){
                $query = 'insert into themes values (null, "'.$nom.'","0", "'.$desc.'")';
                $result = mysqli_query($connect, $query);
                if (!$result)
                {
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                }
                else{
                  echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
                  echo "<p>Le thème a bien été ajouté</p>";
                }
              }
              elseif($supprime == "1") {
                // si le thème est supprimé on le réactive avec la requete update
                $query = 'update themes set supprime= "0" where nom="'.$nom.'"';
                $result = mysqli_query($connect, $query);
                if (!$result)
                {
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                  }
                else{
                  echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
                  echo "<p>Le thème a bien été ajouté</p>";
                }
              }
              else {
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Le thème que vous avez essayer d'enregistrer existe déjà</p>";
              }

            }
            else {
              echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
              echo "<p>Veuillez entrer un nom</p>";
            }
            echo "<p>Vous allez être redirigé dans quelques secondes</p>";
            mysqli_close($connect);
        ?>
        <a href="../html/ajout_theme.html">Retour</a>
      </div>
    </section>
  </body>
</html>
