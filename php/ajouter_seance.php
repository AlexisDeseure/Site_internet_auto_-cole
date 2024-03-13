<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/php/ajout_seance.php');
?>
<!-- permet de renvoyer vers le lien ci-dessus au bout de 5secondes -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="ajouter_seance">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $theme  = mysqli_real_escape_string($connect, $_POST['theme']);
          $eff = mysqli_real_escape_string($connect, $_POST['eff']);
          $date = mysqli_real_escape_string($connect, $_POST['date']);  
          // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
          date_default_timezone_set('Europe/Paris');
          $dateIns = date("Y-m-d");
          // Vérifications:
          if (empty($theme) or empty($date) or empty($eff)){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Certains éléments sont manquants </p>";
          }
          elseif ($eff<=0){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>L'effectif maximum doit être supérieur ou égal à 1 </p>";
          }
          elseif($date < $dateIns){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>La date de l'inscription ne peut pas être passée</p>";
          }
          else{
            
            $query = 'select * from seances where idtheme="'.$theme.'" and DateSeance="'.$date.'"';
            // permet de la même manière que ajouter_eleve.php de vérifier qu'il n'y a aucune séance prévu à la même date ayant le même thème 
            $result = mysqli_query($connect, $query);
            if (!$result){
              echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
              echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            }
            else{
              if(mysqli_num_rows($result)!=0){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Il y a déjà une séance sur ce thème prévu à cette date</p>";
              }
              else{
                $query = "insert into seances values (null, '$date', '$eff', '$theme')";
                $result = mysqli_query($connect, $query);
                if (!$result){
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                }
                else{
                  echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
                  echo "<p>La séance a bien été enregistrée</p>";
                }
              }
            }
            
          }
            mysqli_close($connect);
            echo "<p>Vous allez être redirigé dans quelques secondes</p>";
        ?>
        <a href="../php/ajout_seance.php">Retour</a>
      </div>
    </section>
  </body>
</html>
