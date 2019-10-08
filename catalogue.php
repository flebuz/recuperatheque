
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
  <link rel="stylesheet" href="css/w3.css">
  <!-- to have icon of the font awesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- la typo JOST -->
  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
  <!-- custom css -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/menu.css">
  <link rel="stylesheet" href="css/item.css">


</head>

<body>

  <?php
    include('header.php');
  ?>

  <?php
    include('connection_db.php')
  ?>

  <?php
    //construction de l'objet $system qui résume la structure de catégorie actuelle
    include('categories_system.php');
  ?>

  <?php
    //check les $_GET de recherche si valide

      //check si l'option de recherche est valide
    if (isset($_GET['q'])){
      $query = htmlspecialchars($_GET['q']);
    } else{
      $query = '';
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
  ?>


  <div class="quasi-fullwidth space-header">
    <div class="catalogue">

    <!-- Bar de recherche -->
    <div class="flex-menu">
      <form class="search-bar" action="catalogue.php" method="GET">

        <input type="text" class="search-bar-input" name="q" placeholder="Recherche..." value="<?php echo $query?>">
        <button class="w3-large fa fa-search search-bar-button" type="submit"></button>

        <?php
          // on ajoute cat et sscat si jamais c'est déjà préciser
          if($catsearch){
            echo '<input type="hidden" name="catsearch" value="' . $catsearch . '"/>';
          }
          if($sscatsearch){
            echo '<input type="hidden" name="sscatsearch" value="' . $sscatsearch . '"/>';
          }
        ?>

      </form>

      <!-- menu categorie et tri -->
      <div class="menu-container" id="menu-container">
        <div class="menu-bar">
          <button id="cat-button" class="button-flex menu-button separation" onclick="openMenu(event,'categories')">
            <div class="button-title">Catégories</div>
            <i class='button-icon w3-large fas fa-plus'></i>
          </button>
          <button id="tri-button" class="button-flex menu-button" onclick="openMenu(event,'tri')">
            <div class="button-title">Tri</div>
            <i class='button-icon w3-large fas fa-sort'></i>
          </button>
        </div>

        <?php include('categories_menu.php'); ?>
        <?php include('tri_menu.php'); ?>

      </div>
    </div>


      <!-- search request -->
    <div class="flex-items">
      <?php
        //prep the request
        //every lines is an item with joined categorie and subcategorie
        $req = $bdd->prepare('  SELECT
        c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags, c.prix AS prix, c.poids AS poids, c.remarques AS remarques, c.localisation AS localisation, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
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
        $number_results = $req->rowcount();
      ?>

      <!-- search resume -->
      <div class="search-resume-wrapper">
        <div class="search-resume">
      <?php
        if($query != '' || $catsearch != 0){
          //si une des deux condition est respacter on affiche le resumer

          if($query != ''){
            $getURL = '?' . http_build_query(array_merge($_GET, array('q'=>'')));
            echo '<a href="' . $getURL . '">"' . $query . '"</a>';
          }
          if($sscatsearch != 0){
            if($query != ''){ echo ' dans '; }
            //convertit l'ID en nom
            $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>0, 'sscatsearch'=>0)));
            echo '<a href="' . $getURL . '">' . $system[$catsearch]['sscats'][$sscatsearch] . ' (' . $system[$catsearch]['nom'] . ')</a>';
          }
          elseif($catsearch != 0){
            if($query != ''){ echo ' dans '; }
            //convertit l'ID en nom
            $getURL = '?' . http_build_query(array_merge($_GET, array('catsearch'=>0)));
            echo '<a href="' . $getURL . '">' . $system[$catsearch]['nom'] . '</a>';
          }
        }
        echo ' (' . $number_results . ' résultats)';
      ?>
        </div>
      </div>

      <div class="w3-row items-container">

        <?php
          if ($req->rowCount() > 0) {
            while($item = $req->fetch()){

              //affichage de l'item
              ?>

              <a class="item-link" href="item_page.php?id=<?php echo $item['ID_item']?>">
                <div class='w3-col s12 m6 l4'>
                  <?php include('item.php');?>
                </div>
              </a>

              <?php
            }
          }
          else {
            echo '<h3 class="w3-container"> Aucun résultat ne correspond à la recherche </h3>';
          }
        ?>

      </div>
    </div>

    </div>
  </div>

</body>

</html>
