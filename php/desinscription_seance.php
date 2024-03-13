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
          <h1>Désinscrire un élève d'une séance</h1>
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
          if (!$_POST){
            //on effectue ce résultat si on a reçu aucune information d'un POST c'est le cas ou on clique sur désinscrire mais où on a pas choisi encore l'élève
            $result = mysqli_query($connect,"SELECT * FROM eleves ORDER BY nom");
            //cette requete selectionne les élèves et les classe par nom
            if (!$result){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                exit;
            }
            echo "<FORM METHOD='POST' ACTION='desinscription_seance.php' >";
            echo "<label for='eleve'>Choisissez un élève</label>";
            echo "<SELECT id='eleve' name='eleve' BORDER='1' required>";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
            echo "<OPTION VALUE='".$row[0]."'>".$row[1]." ".$row[2]."</OPTION>";
            }
            echo "</select>";
            echo "<INPUT class='boutton' type='submit' value='Continuer' >";
            echo "</FORM>";
          }
          else{
            //cas où on a choisi l'élève
            $eleve = mysqli_real_escape_string($connect, $_POST['eleve']);  
            // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
            $query="SELECT inscription.idseance, themes.nom, seances.DateSeance FROM inscription
                    JOIN seances ON seances.idseance=inscription.idseance
                    JOIN themes ON seances.idtheme=themes.idtheme
                    WHERE inscription.ideleve = $eleve and seances.DateSeance >= '$dateIns'
                    ORDER BY themes.nom";
            // cette requête joint inscription, seances et themes puis selectionne les éléments qui correspondent avec l'id de l'eleve recherché pour une date supérieure à celle du jour
            $result = mysqli_query($connect,$query);
            if (!$result){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                exit;
            }
            $compteur = mysqli_num_rows($result);
            //compte le nombre de ligne du résulat de la requête
            if ($compteur == 0){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Cette élève n'est inscrit à aucune séance</p>";
                echo "<a href='../php/desinscription_seance.php'>Retour</a>";
                exit;
            }
            echo "<FORM METHOD='POST' ACTION='desinscrire_seance.php' >";
            echo "<label for='seance'>Choisissez une séance à laquelle il est inscrit</label>";
            echo "<SELECT id='seance' name='seance' BORDER='1' required>";
            while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
            {
                $row2 = mysqli_fetch_array($result2, MYSQLI_NUM);
                echo "<OPTION VALUE='$row[0]'>$row[1] ($row[2])</OPTION>";
            }
            echo "</select>";
            echo "<INPUT type='hidden' value='$eleve' name='eleve' >";
            echo "<INPUT class='boutton' type='submit' value='Désinscrire' >";
            echo "</FORM>";
            echo "<a href='../php/desinscription_seance.php'>Retour</a>";
          }
          mysqli_close($connect);
        ?>
      </div>
    </section>
  </body>
</html>
