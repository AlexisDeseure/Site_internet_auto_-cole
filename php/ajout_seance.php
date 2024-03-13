<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="ajouter_seance">
    <section id="ajouter_eleve">
      <div class="container">
        <div class="title">
          <h1>Ajouter une séance</h1>
        </div>
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          // informations de connexion à la base de donnée 
          date_default_timezone_set('Europe/Paris');
          $dateIns = date("Y-m-d");
          // obtention date du jour
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $result = mysqli_query($connect,"SELECT * FROM themes where supprime=0 ORDER BY nom");
          // requête qui sélectionne tous les thèmes non supprimés dans l'ordre alphabétique sur le nom
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          echo "<FORM METHOD='POST' ACTION='ajouter_seance.php' >";
          echo "<label for='theme'>Choisissez un thème</label>";
          echo "<SELECT id='theme' name='theme' BORDER='1' required>";
          while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
          {
          // on parcourt les lignes du tableau obtenu par la requête pour les afficher dans le select
          echo "<OPTION VALUE='".$row[0]."'>".$row[1]."</OPTION>";
          // on récupère l'id du thème mais on affiche son nom
          }
          echo "</select>";
          echo "<label for='horaire'>Date</label>";
          echo "<input id='horaire' type='date' min='$dateIns' name='date' value='$dateIns' required>";
          // la date minimum sera celle du jour (qui sera également dans le sql d'après)
          echo "<label for='effectif'>Effectif maximal</label>";
          echo "<div class='effectif'><input id='effectif' type='number' name='eff' min='0' value='10' required></div>";
          echo "<INPUT class='boutton' type='submit' value='Enregistrer' >";
          echo "</FORM>";
          mysqli_close($connect);
        ?>
      </div>
    </section>
  </body>
</html>
