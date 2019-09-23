
<!-- ouvre le menu -->
<div id="categories" class="menu">

  <?php
    //----- construire le menu en parcourant l'arbre

    //on construit l'url get en fonction des param déjà présent
    $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>0, 'sscatsearch'=>0)));
  ?>

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
        foreach ($catData['sscats'] as $sscatID => $sscatNom) {

          //si la souscategorie est presente dans le compteur
          if(array_key_exists($sscatID,$sscat_counter)){

            //declare une sscategorie
            //on construit l'url get en fonction des param déjà présent
            $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>$catID, 'sscatsearch'=>$sscatID)));
            ?>
            <a href="<?php echo $getURL;?>"
              class="w3-block souscategorie-title <?php if($sscatsearch==$sscatID){echo 'selected'; }?>">
              <?php
                echo $sscatNom;
                echo '<span class="categorie-count">(' . $sscat_counter[$sscatID] . ')</span>';
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
