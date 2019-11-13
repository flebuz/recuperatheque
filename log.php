
<?php

  include('connection_db.php');

  //  Récupération de l'utilisateur et de son pass hashé
  $req = $bdd->prepare('SELECT id, raccourci, mdp FROM recuperatheques WHERE raccourci = :raccourci');
  $req->execute(array('raccourci' => $_POST['pseudo']));

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
          $_SESSION['pseudo'] = $resultat['raccourci'];
          echo 'Vous êtes connecté !';
          echo $resultat['id'];
          echo $resultat['raccourci'];
      }
      else {
          echo 'Mauvais identifiant ou mot de passe';
      }
  }

  // header("Location: catalogue.php?r=" . $_POST['pseudo']);

?>
