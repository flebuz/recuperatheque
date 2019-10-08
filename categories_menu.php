
<!-- ouvre le menu -->
<div id="categories" class="menu">

  <?php
    //----- construire le menu en parcourant l'arbre

    //on construit l'url get en fonction des param déjà présent
    $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>0, 'sscatsearch'=>0)));
  ?>

  <a href="<?php echo $getURL;?>"
    class="categorie-title tout">
    Afficher toutes les catégories
  </a>

  <?php
    //pour chaque ID de categorie
    foreach ($system as $catID => $catData) {

      //si la categorie est presente dans le compteur
      if(array_key_exists($catID,$cat_counter)){ ?>

        <!-- declare l'accordeon d'une categorie -->
        <a onclick="openCat('<?php echo $catID; ?>')"
          class="categorie-title <?php if($catsearch==$catID){echo 'selected active'; }?>">
          <?php
            echo $catData['nom'];
            echo '<span class="categorie-count">(' . $cat_counter[$catID] . ')</span>';
          ?>
        </a>

        <!-- ouvre l'accordeon des sscat associées -->
        <div id="<?php echo $catID;?>"
          class="accordeon <?php if($catsearch==$catID){echo 'active'; }?>">

        <!-- on ajoute la sscat de toute les sscat -->
        <?php
          //on construit l'url get en fonction des param déjà présent
          $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>$catID, 'sscatsearch'=>0)));
        ?>
        <a href="<?php echo $getURL;?>"
          class="souscategorie-title tout <?php if($catsearch==$catID and $sscatsearch==0){echo 'selected'; }?>">
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
              class="souscategorie-title <?php if($sscatsearch==$sscatID){echo 'selected'; }?>">
              <?php
                echo $sscatNom;
                echo '<span class="categorie-count">(' . $sscat_counter[$sscatID] . ')</span>';
              ?>
            </a>
            <?php
          }
        }

        //on ferme l'accordeon
        echo '</div>';
      }
    }
  ?>

</div>

  <script>

    // js to open and close the menus and submenu with animation

    function openCat(id) {
      var x = document.getElementById(id);
      var menu = document.getElementById('categories');
      if (!x.clientHeight) {
        // on ouvre l'accordeon
        x.style.height = x.scrollHeight+'px';
        x.previousElementSibling.className += " active";
      } else {
        x.style.height = 0;
        x.previousElementSibling.className = x.previousElementSibling.className.replace(" active", "");
      }
    }

    function openMenu(evt,menuName){
      //on anime la height du menu
      var menu = document.getElementById(menuName);
      var button = evt.currentTarget;

      // si le menu est celui ouvert on le ferme juste
      if (menu.clientHeight){
        menu.style.transition = '0.3s';
        desactive(menu,button);
      }
      else{
        // on regarde si ya qq chose d'ouvert
        var menus = document.getElementsByClassName("menu");
        var isSomethingOpen = false;
        for (var i = 0; i < menus.length; i++){
          if (menus[i].classList.contains('active')){
            isSomethingOpen = true;
          }
        }

        if(isSomethingOpen){
          // on ferme tt les autres
          var menus = document.getElementsByClassName("menu");
          for (var i = 0; i < menus.length; i++) {
            menus[i].style.transition = '0s';
            menus[i].style.height = 0;
            menus[i].className = menus[i].className.replace(" active", "");
          }
          var titles = document.getElementsByClassName("menu-button");
          for (var i = 0; i < titles.length; i++) {
            titles[i].className = titles[i].className.replace(" active", "");
          }
          // on ouvre sans transition
          menu.style.transition = '0s'
          active(menu, button);
        }
        else{
          // on doit juste ouvrir le menu
          menu.style.transition = '0.3s'
          active(menu, button);
        }
      }
    }

    function active(menu, button){

      menu.style.height = menu.scrollHeight + "px";
      setTimeout(function(){menu.style.height='initial';},200);

      menu.className += " active";
      button.className += " active";

      //ajoute 12px a la marge du container
      document.getElementById('menu-container').style.marginBottom = '12px';
      //enleve la seperation
      document.getElementById("cat-button").className = document.getElementById("cat-button").className.replace(" separation", "");
    }

    function desactive(menu,button){

      menu.style.height = menu.scrollHeight + "px";
      setTimeout(function(){menu.style.height=null;},0);

      menu.className = menu.className.replace(" active", "");
      button.className = button.className.replace(" active", "");

      document.getElementById('menu-container').style.marginBottom = '0px';
      document.getElementById("cat-button").className += " separation";
    }
  </script>
