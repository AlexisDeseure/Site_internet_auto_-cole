<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Auto 3000</title>
    <link rel="stylesheet" href="../css/Stylesheet.css">
  </head>
  <body id="ajout_eleve">
    <section id="ajouter_eleve">
      <div class="container">
        <?php
          date_default_timezone_set('Europe/Paris');
          $dateIns = date("Y-m-d");
          $dbhost = 'tuxa.sme.utc';
          $dbuser = 'nf92a019';
          $dbpass = 'rO3CseyW';
          $dbname = 'nf92a019';
          $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
          mysqli_set_charset($connect, 'utf8');
          $nom = mysqli_real_escape_string($connect, $_POST['nom']);
          $prenom = mysqli_real_escape_string($connect, $_POST['prenom']);
          $date = mysqli_real_escape_string($connect, $_POST['date']);
          
          // on récupère les données du formulaire en les mettant en forme pour éviter les injections sql avec la fonction mysqli_real_escape_string qui permet de transformer n'importe quel caractère spécial x en \x
          $refresh = 1;
          // Variable pour déterminer si on devra ou non rafraichir la page au bout de 5secondes. Cela dépendra de s'il y a des doublons 
          if (!empty($nom) and !empty($prenom) and !empty($date) and $date < $dateIns){
            // si rien est vide et la date est valide on continue 
            $query = "select * from eleves where (nom='$nom' and prenom='$prenom')";
            // sélectionner tous les possibles élèves qui aurait le même nomo que celui que l'on souhaite enregistrer
            $result = mysqli_query($connect, $query);
            if ($result){
              $compteur = mysqli_num_rows($result);
              // compteur pour déterminer s'il y a des résultats à la requête précédente
              if($compteur==0){
                $query = "insert into eleves values (null, '$nom', '$prenom', '$date', '$dateIns')";
                $result = mysqli_query($connect, $query);
                if (!$result){
                  echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
                  echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
                }
                else{
                  echo "<img class='verif' src='../assets/succeed.png' alt='Succès' />";
                  echo "<p>L'élève a bien été ajouté</p>";
                }
              }
              else{
                $refresh = 0;
                // il y a des doublons dans ce cas donc on ne refresh pas automatiquement pour laisser l'utilisateur du temps pour prendre une décision
                echo "<p>Cet/ces élève(s) est/sont déjà enregistré(s) :</p>";
                echo "<table class='content-table'>
                      <thead>
                        <tr>
                          <th>Nom</th>
                          <th>Prénom</th>
                          <th>Naissance</th>
                          <th>Inscription</th>
                        </tr>
                      </thead>
                      <tbody>";

                while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                echo"<tr>
                      <td>$row[1]</td>
                      <td>$row[2]</td>
                      <td>$row[3]</td>
                      <td>$row[4]</td>
                    </tr>";
                }
                // affichage des informations sur les élèves doublons
                echo"</tbody>
                    </table>";
                echo "<p>Souhaitez-vous toutefois continuer l'enregistrement ?</p>";
                echo '<form action="../php/valider_eleve.php" method="POST">
                      <div>
                        <label for="oui">Oui</label>
                        <input type="radio" id="oui" name="result" value="oui">
                        <label for="non">Non</label>
                        <input type="radio" id="non" name="result" value="non" checked>
                        <input type="hidden" name="nom" value="'.$nom.'">
                        <input type="hidden" name="prenom" value="'.$prenom.'">
                        <input type="hidden" name="date" value="'.$date.'">
                        <input type="hidden" name="dateIns" value="'.$dateIns.'">
                      </div>
                      <input class="boutton" type="submit" value="Continuer">
                      </form>';
              // les input du type hidden permettent de transférer des informations du form précédents du fichier html vers le php suivant valider_eleve.php
              }
            }
            else {
              echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
              echo "<p>Quelque chose ne va pas... :</p>".mysqli_error($connect);
            }
            
          }
          else{
            echo "<img class='verif' src='../assets/danger.png' alt='Echec' />";
            echo "<p>Certains éléments sont manquants ou invalides</p>";
          }
          if ($refresh == 1){
            header('Refresh: 5; url=http://tuxa.sme.utc/~nf92a019/projet_auto_ecole/html/ajout_eleve.html');
            // permet de renvoyer vers le lien ci-dessus au bout de 5secondes
            echo "<p>Vous allez être redirigé dans quelques secondes</p>";
          }
          mysqli_close($connect);
        ?>
        <a href="../html/ajout_eleve.html">Retour</a>
      </div>
    </section>
  </body>
</html>
