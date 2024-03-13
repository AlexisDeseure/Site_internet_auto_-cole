<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="inscription">
    <section id="ajouter_eleve">
      <div class="container">
        <div class="title">
          <h1>Inscrire un élève</h1>
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
          $result = mysqli_query($connect,"SELECT * FROM eleves ORDER BY nom");
          //sélectionne tous les élèves et les trie par nom
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          echo "<FORM METHOD='POST' ACTION='inscrire_eleve.php' >";
          echo "<label for='eleve'>Choisissez un élève</label>";
          echo "<SELECT id='eleve' name='eleve' BORDER='1' required>";
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
          {
          echo "<OPTION VALUE='".$row[0]."'>".$row[1]." ".$row[2]."</OPTION>";
          }
          echo "</select>";
          $result = mysqli_query($connect,"SELECT * FROM seances where DateSeance >= '$dateIns' ORDER BY DateSeance ");
          //sélectionne toutes les séances où la date est supérieure à celle du jour et les classes par date
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          echo "<label for='seance'>Choisir la séance</label>";
          echo "<SELECT id='seance' name='seance' BORDER='1' required>";
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
          {
          $result2 = mysqli_query($connect,"SELECT * FROM themes where idtheme = '$row[3]'");
          // on récupère le theme qui correspond à l'id obtenu dans séance
          if (!$result2){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          $row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
          echo "<OPTION VALUE='$row[0]'>$row2[1] ($row[1])</OPTION>";
          }
          echo "</select>";
          echo "<label for='effectif'><p>Attribuer une note/40</p><p id='sous_titre'> (vous pourrez le faire plus tard <a href='validation_seance.php'>ici</a>)</p> </label>";
          echo "<div class='effectif'><input id='effectif' type='number' name='note' min='0' max='40'></div>";
          echo "<INPUT class='boutton' type='submit' value='Inscrire' >";
          echo "</FORM>";
          mysqli_close($connect);
        ?>
      </div>
    </section>
  </body>
</html>
