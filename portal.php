
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

    <?php
      //--- listage des recupérathèques
      $req = $bdd->prepare(' SELECT * FROM recuperatheques ');
      $req->execute();

      while($item = $req->fetch()){

        $url = "catalogue.php";
        $url = $url . "?r=" . $item['raccourci'];

        echo '<a href=' . $url . '>';
        include("recuperatheque_info.php");
        echo '</a>';

      }
    ?>

  </div>

</body>

</html>
