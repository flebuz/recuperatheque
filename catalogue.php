
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Webapp Recupérathèque</title>

  <meta charset="utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- import the css -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">


</head>

<body>

  <div class="w3-container color-theme">
    <h1>[Nom de l'app]</h1>
  </div>

  <?php
    //check les $_GET de recherche si valide
      //check si l'option de recherche est valide
    if (isset($_GET['search'])){
      $recherche = htmlspecialchars($_GET['search']);
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

  ?>

  <form class="w3-bar w3-dark-grey" action="catalogue.php" method="GET">

        <!-- <div class="w3-bar-item w3-mobile">
          <i class="w3-bar-item w3-xlarge fa fa-search"></i>
        </div> -->

        <div class="w3-bar-item w3-mobile">
          <!-- le php a l'interieur rempli la valeur recherché au chargement de la page en fonction de ce qui a été envoyé en Get -->
          <input type="text" class="w3-input" name="search" placeholder="Recherche..." value="<?php echo $recherche?>">
        </div>

        <!-- <div class="w3-bar-item w3-mobile">
          Trier par
        </div> -->

        <div class="w3-bar-item w3-mobile">
          <select class="w3-select" name="order">
            <!-- le php a l'interieur selectionne le bon choix au chargement de la page en fonction de ce qui a été envoyé en Get -->
            <option value="date_ajout" <?php if($tri=="date_ajout"){echo 'selected';} ?> >Date de récupération</option>
            <option value="qualite" <?php if($tri=="qualite"){echo 'selected';} ?> >Qualité</option>
            <option value="nombre" <?php if($tri=="nombre"){echo 'selected';} ?> >Unités disponibles</option>
          </select>
        </div>

        <div class="w3-bar-item w3-mobile">
          <input  class="w3-btn color-theme" type="submit" value="Go"/>
        </div>

  </form>


  <div class="w3-row items_container">

    <?php

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

      if ($req->rowCount() > 0) {
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
      }
      else {
        echo '<h3 class="w3-container">Aucun résultat ne correspond à la recherche</h3>';
      }
      ?>

    </div>

</body>

</html>
