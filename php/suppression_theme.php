<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="ajouter_theme">
    <section id="ajouter_eleve">
      <div class="container">
        <div class="title">
          <h1>Supprimer un thème</h1>
        </div>
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $result = mysqli_query($connect,"SELECT * FROM themes where supprime=0 ORDER BY nom");
          //permet de sélectionner tout les thèmes non_supprimés et les trier par nom
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          echo "<FORM METHOD='POST' ACTION='supprimer_theme.php' >";
          echo "<label for='theme'>Choisissez un thème à supprimer</label>";
          echo "<SELECT id='theme' name='theme' BORDER='1' required>";
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
          {
          echo "<OPTION VALUE='".$row[0]."'>".$row[1]."</OPTION>";
          }
          echo "</select>";
          echo "<INPUT class='boutton' type='submit' value='Supprimer' >";
          echo "</FORM>";
          mysqli_close($connect);
        ?>
      </div>
    </section>
  </body>
</html>
