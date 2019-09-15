

<div class="categorie-menu">


  <?php
    //----- faire deux listes dont les clés sont les ID et les values le nb d'items

    //afin de savoir ce qu'il y a dans le catalogue
    $reqItem = $bdd->prepare('  SELECT * FROM catalogue');
    $reqItem->execute();
    $cat_counter = array();
    $sscat_counter = array();
    while($item = $reqItem->fetch()){
      if(array_key_exists($item['ID_categorie'],$cat_counter)){
        $cat_counter[$item['ID_categorie']] += 1;
      }
      else{
        $cat_counter[$item['ID_categorie']] = 1;
      }
      if(array_key_exists($item['ID_souscategorie'],$sscat_counter)){
        $sscat_counter[$item['ID_souscategorie']] += 1;
      }
      else{
        $sscat_counter[$item['ID_souscategorie']] = 1;
      }
    }
  ?>


  <?php
    //----- faire une liste de liste (arbre) qui contient les categorie et souscategorie

    //requete les sous-categories en joignant les infos de leur categorie associé
    $reqCat = $bdd->prepare('  SELECT cat.ID AS cat_ID, cat.nom AS cat_nom,
                               sscat.ID AS ID, sscat.ID_categorie, sscat.nom AS nom
                               FROM souscategorie sscat
                               INNER JOIN categorie cat ON sscat.ID_categorie=cat.ID
                               ORDER BY cat.ID, sscat.ID
                               ');
    $reqCat->execute();

    // ID cat => array( nom => nom, souscats => array())
    // liste souscat sont des: ID sscat => nom

    $system = array();
    $current_cat = '';
    //on parcour les souscategories
    while($sscat = $reqCat->fetch()){
      //si on a changé de categorie on crée une nouvelle
      if($current_cat != $sscat['cat_ID']){
        $system[$sscat['cat_ID']] = array('nom' => $sscat['cat_nom'], 'sscats' => array());
        $current_cat = $sscat['cat_ID'];
      }
      array_push($system[$sscat['cat_ID']]['sscats'], array('nom' => $sscat['nom'], 'ID' => $sscat['ID']));
    }
    //print_r($system);
  ?>


  <?php
    //----- construire le menu en parcourant l'arbre

    //on construit l'url get en fonction des param déjà présent
    $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>0, 'sscatsearch'=>0)));
  ?>

  <div class="categorie-menu-title">Categories</div>

  <a href="<?php echo $getURL;?>"
    class="w3-block categorie-title tout">
    Afficher toutes les catégories
  </a>

  <?php
    //pour chaque ID de categorie
    foreach ($system as $catID => $catData) {

      //si la categorie est presente dans le compteur
      if(array_key_exists($catID,$cat_counter)){ ?>

        <!-- declare l'accordeon d'une categorie -->
        <a onclick="myFunction('<?php echo $catID; ?>')"
          class="w3-block categorie-title <?php if($catsearch==$catID){echo 'selected open'; }?>">
          <?php
            echo $catData['nom'];
            echo '<span class="categorie-count">(' . $cat_counter[$catID] . ')</span>';
          ?>
        </a>

        <!-- ouvre l'accordeon des sscat associées -->
        <div id="<?php echo $catID;?>"
          class="w3-hide <?php if($catsearch==$catID){echo 'w3-show'; }?>">
        <div class="accordeon">

        <!-- on ajoute la sscat de toute les sscat -->
        <?php
          //on construit l'url get en fonction des param déjà présent
          $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>$catID, 'sscatsearch'=>0)));
        ?>
        <a href="<?php echo $getURL;?>"
          class="w3-block souscategorie-title tout <?php if($catsearch==$catID and $sscatsearch==0){echo 'selected'; }?>">
          Tout dans <?php echo $catData['nom']; ?>
        </a>

        <?php

        //pour toute les souscat de la cat actuelle
        foreach ($catData['sscats'] as $sscat) {

          //si la souscategorie est presente dans le compteur
          if(array_key_exists($sscat['ID'],$sscat_counter)){

            //declare une sscategorie
            //on construit l'url get en fonction des param déjà présent
            $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>$catID, 'sscatsearch'=>$sscat['ID'])));
            ?>
            <a href="<?php echo $getURL;?>"
              class="w3-block souscategorie-title <?php if($sscatsearch==$sscat['ID']){echo 'selected'; }?>">
              <?php
                echo $sscat['nom'];
                echo '<span class="categorie-count">(' . $sscat_counter[$sscat['ID']] . ')</span>';
              ?>
            </a>
            <?php
          }
        }

        //on ferme l'accordeon
        echo '</div></div>';
      }
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
