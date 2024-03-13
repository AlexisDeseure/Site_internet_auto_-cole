<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="calendrier">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $eleve = mysqli_real_escape_string($connect,$_POST['eleve']);
          // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
          date_default_timezone_set('Europe/Paris');
          $dateIns = date("Y-m-d");
          if (empty($eleve)){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Certains éléments sont manquants </p>";
            exit;
          }
          else{
            $query = "select * from eleves where ideleve=$eleve";
            //sélectionne les infos sur l'élève
            $result = mysqli_query($connect, $query);
            if (!$result){
              echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
              echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
              exit;
            }
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo "<h1>Calendrier de $row[2] $row[1]</h1>";
          $query = "SELECT themes.nom, seances.DateSeance, themes.descriptif from inscription 
                    JOIN seances on seances.idseance=inscription.idseance
                    JOIN themes ON themes.idtheme = seances.idtheme 
                    WHERE inscription.ideleve = $row[0]  AND seances.DateSeance >= '$dateIns'
                    ORDER BY seances.DateSeance";
          // on joint themes, seances et inscription puis on sélectionne à chaque ligne le nom du thème,la date de la séance et le descriptif du thème qui correspondent à l'élève et dont la date n'est pas encore passée. On trie ensuite le tableau en fonction de la date
          $result = mysqli_query($connect, $query);
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          $compteur = mysqli_num_rows($result);
          if ($compteur == 0){
            echo "<p><b>Cet élève n'a pas de séances à venir</b></p>";
          }
          else{
            echo "<table class='content-table'>
                      <thead>
                        <tr>
                          <th>Thème</th>
                          <th>Descriptif</th>
                        </tr>
                      </thead>
                      <tbody>";
            $date1 = "0000-00-00";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
              if ($row[1] > $date1){
                $date1 = $row[1];
                $dateform = substr($row[1],8,2)."/".substr($row[1],5,2)."/".substr($row[1],0,4);
                echo"<tr>
                        <td class='date_calendrier' colspan='2'>$dateform</td>
                    </tr>";
              }
              // l'attribut colspan permet à la date de se positionner sur 2 colonnes au lieuu d'une pour parître centrée et donner l'effet plus esthétique

              echo"<tr>
                      <td>$row[0]</td>
                      <td>$row[2]</td>
                  </tr>";
            }
            echo "</tbody>
                  </table>";
          }
          }
          mysqli_close($connect);
        ?>
        <a href="../php/visualisation_calendrier_eleve.php">Retour</a>
      </div>
    </section>
  </body>
</html>
