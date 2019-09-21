
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
  <!-- custom css -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/item.css">


</head>

<body>

  <?php
    include('header2.php');
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

  <!-- Bar de recherche - formulaire -->
  <div class="search-bar-container">
    <form class="search-bar" action="catalogue.php" method="GET">

      <input type="text" class="w3-input search-bar-input" name="q" placeholder="Ajouter un mot clé à la recherche" value="<?php echo $query?>">
      <button class="w3-xlarge fa fa-search search-bar-button" type="submit"></button>

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
  </div>

  <div class="w3-row">

    <div class="w3-col s12 m3 l3">

      <!-- menu categorie et tri -->
      <div class="w3-row menu-bar">
        <button id="cat-button" class="w3-col s6 menu-title separation" onclick="openMenu(event,'categories')">Catégories
          <span class='w3-medium fas fa-plus menu-icon'></span>
        </button>
        <button id="tri-button" class="w3-col s6 menu-title" onclick="openMenu(event,'tri')">Tri
          <span class='w3-medium fas fa-sort menu-icon'></span>
        </button>
      </div>

      <?php include('categories_menu.php'); ?>
      <?php include('tri_menu.php'); ?>

      <script>
        function openMenu(evt,menuName) {

          var menu = document.getElementById(menuName);

          // si il est déjà ouvert on le close
          if (menu.style.display == "block"){
            menu.style.display = "none";
            evt.currentTarget.className = evt.currentTarget.className.replace(" menu-open", "");
            document.getElementById("cat-button").className += " separation";
          }
          else{
            // on ferme tt les autres
            var menus = document.getElementsByClassName("menu");
            for (var i = 0; i < menus.length; i++) {
              menus[i].style.display = "none";
            }
            // on reset la couleur des titles
            var titles = document.getElementsByClassName("menu-title");
            for (var i = 0; i < titles.length; i++) {
              titles[i].className = titles[i].className.replace(" menu-open", "");
              titles[i].className = titles[i].className.replace(" separation", "");
            }
            //on enlève la séparation
            // document.getElementById("cat-button").className.replace(" separation", "");
            //on ouvre le selectionner
            menu.style.display = "block";
            evt.currentTarget.className += " menu-open";
          }
        }
      </script>

    </div>

    <div class="w3-col s12 m9 l9">

      <!-- search resume -->
      <?php
        if($query != '' || $catsearch != 0){
          //si une des deux condition est respacter on affiche le resumer
          echo '<div class="search-resume">';

          if($query != ''){
            echo '"' . $query . '"';
          }
          if($sscatsearch != 0){
            if($query != ''){ echo ' dans '; }
            //convertit l'ID en nom
            echo $system[$catsearch]['sscats'][$sscatsearch] . ' (' . $system[$catsearch]['nom'] . ') ';
          }
          elseif($catsearch != 0){
            if($query != ''){ echo ' dans '; }
            //convertit l'ID en nom
            echo $system[$catsearch]['nom'];
          }

          echo '<br/>trier par '. mb_strtolower($tri_option[$tri]);
          echo '<br/><a class="fas fa-times" href=catalogue.php></a>';
          echo '</div>';
        }
      ?>

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
