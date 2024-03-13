<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/php/inscription_eleve.php');
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
          $note = mysqli_real_escape_string($connect, $_POST['note']);  
          // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
          if (empty($eleve) or empty($seance)){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Certains éléments sont manquants </p>";
          }
          else{
            if(!empty($note) and ($note<0 or $note>40)){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>La note doit être comprise entre 0 et 40 </p>";
            }
            else{
                $query = "SELECT EffMax from seances where idseance=$seance";
                // récupération de l'effectif max
                $result = mysqli_query($connect, $query);
                if (!$result){
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                  exit;
                }
                $eff = mysqli_fetch_array($result, MYSQLI_NUM);
                $query = "SELECT * from inscription where idseance=$seance";
                // récupération des inscriptions pour une même séance
                $result = mysqli_query($connect, $query);
                if (!$result){
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                  exit;
                }
                $nombre_eleve = mysqli_num_rows($result);
                if (($nombre_eleve+1) > $eff[0]){
                  // on compare le nombre de personnes inscrites à la séance avec l'effectif maximal pour vérifier qu'elle n'est pas pleine
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>La séance est pleine</p>";
                }
                else{
                  $query = 'select * from inscription where ideleve="'.$eleve.'" and idseance="'.$seance.'"';
                  $result = mysqli_query($connect, $query);
                  if (!$result){
                      echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                      echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                    }
                  elseif(mysqli_num_rows($result)!=0){
                    // vérification qu'il n'y a pas d'autres élèves inscrits à la séance
                      echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                      echo "<p>Cette élève a déjà été inscrit pour ce cours si vous souhaitez lui attribuer une note, <a href='validation_seance.php'>cliquez ici</a> </p>";
                  }
                  else{
                      if (empty($note)){
                          $query = "insert into inscription values ('$seance', '$eleve', null)";
                          //ajoute une nouvelle ligne
                      }
                      else{
                          $query = "insert into inscription values ('$seance', '$eleve', '$note')";
                      }
                      $result = mysqli_query($connect, $query);
                      if (!$result){
                      echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                      echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                      }
                      else{
                      echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
                      echo "<p>L'inscription a bien été effectuée</p>";
                      }
                  }
                }
            }     
          }
          mysqli_close($connect);
          echo "<p>Vous allez être redirigé dans quelques secondes</p>";
        ?>
        <a href="../php/inscription_eleve.php">Retour</a>
      </div>
    </section>
  </body>
</html>
