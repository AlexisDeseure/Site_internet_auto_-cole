<?php
header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/php/validation_seance.php');
?>
<!-- permet de renvoyer vers le lien ci-dessus au bout de 5secondes -->
<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link  rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="validation">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $nbeleve = mysqli_real_escape_string($connect, $_POST['nbeleve']); 
          $seance = mysqli_real_escape_string($connect, $_POST['seance']);  
          // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
          $tab=array();
          // La partie suivante consiste à récupérer chacun des ideleve ainsi que leur nombre de fautes dans le formulaire valider_seance.php et de les rentrer dans le tableau $tab sous forme de couple
          for($i=0;$i<$nbeleve;$i++){
            // on incrémente le $i en utilisant un for pour changer dynamiquement les valeurs dans le post
            $inpost="noteeleve$i";
            $noteeleve = mysqli_real_escape_string($connect, $_POST[$inpost]); 
            $inpost="eleve$i";
            $eleve = mysqli_real_escape_string($connect, $_POST[$inpost]); 
            if (!isset($noteeleve) or $noteeleve<0 or $noteeleve>40){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Veuillez remplir tous les champs correctement</p>";
                echo "<p>Vous allez être redirigé dans quelques secondes</p>";
                echo "<a href='../php/validation_seance.php'>Retour</a>";
                exit;
            }
            $note=40-$noteeleve;
            // on converti le nombre de fautes en note
            $tab[]=array($note,$eleve);
          }
          foreach($tab as $valeur){
            // on parcourt le tableau pour obtenir chaque couple de valeurs (note,ideleve) puis on modifie la table à chaque fois avec les nouvelles valeurs
            $query = "update inscription set note= '$valeur[0]' where (idseance='$seance' and ideleve='$valeur[1]')";
            $result = mysqli_query($connect, $query);
            if (!$result){
                echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                mysqli_close($connect);
                echo "<p>Vous allez être redirigé dans quelques secondes</p>";
                echo "<a href='../php/validation_seance.php'>Retour</a>";
                exit;
            }
          }
          
          mysqli_close($connect);
          echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
          echo "<p>La séance est bien validée. Vous pourrez toujours modifier les notes plus tard.</p>";
          echo "<p>Vous allez être redirigé dans quelques secondes</p>";
        ?>
        <a href="../php/validation_seance.php">Retour</a>
      </div>
    </section>
  </body>
</html>
