
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Webapp Recupérathèque</title>

  <meta charset="utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- import the css -->
  <!-- to have w3css class and respponsive design -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- to have icon of the font awesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <link rel="stylesheet" href="css/main.css">


</head>

<body>

  <div class="w3-container color-theme">
    <h1>Mycélium</h1>
  </div>

  <!-- Checks des parametres GET -->

  <?php
    //check les $_GET de recherche si valide
      //check si l'option de recherche est valide
    if (isset($_GET['search'])){
      $recherche = htmlspecialchars($_GET['search']);
    } else{
      $recherche = '';
    }
      //check si l'option de tri est parmis les choix valide
    $tri_option = array('date_ajout', 'état', 'nombre');
    if (isset($_GET['order']) && in_array($_GET['order'], $tri_option)){
      $tri = htmlspecialchars($_GET['order']);
    } else{
      $tri = 'date_ajout';
    }

  ?>

  <?php

  function make_thumb($src, $dest) {

  	/* read the source image */
  	$source_image = imagecreatefromjpeg($src);
  	$width = imagesx($source_image);
  	$height = imagesy($source_image);

  	$desired_width = 400;
  	$desired_height = 400;

  	/* create a new, "virtual" image */
  	$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

  	/* copy source image at a resized size */
  	// imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    $virtual_image = imagecrop ( $source_image , ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 400] );
  	/* create the physical thumbnail image to its destination */
  	imagejpeg($virtual_image, $dest);
  }

  ?>

  <?php
  //connection database
  try{
    $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'webappdev', 'datarecoulechemindejerusalem', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e){
      die('Erreur : '.$e->getMessage());
  }
  ?>

  <!-- Bar de recherche - formulaire -->
  <div class="search-bar-container">
    <form class="search-bar" action="catalogue.php" method="GET">

          <div class="search-bar-item">
            <label class="w3-xlarge fa fa-search search-bar-label"></label>
            <!-- le php a l'interieur rempli la valeur recherché au chargement de la page en fonction de ce qui a été envoyé en Get -->
            <input type="text" class="w3-input search-bar-input" name="search" placeholder="Recherche..." value="<?php echo $recherche?>">
          </div>

          <div class="search-bar-item">
            <label class="search-bar-label">Trier par</label>
            <select class="w3-select" name="order">
              <!-- le php a l'interieur selectionne le bon choix au chargement de la page en fonction de ce qui a été envoyé en Get -->
              <option value="date_ajout" <?php if($tri=="date_ajout"){echo 'selected';} ?> >Date de récupération</option>
              <option value="état" <?php if($tri=="état"){echo 'selected';} ?> >État d'usure</option>
              <option value="nombre" <?php if($tri=="nombre"){echo 'selected';} ?> >Unités disponibles</option>
            </select>
          </div>

          <div class="search-bar-item">
            <input  class="w3-btn color-theme search-bar-input" type="submit" value="Go"/>
          </div>

    </form>


  </div>

  <div class="categorie_menu w3-quarter">
    <button onclick="myFunction('cat')" class="w3-btn w3-block categorie_selector">
        Categorie
    </button>
    <div id="cat" class="w3-hide">
    <?php
      //prep the request
      //every line is a souscategorie
      $req = $bdd->prepare('  SELECT cat.ID AS cat_ID, cat.nom AS cat_nom,
                              sscat.ID, sscat.ID_categorie, sscat.nom AS nom
                              FROM souscategorie sscat
                              INNER JOIN categorie cat ON sscat.ID_categorie=cat.ID
                              ORDER BY cat.ID
                          ');
      //execute the request
      $req->execute();

      if ($req->rowCount() > 0) {
        $current_cat = '';

        while($sscat = $req->fetch()){

          //peut etre mieux d'en faire un objet PHP avec liste et sous liste et de le reparcourir apres????

          //si la categorie de de sscat a changé on crée un nouveau accordeon
          if($current_cat != $sscat['cat_ID']){

            //si on a deja ouvert un accordeon, on doit le refermer avant d'en faire  autre
            if($current_cat != ''){
              echo '</div>';
            }

            $current_cat = $sscat['cat_ID'];

            ?>

            <!-- declare l'accordeon d'une categorie -->
            <button onclick="myFunction('<?php echo $sscat['cat_ID']; ?>')" class="w3-btn w3-block categorie">
              <?php echo $sscat['cat_nom']; ?> <span class='item-icon'>▾</span>
            </button>
            <!-- ouvre l'accordeon des sscat associées -->
            <div id="<?php echo $sscat['cat_ID']; ?>" class="w3-hide">

            <?php
          }
          ?>

          <!-- ajoute une souscategorie comme bouton -->
          <button class="w3-btn w3-block souscategorie"> <?php echo $sscat['nom']; ?> </button>

          <?php
        }
        // ferme le dernier accordeon des sscat associées
        echo '</div>';
      }
    ?>
    </div>
  </div>

  <script>
    function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else {
        x.className = x.className.replace(" w3-show", "");
      }
    }
  </script>


  <div class="w3-row w3-threequarter items-container">

    <?php
      //prep the request
      //every lines is an item with joined categorie and subcategorie
      $req = $bdd->prepare('  SELECT
                              c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.nombre AS nombre, c.mesure AS mesure, c.état AS état, c.tags AS tags, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
                              cat.ID, cat.nom AS categorie,
                              sscat.ID, sscat.ID_categorie, sscat.nom AS sous_categorie
                              FROM catalogue c
                              INNER JOIN categorie cat ON c.ID_categorie=cat.ID
                              INNER JOIN souscategorie sscat ON c.ID_souscategorie=sscat.ID
                              WHERE cat.nom LIKE :search OR sscat.nom LIKE :search OR mesure LIKE :search OR tags LIKE :search OR description LIKE :search
                              ORDER BY ' . $tri . ' DESC
                          ');

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
