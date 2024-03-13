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
          <h1>Valider une séance</h1>
        </div>
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          date_default_timezone_set('Europe/Paris');
          $dateIns = date("Y-m-d");
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $result = mysqli_query($connect,"SELECT seances.idseance, themes.nom, seances.DateSeance from seances, themes where (DateSeance < '$dateIns' and seances.idtheme=themes.idtheme)");
          // on sélectionne uniquement les séances passées
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          echo "<FORM METHOD='POST' ACTION='valider_seance.php' >";
          echo "<label for='seance'>Choisissez une séance passée</label>";
          echo "<SELECT id='seance' name='seance' BORDER='1' required>";
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
          {
          echo "<OPTION VALUE='".$row[0]."'>".$row[1]." ( ".$row[2]." )</OPTION>";
          }
          echo "</select>";
          echo "<INPUT class='boutton' type='submit' value='Continuer' >";
          echo "</FORM>";
          mysqli_close($connect);
        ?>
      </div>
    </section>
  </body>
</html>
