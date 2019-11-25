
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
    include('connection_db.php')
  ?>

  <?php
    include('header.php');
  ?>

  <div class="quasi-fullwidth space-header two-side-flex">

    <div class="flex-half">

      <div class="container border-bottom">

        <h3>Une Récupérathèque</h3>
        <p>
          est un <strong>magasin collaboratif</strong> de matériaux de <strong>réemploi</strong>
          au sein d’une école de création (arts, architecture, design, stylisme, arts de la scène, etc)
          fonctionnant avec sa propre monnaie ou son propre <strong>système d’échange</strong>,
          et visant à favoriser la durabilité, la solidarité, et la création de <strong>lien social</strong>.
        </p>

        <h3>Le Mycélium</h3>
        <p>
          est l'appareil végétatif des <strong>champignons</strong>.
          Composé d'un ensemble de filaments ramifiés, il
          forme un <strong>réseau souterrain</strong> entre les champignons et les plantes.</br>

          Ces réseaux <strong>favorisent les transferts</strong> de nutriments,
          notamment de la part de celui qui est en condition favorable (lumière, milieu nutritif)
          et qui encourage la croissance de celui en condition défavorable.
          Ces liens souterrain entre espèces différentes est vital dans le fonctionnement d'un <strong>écosystème</strong>.
        </p>
      </div>

    </div>

    <div class="flex-half">
      <div class="recup-list">

        <?php
          //--- listage des recupérathèques
          $req = $bdd->prepare(' SELECT * FROM _global_recuperatheques ');
          $req->execute();

          while($recup_info = $req->fetch()){

            $url = "catalogue.php";
            $url = $url . "?r=" . $recup_info['pseudo'];?>

            <div class=" border-bottom">
              <a class="hidden-link" href="<?php echo $url; ?>">
                <span></span>
              </a>
              <?php include("recuperatheque_info.php");?>
            </div>

          <?php
          }
        ?>
      </div>
    </div>

  </div>

</body>

</html>
