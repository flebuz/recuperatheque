

<?php
  include('connection_db.php');

  $recuperatheque = 'gilbards';
  $mdp = password_hash('non', PASSWORD_DEFAULT);

  $req = $bdd ->prepare("UPDATE recuperatheques
                         SET mdp = :mdp
                         WHERE raccourci = :raccourci
                        ");
  $req->bindParam(':mdp', $mdp);
  $req->bindParam(':raccourci', $recuperatheque);
  $req->execute();
?>
