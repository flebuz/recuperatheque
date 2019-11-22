
<?php

  include('connection_db.php');

  //  Récupération de l'utilisateur et de son pass hashé
  $req = $bdd->prepare('SELECT id, pseudo, mdp FROM _global_recuperatheques WHERE pseudo = :pseudo');
  $req->execute(array('pseudo' => $_POST['pseudo']));

  $resultat = $req->fetch();

  // Comparaison du pass envoyé via le formulaire avec la base
  $isPasswordCorrect = password_verify($_POST['mdp'], $resultat['mdp']);

  if (!$resultat)
  {
      echo 'Mauvais identifiant ou mot de passe';
  }
  else
  {
      if ($isPasswordCorrect) {
          session_start();
          $_SESSION['id'] = $resultat['id'];
          $_SESSION['pseudo'] = $resultat['pseudo'];
          echo 'Vous êtes connecté !';
          echo $resultat['id'];
          echo $resultat['pseudo'];
      }
      else {
          echo 'Mauvais identifiant ou mot de passe';
      }
  }

  header("Location: catalogue.php?r=" . $_POST['pseudo']);

?>
_global_recuperatheques
