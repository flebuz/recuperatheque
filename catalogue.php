
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Webapp Recupérathèque</title>

  <meta charset="utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- import the css -->
  <!-- to have w3css class and respponsive design -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
  <link rel="stylesheet" href="css/w3.css">
  <!-- to have icon of the font awesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- la typo JOST -->
  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
  <!-- custom css -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/item.css">

  <link rel="manifest" href="manifest.json">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-title" content="Mycélium">


</head>

<body>


  <?php
  // Prevent caching on the catalogue to make sure it is always up-to-date
  // TO DO : Check if there is a less aggressive way to do it
  header("Cache-Control: max-age=0");

  ?>

  <?php
    include('connection_db.php')
  ?>

  <?php
    //----- check le $_GET de recuperatheque est valide -----

    //reprendre la liste des (pseudos vers les) recuperatheques
    $req = $bdd->prepare(' SELECT pseudo FROM _global_recuperatheques ');
    $req->execute();
    $recuperatheques = array();
    while($item = $req->fetch()){
      array_push($recuperatheques,$item['pseudo']);
    }

    //checker si le parametre est set et est dans la liste
    if (isset($_GET['r']) && in_array($_GET['r'], $recuperatheques)){
      $recuperatheque = htmlspecialchars($_GET['r']);
      $recuperatheque_catalogue = htmlspecialchars($_GET['r']) . '_catalogue';
    } else{
      $recuperatheque = null;
    }
    //---> si pas le cas, alors rien afficher!
  ?>

  <?php
    //----- construction de l'objet $system ----
    //-> résume la structure de catégorie-sscat-comptage de la recuperatheque
    if($recuperatheque){
      include('categories_system.php');
    }
  ?>

  <?php
    //----- Check la validité des autres parametres $_GET

      //check si l'option de recherche est valide
    if (isset($_GET['q'])){
      $query = htmlspecialchars($_GET['q']);
    } else{
      $query = null;
    }

    $tri_option = array('date_ajout' => 'Date de récupération',
                        'prix' => 'Prix par pièce',
                        'etat' => 'État d\'usure',
                        'pieces' => 'Pièces disponibles');

      //check si l'option de tri est parmis les choix valide
    if (isset($_GET['order']) && array_key_exists($_GET['order'], $tri_option)){
      $tri = htmlspecialchars($_GET['order']);
    } else{
      $tri = 'date_ajout';
    }
      //check si l'option categorie et sscat est valide (les cat existe et la sscat correspond a la cat)
    if(isset($_GET['catsearch']) and $_GET['catsearch']!=0
    and array_key_exists($_GET['catsearch'], $system)){
      $catsearch = htmlspecialchars($_GET['catsearch']);
    } else{
      $catsearch = null;
    }

    if(isset($_GET['sscatsearch']) and $_GET['sscatsearch']!=0
      and array_key_exists($_GET['sscatsearch'], $system[$catsearch]['sscats'])){
      $sscatsearch = htmlspecialchars($_GET['sscatsearch']);
    } else{
      $sscatsearch = null;
    }

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
      $page = (int) htmlspecialchars($_GET['page']);
    } else{
      $page = 1;
    }
  ?>

  <?php
    include('header.php');
  ?>

  <div class="quasi-fullwidth space-header two-side-flex">

      <?php
      if($recuperatheque){?>

        <!-- Bar de recherche -->
        <div class="flex-third">

          <?php
            //on recupere tt les info de la bonne recuperatheque
            $req = $bdd->prepare(' SELECT * FROM _global_recuperatheques WHERE pseudo = :recuperatheque ');
            $req->bindValue(':recuperatheque', $recuperatheque , PDO::PARAM_STR);
            $req->execute();
            $recup_info = $req->fetch();

            //on print l'info box
            include("recuperatheque_info.php");
          ?>

          <form class="container search-bar" action="catalogue.php" method="GET">

            <input type="text" class="search-bar-input" name="q" placeholder="Recherche..." value="<?php echo $query?>">
            <button class="w3-large fa fa-search search-bar-button" type="submit"></button>

            <?php
              // on ajoute les autre param
              echo '<input type="hidden" name="r" value="' . $recuperatheque . '"/>';

              if($catsearch){
                echo '<input type="hidden" name="catsearch" value="' . $catsearch . '"/>';
              }
              if($sscatsearch){
                echo '<input type="hidden" name="sscatsearch" value="' . $sscatsearch . '"/>';
              }
              if($tri){
                echo '<input type="hidden" name="order" value="' . $tri . '"/>';
              }
            ?>

          </form>

          <div class="menu-container" id="menu-container">
            <div class="menu-bar">
              <button id="cat-button" class="button-flex menu-button separation" onclick="openMenu(event,'categories')">
                <div class="button-title">Catégories</div>
                <i class='button-icon w3-large fas fa-folder'></i>
              </button>
              <button id="tri-button" class="button-flex menu-button" onclick="openMenu(event,'tri')">
                <div class="button-title">Tri</div>
                <i class='button-icon w3-large fas fa-sort'></i>
              </button>
            </div>

            <?php include('categories_menu.php'); ?>

          </div>

        </div>

        <!-- search request -->
        <div class="flex-half">
          <?php

            $limit= 12; //items par pages
            $starting_limit = ($page-1)*$limit;

            //--- requete qui compte juste les elements de la recherche
            $req = $bdd->prepare('  SELECT COUNT(*) AS total
            FROM ' . $recuperatheque_catalogue . ' c
            INNER JOIN _global_categories cat ON c.ID_categorie=cat.ID
            INNER JOIN _global_souscategories sscat ON c.ID_souscategorie=sscat.ID
            WHERE (cat.nom LIKE :search OR sscat.nom LIKE :search OR dimensions LIKE :search OR tags LIKE :search OR remarques LIKE :search)
            AND (c.ID_souscategorie = :sscatsearch OR :sscatsearch is null)
            AND (c.ID_categorie = :catsearch OR :catsearch is null)
            ');

            //complete parametric values (note: column names are not values, and thus must be hardcoded into the query)
            $req->bindValue(':search', '%' . $query . '%', PDO::PARAM_STR);
            $req->bindValue(':sscatsearch', $sscatsearch, PDO::PARAM_INT);
            $req->bindValue(':catsearch', $catsearch, PDO::PARAM_INT);

            $req->execute();
            $total_count = $req->fetch()['total'];

            //--- requete qui sort les elements de la recherche, trier, et sequencer en page
            //every lines is an item with joined categorie and subcategorie
            $req = $bdd->prepare('  SELECT
            c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags,
            c.prix AS prix, c.poids AS poids, c.remarques AS remarques, c.localisation AS localisation,
            c.date_ajout AS date_ajout, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
            cat.ID, cat.nom AS categorie,
            sscat.ID AS sscatID, sscat.ID_categorie, sscat.unite AS unitesscat, sscat.prix AS prixsscat, sscat.nom AS sous_categorie
            FROM ' . $recuperatheque_catalogue . ' c
            INNER JOIN _global_categories cat ON c.ID_categorie=cat.ID
            INNER JOIN _global_souscategories sscat ON c.ID_souscategorie=sscat.ID
            WHERE (cat.nom LIKE :search OR sscat.nom LIKE :search OR dimensions LIKE :search OR tags LIKE :search OR remarques LIKE :search)
            AND (c.ID_souscategorie = :sscatsearch OR :sscatsearch is null)
            AND (c.ID_categorie = :catsearch OR :catsearch is null)
            ORDER BY ' . $tri . ' DESC
            LIMIT ' . $starting_limit . ', ' . $limit
            );

            //complete parametric values (note: column names are not values, and thus must be hardcoded into the query)
            $req->bindValue(':search', '%' . $query . '%', PDO::PARAM_STR);
            $req->bindValue(':sscatsearch', $sscatsearch, PDO::PARAM_INT);
            $req->bindValue(':catsearch', $catsearch, PDO::PARAM_INT);

            $req->execute();
          ?>

          <!-- search resume -->
          <div class="container border-bottom search-resume-wrapper">
            <div class="search-resume">

              <?php

              echo '<b>' . $recup_info['pseudo'] . ' </b>';

                if($query != '' || $catsearch != 0){
                  //si une des deux condition est respacter on affiche le resumer

                  if($query != ''){
                    ?>
                      <a href=" <?php echo link_construct(array('q'=>null)) ?> ">
                        <?php echo $query ?>
                      </a>
                    <?php
                  }
                  if($sscatsearch != 0){
                    if($query != ''){ echo ' dans '; }
                    ?>
                      <a href=" <?php echo link_construct(array('sscatsearch'=>null,'catsearch'=>null)) ?> ">
                        <?php echo $system[$catsearch]['sscats'][$sscatsearch] . ' (' . $system[$catsearch]['nom'] . ')' ?>
                      </a>
                    <?php
                  }
                  elseif($catsearch != 0){
                    if($query != ''){ echo ' dans '; }
                    ?>
                      <a href=" <?php echo link_construct(array('sscatsearch'=>null,'catsearch'=>null)) ?> ">
                        <?php echo $system[$catsearch]['nom'] ?>
                      </a>
                    <?php
                  }
                }
                echo ' (' . $total_count . ' résultats)';
              ?>
            </div>
          </div>

          <!-- items container -->
          <div class="items-container">

            <?php
              if ($req->rowCount() > 0) {
                while($item = $req->fetch()){

                  //affichage de l'item
                  ?>

                  <div class="item-wrapper">
                      <?php include('item.php');?>
                  </div>

                  <?php
                }
              }
              else {
                echo '<h3 class="erreur"> Aucun résultat ne correspond à la recherche </h3>';
              }
            ?>

          </div>

          <!-- page nav -->
          <div class="container border-top page-nav">

            <a href= <?php echo link_construct(array('page'=>$page-1)) ?>
               class="<?php if($page-1 <= 0){ echo 'disabled'; } ?>">
               <i class='fas fa-chevron-left'></i>
            </a>

            <?php echo $page; ?>

            <a href= <?php echo link_construct(array('page'=>$page+1)) ?>
               class="<?php if(($page)*$limit >= $total_count){ echo 'disabled'; } ?>">
               <i class='fas fa-chevron-right'></i>
            </a>

          </div>

        </div>

        <?php
      }
      else {
        echo '<h3 class="erreur"> Pas de récupérathèque valide </h3>';
      }
      ?>

    </div>
  </div>

  <?php

  //TEMPORAIRE fonction pour logger des messages PHP dans la console via console.log() en JS
    function console_log($output, $with_script_tags = true)
    {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
  ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }
  ?>

  <script>
    if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
    navigator.serviceWorker.register('service-worker.js').then(function(registration) {
    // Registration was successful
    console.log('Service worker successfully registered on scope', registration.scope);
    }, function(err) {
    // registration failed :(
    console.log('ServiceWorker registration failed: ', err);
    }).catch(function(err) {
    console.log(err);
    });
    });
    } else {
    console.log('service worker is not supported');
    }
    </script>

</body>

</html>
