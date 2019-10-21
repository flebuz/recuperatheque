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

//la separation des tags devient: 'virgule espace' et plus juste 'virgule'
$tags = str_replace(",", ", ", $tags);

try {

    if ($action=='edit')
    {

      $req = $bdd ->prepare("UPDATE catalogue
                                    SET ID_categorie=:ID_categorie, ID_souscategorie=:ID_souscategorie, pieces=:pieces, dimensions=:dimensions, etat=:etat, tags=:tags, remarques=:remarques, date_ajout=:date_ajout, poids=:poids, prix=:prix, localisation=:localisation
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
      $req->bindParam(':date_ajout', $date);
      $req->bindParam(':poids', $poids);
      $req->bindParam(':prix', $prix);
      $req->bindParam(':localisation', $localisation);


    }


    else if ($action=='remove')
    {
      $req = $bdd ->prepare("DELETE FROM catalogue
                                    WHERE ID=:ID_item
                            ");
      $req->bindParam(':ID_item', $object_id);

      /* TO DO : removing the image file from the FTP ! */
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
  ?>




</body>
</html>
