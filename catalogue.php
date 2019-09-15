
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
    if (isset($_GET['q'])){
      $query = htmlspecialchars($_GET['q']);
    } else{
      $query = '';
    }
      //check si l'option de tri est parmis les choix valide
    $tri_option = array('prix', 'date_ajout', 'etat', 'pieces');
    if (isset($_GET['order']) && in_array($_GET['order'], $tri_option)){
      $tri = htmlspecialchars($_GET['order']);
    } else{
      $tri = 'prix';
    }

    if(isset($_GET['sscatsearch']) and $_GET['sscatsearch']!=0){
      $sscatsearch = htmlspecialchars($_GET['sscatsearch']);
    } else{
      $sscatsearch = null;
    }

    if(isset($_GET['catsearch']) and $_GET['catsearch']!=0){
      $catsearch = htmlspecialchars($_GET['catsearch']);
    } else{
      $catsearch = null;
    }

  ?>

  <?php
  //connection database
  try{
    $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    // $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'webappdev', 'datarecoulechemindejerusalem', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

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
            <input type="text" class="w3-input search-bar-input" name="q" placeholder="Recherche..." value="<?php echo $query?>">
          </div>

          <div class="search-bar-item">
            <label class="search-bar-label">Trier par</label>
            <select class="w3-select" name="order">
              <!-- le php a l'interieur selectionne le bon choix au chargement de la page en fonction de ce qui a été envoyé en Get -->
              <option value="prix" <?php if($tri=="prix"){echo 'selected';} ?> >Prix par unité</option>
              <option value="date_ajout" <?php if($tri=="date_ajout"){echo 'selected';} ?> >Date de récupération</option>
              <option value="etat" <?php if($tri=="etat"){echo 'selected';} ?> >État d'usure</option>
              <option value="pieces" <?php if($tri=="pieces"){echo 'selected';} ?> >Unités disponibles</option>
            </select>
          </div>

          <?php
          // on ajoute cat et sscat si jamais c'est déjà préciser
          if($catsearch){
            echo '<input type="hidden" name="catsearch" value="' . $catsearch . '"/>';
          }
          if($sscatsearch){
            echo '<input type="hidden" name="sscatsearch" value="' . $sscatsearch . '"/>';
          }
          ?>

          <div class="search-bar-item">
            <input class="w3-button color-theme search-bar-input" type="submit" value="Go"/>
          </div>

    </form>
  </div>



  <div class="w3-row">
    <div class="w3-col s12 m3 l3">

        <?php include('categories_menu.php'); ?>

    </div>


    <div class="w3-col s12 m9 l9">
      <div class="w3-row items-container">

        <?php
          //prep the request
          //every lines is an item with joined categorie and subcategorie
          $req = $bdd->prepare('  SELECT
                                  c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags, c.prix AS prix, c.poids AS poids, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
                                  cat.ID, cat.nom AS categorie,
                                  sscat.ID AS sscatID, sscat.ID_categorie, sscat.unite AS unitesscat, sscat.prix AS prixsscat, sscat.nom AS sous_categorie
                                  FROM catalogue c
                                  INNER JOIN categorie cat ON c.ID_categorie=cat.ID
                                  INNER JOIN souscategorie sscat ON c.ID_souscategorie=sscat.ID
                                  WHERE (cat.nom LIKE :search OR sscat.nom LIKE :search OR dimensions LIKE :search OR tags LIKE :search OR remarques LIKE :search)
                                  AND (c.ID_souscategorie = :sscatsearch OR :sscatsearch is null)
                                  AND (c.ID_categorie = :catsearch OR :catsearch is null)
                                  ORDER BY ' . $tri . ' DESC
                              ');

          //complete parametric values (note: column names are not values, and thus must be hardcoded into the query)
          $req->bindValue(':search', '%' . $query . '%', PDO::PARAM_STR);
          $req->bindValue(':sscatsearch', $sscatsearch, PDO::PARAM_INT);
          $req->bindValue(':catsearch', $catsearch, PDO::PARAM_INT);

          //execute la requete
          $req->execute();

          if ($req->rowCount() > 0) {
            while($item = $req->fetch()){

              //affichage de l'item
              include('item.php');
            }
          }
          else {
            echo '<h3 class="w3-container"> Aucun résultat ne correspond à la recherche </h3>';
          }
        ?>

      </div>
    </div>

  </div>

</body>

</html>
