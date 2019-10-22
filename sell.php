<html>
<head>
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/add_form.css">
</head>
<body>

<?php
/*
error_reporting(E_ALL);
ini_set("display_errors", 1);

*/
?>

<table>

  <?php
    include('connection_db.php')
  ?>

<?php


$object_id = $_POST['ID_item'];

$pieces_vendues = $_POST['pieces_vendues'];
$poids= $_POST['poids_total'];

$prix= $_POST['prix'];


$req = $bdd ->prepare("SELECT c.pieces, c.ID_categorie, c.ID_souscategorie, c.etat, c.localisation
                       FROM catalogue c
                       WHERE c.id=:ID_item
                      ");
$req->bindParam(':ID_item', $object_id);
$req->execute();

if ($req->rowCount() > 0) {
  $item = $req->fetch();
  $pieces_en_stock = $item['pieces'];
  $pieces_restantes = $pieces_en_stock - $pieces_vendues;

  $categorie = $item['ID_categorie'];
   $souscategorie = $item['ID_souscategorie'];
  $etat = $item['etat'];
  $localisation = $item['localisation'];
}
else {
  echo "Erreur : Impossible d'accéder aux nombres de pièces en stock";
}


if ($pieces_restantes >0 )
{  $req = $bdd ->prepare("UPDATE catalogue
                                SET pieces=:pieces
                                WHERE ID=:ID_item
                        ");
  $req->bindParam(':ID_item', $object_id);
 $req->bindParam(':pieces', $pieces_restantes);
$redirect="item_page.php?id=".$object_id;
}

  else {
    $req = $bdd ->prepare("DELETE FROM catalogue
                                  WHERE ID=:ID_item
                          ");
    $req->bindParam(':ID_item', $object_id);
    $redirect="catalogue.php";
  }

try {
      //$req->bindParam(':poids', $poids);
      //$req->bindParam(':prix', $prix);

$req->execute();
$result="success";

}
catch(PDOException $e)
    {
    $result=  $e->getMessage();
    echo $result;
    }



    // Adding a line to the journal
        try {

    $operation = "sell";

            $req = $bdd ->prepare("INSERT INTO journal (operation, ID_objet, ID_categorie,	ID_souscategorie, pieces, etat, poids, prix, localisation)
                                          VALUES (:operation, :ID_objet, :ID_categorie, :ID_souscategorie, :pieces, :etat, :poids, :prix, :localisation)
                                  ");

        $req->bindParam(':operation', $operation);
        $req->bindParam(':ID_objet', $object_id);
        $req->bindParam(':ID_categorie', $categorie);
        $req->bindParam(':ID_souscategorie', $souscategorie);
        $req->bindParam(':pieces', $pieces_vendues);
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
  <div id="loading_overlay" class="overlay visible">
    <!-- Overlay content -->
    <div class="overlay-content">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

  </div>

  <div id="modal_sold" class="w3-modal" style="z-index: 1000;">
   <div class="w3-modal-content">

     <header class="w3-container">
       <h2>Transaction terminée</h2>
     </header>

     <div class="w3-container">
       <p><?php if (isset($pieces_vendues)){
         header("refresh:2; url='catalogue.php'");

         if ($pieces_vendues>1)
         {echo $pieces_vendues." objets vendus<br /><br />";}
         else
         {echo $pieces_vendues." objet vendu<br /><br />";}

         if ($pieces_restantes==0)
         {echo "Le stock de cet objet est épuisé !<br /><br />";}
       }?>Redirection dans 2 secondes...</p>
     </div>

     <footer class="w3-container">
       <div class="w3-right">
         <button class="button-flex item-button" onclick="javascript:window.location.replace('<?php echo $redirect;?>')">
           <div class="button-title">OK &nbsp;</div>
         </button>
       </div>
     </footer>

   </div>
 </div>

<?php if ($result=='success')
{
 echo"<script>document.getElementById('modal_sold').style.display='block'</script>";


 }
?>


</body>
</html>
