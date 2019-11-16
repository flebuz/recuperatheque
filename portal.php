
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

  <div class="quasi-fullwidth space-header">

    <div class="container border-bottom">
      <p>
        Une <b>Récupérathèque</b> est un magasin collaboratif de matériaux de réemploi
        au sein d’une école de création (arts, architecture, design, stylisme, arts de la scène, etc)
        fonctionnant avec sa propre monnaie ou son propre système d’échange,
        et visant à favoriser la durabilité, la solidarité, et la création de lien social.
      </p>
      <p>
        Le <b>Mycélium</b>, est l'appareil végétatif des champignons,
        composé d'un ensemble de filaments plus ou moins ramifiés,
        formant un réseaux souterrains entre les champignons et des plantes extérieures. </br>

        Ces réseaux interspécifiques favorisent les transferts de nutriments,
        notamment de la part de celui qui est en condition favorable (lumière, milieu nutritif)
        et qui encourage la croissance de celui en condition défavorable.
        Ce lien souterrain entre espèces différentes est vital dans le fonctionnement d'un écosystème.
      </p>
    </div>

    <?php
      //--- listage des recupérathèques
      $req = $bdd->prepare(' SELECT * FROM recuperatheques ');
      $req->execute();

      while($recup_info = $req->fetch()){

        $url = "catalogue.php";
        $url = $url . "?r=" . $recup_info['pseudo'];

        echo "<a class='border-bottom' href=". $url . ">";
        include("recuperatheque_info.php");
        echo '</a>';

      }
    ?>

  </div>

</body>

</html>
