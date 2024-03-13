<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="validation">
    <section id="ajouter_eleve">
      <div class="container">
        <div class="title">
          <h1>
            <?php 
              $dbhost = 'tuxa.sme.utc';
              $dbuser = 'nf92a019';
              $dbpass = 'rO3CseyW';
              $dbname = 'nf92a019';
              $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
              mysqli_set_charset($connect, 'utf8');
              $seance = mysqli_real_escape_string($connect,$_POST['seance']);
              // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
              $result = mysqli_query($connect,"select seances.DateSeance, themes.nom from seances, themes where (idseance=$seance and seances.idtheme=themes.idtheme)");
              //sélectionne la bonne séance avec son nom correspondant
              if (!$result){
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                exit;
              }
              $row = mysqli_fetch_array($result, MYSQLI_NUM);
              echo "Séance : $row[1] du ".substr($row[0],8,2)."/".substr($row[0],5,2)."/".substr($row[0],0,4);
            ?>
          </h1>
        </div>
        <?php
          $result = mysqli_query($connect,"SELECT eleves.nom, eleves.prenom, inscription.note, eleves.ideleve from inscription join eleves on inscription.ideleve=eleves.ideleve where inscription.idseance='$seance'");
          //on joint inscription et eleves sur l'ideleve pour obtenir les élèves incrits à la séance
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          if (mysqli_num_rows($result)!=0){
            echo "<h2>Attribuer le nombres de fautes (de 0 à 40) des élèves<h2>";
            echo "<FORM METHOD='POST' ACTION='noter_eleves.php' >";
            $i = 0;
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
            echo "<label for='noteeleve$i'>$row[0] $row[1]</label>";
            if (empty($row[2])){
              echo "<div  class='effectif' ><input type='number' min='0' max='40' id='noteeleve$i' name='noteeleve$i' required></div>";
            }
            else{
              $nbfaute= 40 - $row[2];
              echo "<div class='effectif'><input type='number' min='0' max='40' id='noteeleve$i' value='$nbfaute' name='noteeleve$i' required></div>";
            }
            echo "<input type='hidden' value='$row[3]' name='eleve$i' >";
            $i ++;
            }
            // les input hidden permettent de récupérer les données du premier php vers le 3ème (noter_eleves.php)
          echo "<INPUT type='hidden' name='seance' value='$seance' >";
          echo "<INPUT type='hidden' name='nbeleve' value='$i' >";
          // $i désigne le nombre totale d'élève qui ont participé à la séance
          echo "<INPUT class='boutton' type='submit' value='valider' >";
          echo "</FORM>";
          }
          else{
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Aucun élève a été inscrit à cette séance</p>";
          }
          mysqli_close($connect);
        ?>
        <a href="../php/validation_seance.php">Retour</a>
      </div>
    </section>
  </body>
</html>
