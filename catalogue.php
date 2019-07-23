
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

  <form action="catalogue.php" method="GET">

    <input type="text" class="w3-input" name="search">

    <select class="w3-select" name="order">
      <option value="date_ajout">Date de récupération</option>
      <option value="qualite">Qualité</option>
      <option value="nombre">Unités disponibles</option>
    </select>

    <input  class="w3-button search" type="submit" value="RECHERCHE" style="width:100%"/>

  </form>

  <div class="item_container">

    <?php

      //check les $_GET de recherche si valide
        //check si l'option de recherche est valide
      if (isset($_GET['search'])){
        $recherche = '%'.htmlspecialchars($_GET['search']).'%';
      } else{
        $recherche = '';
      }
        //check si l'option de tri est parmis les choix valide
      $tri_option = array('date_ajout', 'qualite', 'nombre');
      if (isset($_GET['order']) && in_array($_GET['order'], $tri_option)){
        $tri = htmlspecialchars($_GET['order']);
      } else{
        $tri = 'date_ajout';
      }

      //connection database
      try{
        $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      }
      catch(Exception $e){
          die('Erreur : '.$e->getMessage());
      }

      //prep the request
      $req = $bdd->prepare('  SELECT ID, categorie, sous_categorie, nombre, mesure, qualite, tags, DATE_FORMAT(date_ajout, \'%d/%m/%Y\') AS date_ajout_fr
                              FROM catalogue
                              WHERE categorie LIKE :search OR sous_categorie LIKE :search OR mesure LIKE :search OR tags LIKE :search OR description LIKE :search
                              ORDER BY ' . $tri . ' DESC '
                          );

      //complete parametric values (note: column names are not values, and thus must be hardcoded into the query)
      $req->bindValue(':search', '%' . $recherche . '%', PDO::PARAM_STR);

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
