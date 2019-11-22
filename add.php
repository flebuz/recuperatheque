<html>
<body>


<table>

  <?php
    //include_once('connection_db.php')
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
$has_weight = $_POST['has_weight'];
$poids= $_POST['poids'];
$etat= $_POST['etat'];
$prix= $_POST['prix'];
$remarques= $_POST['remarques'];
$dimensions= $_POST['dimensions'];
$localisation = $_POST['localisation'];
$date = date('Y-m-d H:i:s');


//la separation des tags devient: 'virgule espace' et plus juste 'virgule'
$tags = str_replace(",", ", ", $tags);

if ($has_weight ) {$poids= $_POST['poids'];}
else {$poids= 0;}


try {

    $req = $bdd ->prepare("INSERT INTO catalogue (ID, ID_categorie,	ID_souscategorie, pieces, dimensions, etat, tags, remarques, poids, prix, localisation)
                                  VALUES (:ID, :ID_categorie, :ID_souscategorie, :pieces, :dimensions, :etat, :tags, :remarques, :poids, :prix, :localisation)
                          ");

$req->bindParam(':ID', $object_id);
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
$result="success";



}
catch(PDOException $e)
    {
    $result=  $e->getMessage();
    echo "erreur ajout à la base de données : ".$result;
    }


// Adding a line to the journal
    try {

$operation = "add";

        $req = $bdd ->prepare("INSERT INTO journal (operation, ID_objet, ID_categorie,	ID_souscategorie, pieces, etat, poids, prix, localisation)
                                      VALUES (:operation, :ID_objet, :ID_categorie, :ID_souscategorie, :pieces, :etat, :poids, :prix, :localisation)
                              ");

    $req->bindParam(':operation', $operation);
    $req->bindParam(':ID_objet', $object_id);
    $req->bindParam(':ID_categorie', $categorie);
    $req->bindParam(':ID_souscategorie', $souscategorie);
    $req->bindParam(':pieces', $pieces);
    $req->bindParam(':etat', $etat);
    $req->bindParam(':poids', $poids);
    $req->bindParam(':prix', $prix);
    $req->bindParam(':localisation', $localisation);



    $req->execute();
    $result="success";



    }
    catch(PDOException $e)
        {
        $result=  $e->getMessage();
        echo "erreur ajout au journal : ".$result;
        }

// update score des catégories
  try {
        $req = $bdd ->prepare("UPDATE categorie
                                       SET score = score +1
                                       WHERE ID=:ID_categorie
                               ");
           $req->bindParam(':ID_categorie', $categorie);

           $req->execute();
           $result="success";


           }
           catch(PDOException $e)
               {
               $result=  $e->getMessage();
               echo "erreur update score des catégories : ".$result;
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
    console_log("object_id dans le nom de l'image : ". $object_id);
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
