
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

  <!-- verifier la validité de l'id -->
  <?php
    if (isset($_GET['id'])){
      $id = htmlspecialchars($_GET['id']);
    } else{
      $id = 0;
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

  <?php
    //get the item
    $req = $bdd->prepare('  SELECT
                            c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags, c.prix AS prix, c.poids AS poids, c.remarques AS remarques, c.localisation AS localisation, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
                            cat.ID, cat.nom AS categorie,
                            sscat.ID AS sscatID, sscat.ID_categorie, sscat.unite AS unitesscat, sscat.prix AS prixsscat, sscat.nom AS sous_categorie
                            FROM catalogue c
                            INNER JOIN categorie cat ON c.ID_categorie=cat.ID
                            INNER JOIN souscategorie sscat ON c.ID_souscategorie=sscat.ID
                            WHERE c.id=:id');

    $req->bindValue(':id', $id, PDO::PARAM_INT);
    //execute the request
    $req->execute();

    $item = $req->fetch();
  ?>

  <?php
    // calcul du prix
    if ($item['unitesscat']=='kg'){
      $prix = $item['prixsscat'] * $item['poids'] / $item['pieces'];
    }
    else{
      $prix = $item['prixsscat'];
    }
    $prix = $prix * ($item['etat']/4);
    //ou
    $prix = $item['prix'];

    //pluriel ou non sur le nombre de pièces
    $piece = "1 pièce";
    if ($item['pieces']>1){
      $piece = $item['pieces'] . " pièces";
    }

    //divise les tags en list php
    $tags = explode(", ",$item['tags']);

    //dimensions dispo ou non
    if ($item['dimensions']==''){
      $dimensions='non-disponibles';
    }
    else{
      $dimensions=$item['dimensions'];
    }
  ?>

  <div class='item-single-back'>
  <div class='item-single-container'>

    <div class='item'>

      <div class="item-photo-container">
          <?php
          echo '<img class="item-photo" src="photos/' . $item['ID_item'] . '.jpg" />'
          ?>
      </div>

      <div class="item-text-container">

        <div class='item-categorie-container'>
          <!-- deux choix d'affichage si la sscat est Autre ou pas -->
          <?php
          if ($item['sous_categorie']!='Autre'){
            ?>
            <span class="item-souscategorie"> <?php echo $item['sous_categorie']; ?> </span>
            <span class="item-categorie"> (<?php echo $item['categorie']; ?>) </span>
          <?php
          }
          else{
            ?>
            <span class="item-souscategorie"> <?php echo $item['categorie']; ?> </span>
          <?php
          }
          ?>

        </div>

        <div class="item-info-container">

          <div class="item-info-line">
            <i class='fas fa-coins item-icon'></i>
            <div class="item-info"><?php echo $prix; ?> par pièce </div>
          </div>

          <div class="item-info-line">
            <i class='fas fa-heart-broken item-icon'></i>
            <div class="item-info"> État:
              <span class='etat-icon-container'>
              <?php
              //echo $item['etat'];
              for($n = 0; $n < 4; $n++){
                if($item['etat'] > $n){
                  echo '<i class="fas fa-heart etat-icon"></i> ' ;
                } else{
                  echo '<i class="far fa-heart etat-icon"></i> ' ;
                }
              }
              ?>
              </span>
            </div>
          </div>

          <div class="item-info-line">
            <i class='fas fa-cubes item-icon'></i>
            <div class="item-info"><?php echo $piece; ?></div>
          </div>

        </div>

        <div class="item-info-plus-container">
          <!-- les info qui apparaissent dans la page single -->

          <!-- //si dans sa categorie il y a le poids -->
          <div class="item-info-line">
            <i class='fas fa-weight-hanging item-icon'></i>
            <div class="item-info"> <?php echo $item['poids']; ?> </div>
          </div>

          <div class="item-info-line">
            <i class='fas fa-ruler item-icon'></i>
            <div class="item-info"> <?php echo $dimensions; ?> </div>
          </div>

          <div class="item-info-line">
            <i class='fas fa-info-circle item-icon'></i>
            <div class="item-info"> <?php echo $item['remarques']; ?> </div>
          </div>

        </div>

        <div class='item-tags-container'>

          <div class="item-info-line">
            <i class='fas fa-tag item-icon'></i>
            <div class="item-info">
              <?php
                for($n = 0; $n < count($tags); $n++){
                  echo '<a class="tag" href=#>#' . $tags[$n] . '</a>';
                  if($n!=count($tags)-1){ echo ', '; }
                }
              ?>
            </div>
          </div>

        </div>

        <div class="item-date-container">

          <div class="item-info-line">
            <i class='far fa-calendar item-icon'></i>
            <div class="item-info">récupéré le <?php echo $item['date_ajout_fr']; ?></div>
          </div>

        </div>

      </div>

    </div>
  </div>
  </div>
</body>

</html>
