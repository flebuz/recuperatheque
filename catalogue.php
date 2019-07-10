
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Webapp Recupérathèque</title>

  <meta charset="utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- import the css -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> <!-- pas utilisé pour le moment, elle standardise un affichage responsif -->
  <link rel="stylesheet" href="css/main.css">


</head>

<body>

  <div class="header">
    <h1>[Nom de l'app]</h1>
  </div>

  <div class="item_container">

    <?php

      //connection database
      try{
        $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      }
      catch(Exception $e){
          die('Erreur : '.$e->getMessage());
      }

      //prep the request
      $req = $bdd->prepare(' SELECT *, DATE_FORMAT(date_ajout, \'%d/%m/%Y\') AS date_ajout_fr FROM catalogue ORDER BY date_ajout DESC ');

      //execute the request
      $req->execute();

      while($item = $req->fetch()){

        //pluriel ou non sur le nombre d'unités
        $unite = "1 unité";
        if ($item['nombre']>1){
          $unite = $item['nombre'] . " unités";
        }

        //divise les tags en list php
        $tags = explode(",",$item['tags']);

        //affichage de l'item
        include('item.php');
      }
      ?>

    </div>

</body>

</html>
