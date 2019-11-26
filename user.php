
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
  <link rel="stylesheet" href="css/header.css">
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

      <h4 class="container">Connecté.e en tant que:</h4>

      <?php
        //on recupere tt les info de la bonne recuperatheque
        $req = $bdd->prepare(' SELECT * FROM _global_recuperatheques WHERE pseudo = :recuperatheque ');
        $req->bindValue(':recuperatheque', $_SESSION['pseudo'] , PDO::PARAM_STR);
        $req->execute();
        $recup_info = $req->fetch();

        //on print l'info box
        include("recuperatheque_info.php");
      ?>

      <div class="container">
        <button class="button-flex"
          onclick="window.location.href='deconnection.php'" >
          <div class="button-title">Deconnection</div>
        </button>
      </div>

      <hr>

      <h4 class="container">Mes Infos</h4>

      <?php
      if(isset($_GET['e'])){
        echo '<div class="container"> Mauvais mot de passe </div>';
      }
      ?>

      <div class="container">Laisser vide les champs à ne pas modifier</div>

      <form class="container" action="set_info_recup.php" method="POST">


        <div class="input-field">
          <label>Adresse: </label>
          <input type="text" name="adresse" value="<?php echo $recup_info['adresse']; ?>">
        </div>

        <div class="input-field">
          <label>Monnaie: </label>
          <input type="text" name="monnaie" value="<?php echo $recup_info['monnaie']; ?>">
        </div>

        <div class="input-field">
          <label>Telephone: </label>
          <input type="text" name="telephone" value="<?php echo $recup_info['telephone']; ?>">
        </div>

        <div class="input-field">
          <label>Site internet: </label>
          <input type="text" name="site" value="<?php echo $recup_info['site']; ?>">
        </div>

        <div class="input-field">
          <label>Mail: </label>
          <input type="mail" name="mail" value="<?php echo $recup_info['mail']; ?>">
        </div>

        <div class="input-field">
          <label>Mot de passe (ancien): </label>
          <label>* OBLIGATOIRE *</label>
          <input type="password"  name="mdp">
        </div>

        <div class="input-field">
          <label>Mot de passe (nouveau): </label>
          <input type="password"  name="mdp_new">
        </div>

        <button class="button-flex" type="submit">
          <div class="button-title">Changer mes infos</div>
        </button>

      </form>



    </div>

    <div class="flex-half">

      <h4 class="container">Historique</h4>

    </div>


  </div>

</body>

</html>
