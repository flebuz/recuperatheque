
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
            <input class="w3-btn color-theme search-bar-input" type="submit" value="Go"/>
          </div>

    </form>
  </div>

  <div class="w3-row">
    <div class="w3-col s12 m3 l3">
    <div class="categorie-menu">

      <div class="categorie-menu-title">Categories</div>
      <a href="?catsearch=0&sscatsearch=0" class="w3-block categorie-title tout">Afficher toutes les catégories</a>
      <?php

        //prep the request
        //every line is an item
        //on va faire une liste avec des clés des cat et sscat contenue par le catalogue
        //les clés sont les ID des cat, la value le nb d'objet dedans
        $reqItem = $bdd->prepare('  SELECT * FROM catalogue');
        $reqItem->execute();
        $categorieArray = array();
        $sousCategorieArray = array();
        while($item = $reqItem->fetch()){
          if(array_key_exists($item['ID_categorie'],$categorieArray)){
            $categorieArray[$item['ID_categorie']] += 1;
          }
          else{
            $categorieArray[$item['ID_categorie']] = 1;
          }
          if(array_key_exists($item['ID_souscategorie'],$sousCategorieArray)){
            $sousCategorieArray[$item['ID_souscategorie']] += 1;
          }
          else{
            $sousCategorieArray[$item['ID_souscategorie']] = 1;
          }
        }

        //prep the request
        //every line is a souscategorie
        $reqCat = $bdd->prepare('  SELECT cat.ID AS cat_ID, cat.nom AS cat_nom,
                                sscat.ID AS ID, sscat.ID_categorie, sscat.nom AS nom
                                FROM souscategorie sscat
                                INNER JOIN categorie cat ON sscat.ID_categorie=cat.ID
                                ORDER BY cat.ID, sscat.ID
                                ');
        //execute the request
        $reqCat->execute();

        if ($reqCat->rowCount() > 0) {
          $current_cat = '';

          while($sscat = $reqCat->fetch()){
            //peut etre mieux d'en faire un objet PHP avec liste et sous liste et de le reparcourir apres????

            //si la categorie de de sscat a changé on crée un nouveau accordeon
            if($current_cat != $sscat['cat_ID']){
              //et si la categorie existe dans les items
              if(array_key_exists($sscat['cat_ID'],$categorieArray)){
                //si on a deja ouvert un accordeon, on doit le refermer avant d'en faire un autre
                if($current_cat != ''){
                  echo '</div>';
                  echo '</div>';
                }
                $current_cat = $sscat['cat_ID'];
                ?>

                <!-- declare l'accordeon d'une categorie -->
                <a onclick="myFunction('<?php echo $sscat['cat_ID']; ?>')"
                  class="w3-block categorie-title <?php if($catsearch==$sscat['cat_ID']){echo 'selected open'; }?>">
                  <?php
                    echo $sscat['cat_nom'];
                    echo '<span class="categorie-count">(' . $categorieArray[$sscat['cat_ID']] . ')</span>';
                  ?>
                </a>

                <!-- ouvre l'accordeon des sscat associées -->
                <div id="<?php echo $sscat['cat_ID'];?>"
                  class="w3-hide <?php if($catsearch==$sscat['cat_ID']){echo 'w3-show'; }?>">
                <div class="accordeon">

                <!-- on ajoute la sscat de toute les sscat -->
                <?php
                  // on construit le lien en fonction des autres param GET déjà présent
                  $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>$sscat['cat_ID'], 'sscatsearch'=>0)));
                ?>
                <a href="<?php echo $getURL;?>"
                  class="w3-block souscategorie-title tout <?php if($catsearch==$sscat['cat_ID'] and $sscatsearch==0){echo 'selected'; }?>">
                  Tout dans <?php echo $sscat['cat_nom']; ?>
                </a>

              <?php
              }
            }
            ?>

            <?php
            if(array_key_exists($sscat['ID'],$sousCategorieArray)){
            ?>
              <!-- ajoute une souscategorie comme lien -->
              <?php
                // on construit le lien en fonction des autres param GET déjà présent
                $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>$sscat['cat_ID'], 'sscatsearch'=>$sscat['ID'])));
              ?>
              <a href="<?php echo $getURL;?>"
                class="w3-block souscategorie-title <?php if($sscatsearch==$sscat['ID']){echo 'selected'; }?>">
                <?php
                  echo $sscat['nom'];
                  echo '<span class="categorie-count">(' . $sousCategorieArray[$sscat['ID']] . ')</span>';
                ?>
              </a>

            <?php
            }
          }
          // ferme le dernier accordeon des sscat associées
          echo '</div>';
          echo '</div>';
        }
      ?>

      <script>
      function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " open";
        } else {
          x.className = x.className.replace(" w3-show", "");
          x.previousElementSibling.className = x.previousElementSibling.className.replace(" open", "");
        }
      }
      </script>

    </div>
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

        //execute the request
        $req->execute();

        if ($req->rowCount() > 0) {
          while($item = $req->fetch()){

            //affichage de l'item
            include('item.php');
          }
        }
        else {
          echo '<h3 class="w3-container">Aucun résultat ne correspond à la recherche</h3>';
        }
        ?>

      </div>
    </div>

  </div>

</body>

</html>
