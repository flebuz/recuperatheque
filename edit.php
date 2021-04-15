
<html>
<head>

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/menu.css">

</head>


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




  <?php
    include('connection_db.php')
  ?>
  <?php
  include('header.php');
  ?>

<?php
if(isset($_SESSION['pseudo']))
    {
        $recuperatheque = $_SESSION['pseudo'];
        $recuperatheque_catalogue = $recuperatheque . '_catalogue';
        $recuperatheque_journal = $recuperatheque . '_journal';
    }

$action = $_POST['action'];
$object_id = $_POST['ID_item'];


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
$date = date('Y-m-d H:i:s');

echo $action;

//la separation des tags devient: 'virgule espace' et plus juste 'virgule'
$tags = str_replace(",", ", ", $tags);


echo "action: ".$action;

if ($action=='edit')
{
header("refresh:0; url='item_page.php?r=$recuperatheque&id=$object_id&update=1'");

}
else  if ($action=='remove')
  {

    header("refresh:0; url='catalogue.php?r=$recuperatheque'");
}


try {

    if ($action=='edit')
    {

      $req = $bdd ->prepare("UPDATE ".$recuperatheque_catalogue."
                                    SET ID_categorie=:ID_categorie, ID_souscategorie=:ID_souscategorie, pieces=:pieces, dimensions=:dimensions, etat=:etat, tags=:tags, remarques=:remarques, poids=:poids, prix=:prix, localisation=:localisation
                                    WHERE ID=:ID_item
                            ");
      $req->bindParam(':ID_item', $object_id);
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


    }


    else if ($action=='remove')
    {
      $req = $bdd ->prepare("DELETE FROM ".$recuperatheque_catalogue."
                                    WHERE ID=:ID_item
                            ");
      $req->bindParam(':ID_item', $object_id);

      /* TO DO : removing the image file from the FTP ! */

      $remoteFilePath = getcwd().'/photos/'.$recuperatheque.'/'.$object_id.'.jpg';
      unlink($remoteFilePath);
    }


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

    $operation = $action;

            $req = $bdd ->prepare("INSERT INTO ".$recuperatheque_journal." (operation, ID_objet, ID_categorie,	ID_souscategorie, pieces, etat, poids, prix, localisation)
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




    $img = $_POST['image_final'];
// if a new image has been uploaded
if ($img !== null)
    {
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
       $host = 'sftp.sd3.gpaas.net';
       $port = 22;
       $username = '1685312';
       $password = 'datarecoulechemindejerusalem';
       $remotePath = '/vhosts/federation.recuperatheque.org/htdocs/photos/';
      $remoteFilePath = getcwd().'/photos/'.$recuperatheque.'/'.$object_id.'.jpg';
      //console_log("object_id dans le nom de l'image : ". $last_id);
       $ch = curl_init("sftp://$username:$password@$host$remotePath");

       curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
       curl_setopt($ch, CURLOPT_SSH_AUTH_TYPES, CURLSSH_AUTH_PUBLICKEY);
       /*curl_setopt($ch, CURLOPT_SSH_PUBLIC_KEYFILE, $_SERVER["DOCUMENT_ROOT"]."/home/.ssh/id_rsa.pub");
       curl_setopt($ch, CURLOPT_SSH_PRIVATE_KEYFILE, $_SERVER["DOCUMENT_ROOT"]."/home/.ssh/id_rsa");*/
       curl_setopt($ch, CURLOPT_VERBOSE, true);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


       $response= curl_exec ($ch);
       /*
       if (curl_errno($ch)) {
           $error_msg = curl_error($ch);
       }

       if (isset($error_msg)) {
            echo "Erreur d'upload de la photo : ".$error_msg;
            //-> renvoie un message d'erreur authentification failed même lorsqu'elle a réussi
       }
       else
       {echo "Photo uploadée avec succès <br />"; */


       curl_close ($ch);
    //
    //
    //
      file_put_contents($remoteFilePath, $local_file);

}


?>



</body>
</html>
