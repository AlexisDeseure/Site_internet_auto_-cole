<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="calendrier">
    <section id="ajouter_eleve">
      <div class="container">
        <div class="title">
          <h1>Visualiser le calendrier d'un élève</h1>
        </div>
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $result = mysqli_query($connect,"SELECT nom, prenom, ideleve FROM eleves ORDER BY nom");
          //sélectionne les élèves et les trie par nom
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          echo "<FORM METHOD='POST' ACTION='visualiser_calendrier_eleve.php' >";
          echo "<label for='eleve'>Choisissez un élève</label>";
          echo "<SELECT id='eleve' name='eleve' BORDER='1' required>";
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
          {
          echo "<OPTION VALUE='$row[2]'>$row[0] $row[1] </OPTION>";
          }
          echo "</select>";
          echo "<INPUT class='boutton' type='submit' value='Visualiser' >";
          echo "</FORM>";
          mysqli_close($connect);
        ?>
      </div>
    </section>
  </body>
</html>
