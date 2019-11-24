

<?php
  session_start();
  include('connection_db.php');

  $connection_refused = false;

  // --- check le mot de passe

  // Récupération de l'utilisateur et de son pass hashé
  $req = $bdd->prepare('SELECT * FROM _global_recuperatheques WHERE pseudo = :pseudo');
  $req->execute(array('pseudo' => $_SESSION['pseudo']));
  $item = $req->fetch();

  // Comparaison du pass envoyé via le formulaire avec la base
  $isPasswordCorrect = password_verify($_POST['mdp'], $item['mdp']);

  if ($isPasswordCorrect) {

    //on update les infos
    $req = $bdd ->prepare(
      "UPDATE _global_recuperatheques
      SET adresse = :adresse, monnaie = :monnaie, telephone = :telephone, site = :site, mail = :mail, mdp = :mdp_new
      WHERE pseudo = :pseudo
      ");

    $pseudo = htmlspecialchars($_SESSION['pseudo']);

    $adresse = htmlspecialchars($_POST['adresse']);
    $monnaie = htmlspecialchars($_POST['monnaie']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $site = htmlspecialchars($_POST['site']);
    $mail = htmlspecialchars($_POST['mail']);

    // si nouveau mdp envoyé
    if(isset($_POST['mdp_new']) && !empty($_POST['mdp_new'])){
      // on hash le nouveau mot de passe
      $mdp_new = password_hash($_POST['mdp_new'], PASSWORD_DEFAULT);
    }
    else{
      $mdp_new = $item['mdp'];
    }

    $req->bindParam(':adresse', $adresse);
    $req->bindParam(':monnaie', $monnaie);
    $req->bindParam(':telephone', $telephone);
    $req->bindParam(':site', $site);
    $req->bindParam(':mail', $mail);
    $req->bindParam(':mdp_new', $mdp_new);
    $req->bindParam(':pseudo', $pseudo);

    $req->execute();

  }
  else{
    $connection_refused = true;
  }

  $url = "user.php";
  if($connection_refused){
    $url = $url . "?e=wrong";
  }
  header("Location:" . $url);

?>
