<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="consulter">
    
    <section id="ajouter_eleve">
      <div class="container">
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          date_default_timezone_set('Europe/Paris');
          $dateIns = date("Y-m-d");
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $eleve = mysqli_real_escape_string($connect, $_POST['eleve']);  
          // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
          if (empty($eleve)){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Certains éléments sont manquants </p>";
            exit;
          }
          else{
            
            $query = "select * from eleves where ideleve=$eleve";
            //sélectionne tous les information des élèves qui respecte la condition
            $result = mysqli_query($connect, $query);
            if (!$result){
              echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
              echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
              exit;
              // si pas de résultat on arrête l'exécution du php
            }
            $row = mysqli_fetch_array($result, MYSQLI_NUM);
            echo "<h2>Informations personnelles</h2>
                  <table class='content-table'>
                      <thead>
                        <tr>
                          <th>Nom</th>
                          <th>Prénom</th>
                          <th>Date de Naissance</th>
                          <th>Date d'inscription</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td>$row[1]</td>
                            <td>$row[2]</td>
                            <td>$row[3]</td>
                            <td>$row[4]</td>
                        </tr>
                      </tbody>
                  </table>";
          $query = "SELECT themes.nom, inscription.note,seances.DateSeance from inscription 
                    JOIN seances on seances.idseance=inscription.idseance
                    JOIN themes ON themes.idtheme = seances.idtheme 
                    WHERE inscription.ideleve = $row[0]  AND seances.DateSeance < '$dateIns'";
          // cette requête joint inscription, themes et seances puis sélectionne l'élément où l'id de l'élève est le bon et la date est dans le passé
          $result = mysqli_query($connect, $query);
          if (!$result){
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            exit;
          }
          $compteur = mysqli_num_rows($result);
          if ($compteur == 0){
            echo "<p><b>Cet élève n'a pas encore effectué de séances</b></p>";
          }
          else{
            echo "<h2>Séances qu'il a effectué</h2>
                  <table class='content-table'>
                      <thead>
                        <tr>
                          <th>Thème</th>
                          <th>Note</th>
                          <th>Date de la séance</th>
                        </tr>
                      </thead>
                      <tbody>";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
              $dateform = substr($row[2],8,2)."/".substr($row[2],5,2)."/".substr($row[2],0,4);
              // cette ligne permet de formater correctement la date en sélectionnant que certaines parties de la chaîne de caractère de la date à l'aide de la fonction substr
              if ($row[1] == ""){
                // pas de note 
                $note = "En attente ...";
              }
              else {
                $note = $row[1];
              }
              echo"<tr>
                      <td>$row[0]</td>
                      <td>$note</td>
                      <td>$dateform</td>
                  </tr>";
            }
            echo "</tbody>
                  </table>";
          }
          }
          mysqli_close($connect);
        ?>
        <a href="../php/consultation_eleve.php">Retour</a>
      </div>
    </section>
  </body>
</html>
