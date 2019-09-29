<html>
<body>

<?php
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);


if (function_exists('ssh2_connect')) {
echo "Les fonctions SSH2 sont disponibles.";
} else {
echo "Les fonctions SSH2 ne sont pas disponibles.";
}
*/
?>

<table>

  <?php
    include('connection_db.php')
  ?>

<?php

      //prep the request
      $req = $bdd->prepare('  SELECT MAX(`ID`)  AS `greatestID` FROM `catalogue`
                          ');
      //execute the request
      $req->execute();

    $object_id= $req->fetchColumn() + 1;




$categorie = $_POST['cat'];
$souscategorie = $_POST['souscat'];
$tags = $_POST['tags'];
$pieces = $_POST['pieces'];
$poids= $_POST['poids'];
$etat= $_POST['etat'];
$prix= $_POST['prix'];
$remarques= $_POST['remarques'];
$dimensions= $_POST['dimensions'];
$localisation = $_POST['localisation'];

//la separation des tags devient: 'virgule espace' et plus juste 'virgule'
$tags = str_replace(",", ", ", $tags);

try {

    $req = $bdd ->prepare("INSERT INTO catalogue (ID_categorie,	ID_souscategorie, pieces, dimensions, etat, tags, remarques, poids, prix, localisation)
                                  VALUES (:ID_categorie, :ID_souscategorie, :pieces, :dimensions, :etat, :tags, :remarques, :poids, :prix, :localisation)
                          ");

$req->bindParam(':ID_categorie', $categorie);
$req->bindParam(':ID_souscategorie', $souscategorie);
$req->bindParam(':pieces', $pieces);
$req->bindParam(':dimensions', $dimensions);
$req->bindParam(':etat', $etat);
$req->bindParam(':tags', $tags);
$req->bindParam(':remarques', $remarques);
$req->bindParam(':poids', $poids);
$req->bindParam(':prix', $prix);
$req->bindParam(':localisation', $localisation);



$req->execute();
$add_result="success";


}
catch(PDOException $e)
    {
    $add_result=  $e->getMessage();
    }


//echo "Opérations sur l'image... <br />";
  $img = $_POST['image_final'];
  $img = str_replace('data:image/jpeg;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);
  //
  //
  // // Create temporary file
   $local_file=fopen('php://temp', 'r+');
   fwrite($local_file, $data);
   rewind($local_file);
  //
  //   // FTP login
  //   $host = 'sftp.sd3.gpaas.net';
  //   $port = 22;
  //   $username = '1685312';
  //   $password = 'datarecoulechemindejerusalem';
  //   $remotePath = '/vhosts/federation.recuperatheque.org/htdocs/photos/';
    $remoteFilePath = getcwd().'/photos/'.$object_id.'.jpg';
  //   $ch = curl_init("sftp://$username:$password@$host$remotePath");
  //
  //   curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
  //   curl_setopt($ch, CURLOPT_SSH_AUTH_TYPES, CURLSSH_AUTH_PUBLICKEY);
  //   /*curl_setopt($ch, CURLOPT_SSH_PUBLIC_KEYFILE, $_SERVER["DOCUMENT_ROOT"]."/home/.ssh/id_rsa.pub");
  //   curl_setopt($ch, CURLOPT_SSH_PRIVATE_KEYFILE, $_SERVER["DOCUMENT_ROOT"]."/home/.ssh/id_rsa");*/
  //   curl_setopt($ch, CURLOPT_VERBOSE, true);
  //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  //
  //
  //   $response= curl_exec ($ch);
  //   /*
  //   if (curl_errno($ch)) {
  //       $error_msg = curl_error($ch);
  //   }
  //
  //   if (isset($error_msg)) {
  //        echo "Erreur d'upload de la photo : ".$error_msg;
  //        //-> renvoie un message d'erreur authentification failed même lorsqu'elle a réussi
  //   }
  //   else
  //   {echo "Photo uploadée avec succès <br />"; */
  //
  //
  //   curl_close ($ch);
  //
  //
  //
    file_put_contents($remoteFilePath, $local_file);




  ?>




</body>
</html>
