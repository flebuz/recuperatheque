
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Webapp Recupérathèque</title>

  <meta charset="utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- import the css -->
  <!-- to have w3css class and respponsive design -->
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <link rel="stylesheet" href="css/w3.css">
  <!-- to have icon of the font awesome 5 -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!-- la typo JOST -->
  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
  <!-- custom css -->
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/item.css">


</head>

<body>

  <?php
    include('header.php');
  ?>

  <?php
    include('connection_db.php')
  ?>

  <!-- verifier la validité de l'id -->
  <?php
    if (isset($_GET['id'])){
      $id = htmlspecialchars($_GET['id']);
    } else{
      $id = 0;
    }
  ?>

  <div class="quasi-fullwidth">
  <div class="item-single-container">
  <div class="item-single-content">

    <a href="javascript:history.back()" class="retour"> <i class="fas fa-chevron-left"></i> retour à la recherche</a>

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
  ?>

  <?php
    if ($req->rowCount() > 0) {
      $item = $req->fetch();

      include('item.php'); ?>

      <div class="item-buttons-container">

        <button class="item-button" onclick="window.location.href = 'https://w3docs.com';">Modifier
          <i class='w3-medium fas fa-edit'></i>
        </button>

        <button class="item-button" onclick="window.location.href = 'https://w3docs.com';">Vendre
          <i class='w3-medium fas fa-check'></i>
        </button>
      </div>

      <?php
    }
    else{
      echo '<h3 class="w3-container"> Cet objet n\'existe pas </h3>';
    }
  ?>

  </div>
  </div>
  </div>

</body>

</html>