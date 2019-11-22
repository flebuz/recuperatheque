
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Mycélium : L'app des Recupérathèques</title>

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
  <link rel="stylesheet" href="css/add_form.css">
  <meta name="theme-color" content="#00E676">

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

  <!-- verifier la validité de l'id -->
  <?php
    if (isset($_GET['id'])){
      $id = htmlspecialchars($_GET['id']);
    } else{
      $id = 0;
    }
  ?>

  <?php
  include('header.php');
  ?>

  <div class="quasi-fullwidth space-header">

    <?php

      if($recuperatheque){

        //on recupere tt les info de la bonne recuperatheque
        $req = $bdd->prepare(' SELECT * FROM _global_recuperatheques WHERE pseudo = :recuperatheque ');
        $req->bindValue(':recuperatheque', $recuperatheque , PDO::PARAM_STR);
        $req->execute();
        $recup_info = $req->fetch();

        //on recupere la monnaie pour la suite
        $monnaie = $item['monnaie'];

        //on print l'info box
        include("recuperatheque_info.php");
    ?>

    <div class="container border-bottom back-link-container">

      <a onclick="back_link()" ><i class="fas fa-chevron-left"></i> retour à la recherche </a>

      <script>
        function back_link(){
          if(document.referrer.includes("catalogue.php")){
            document.location.href = document.referrer;
          }
          else{
            document.location.href = 'catalogue.php?r=<?php echo $recuperatheque ?>';
          }
        }
      </script>

    </div>

    <div class="item-single-container">

      <?php
        //get the item
        $req = $bdd->prepare('  SELECT
                                c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags, c.prix AS prix, c.poids AS poids, c.remarques AS remarques, c.localisation AS localisation,
                                c.date_ajout AS date_ajout, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
                                cat.ID, cat.nom AS categorie,
                                sscat.ID AS sscatID, sscat.ID_categorie, sscat.unite AS unitesscat, sscat.prix AS prixsscat, sscat.nom AS sous_categorie
                                FROM ' . $recuperatheque_catalogue . ' c
                                INNER JOIN _global_categories cat ON c.ID_categorie=cat.ID
                                INNER JOIN _global_souscategories sscat ON c.ID_souscategorie=sscat.ID
                                WHERE c.id=:id');

        $req->bindValue(':id', $id, PDO::PARAM_INT);
        //execute the request
        $req->execute();
      ?>

      <?php
        if ($req->rowCount() > 0) {
          $item = $req->fetch();

          include('item.php'); ?>

          <?php
        }
        else{
          echo '<h3 class="erreur"> Cet objet n\'existe pas </h3>';
          $item=0;
        }
      ?>
    </div>

    <div class="container border-top item-buttons-container">

      <button class="button-flex item-button" onclick="window.location.href = 'edit_form.php?id=<?php echo $id;?>';">
        <div class="button-title">Modifier</div>
        <i class='button-icon w3-large fas fa-edit'></i>
      </button>

      <button class="button-flex item-button" onclick="document.getElementById('modal_sell').style.display='block'">
        <div class="button-title">Vendre</div>
        <i class='button-icon w3-large fas fa-check'></i>
      </button>
    </div>

    <?php
    }
    else {
      echo '<h3 class="erreur"> Pas de récupérathèque valide </h3>';
    }
    ?>

  </div>

  <div id="modal_sell" class="w3-modal">
   <div class="w3-modal-content ">

     <header class="w3-container">
       <span onclick="document.getElementById('modal_sell').style.display='none'"
       class="w3-button w3-display-topright">&times;</span>
       <h2>Vendre un objet</h2>
     </header>

  <form name="sell_form" id="sell_form" action="sell.php"  method="post" novalidate>

  <input class="invisible" name="ID_item" id="ID_item" type="text" value="<?php echo $item['ID_item']; ?>">

       <div class="w3-container sell_form">
         <p>Quelle quantité voulez-vous vendre ?</p>
         <div id="row_pieces" class ="w3-row" >

                 <div class="w3-col s1">
                       <i id='prefix_pieces' class="fas fa-cube item-icon"></i>
                 </div>
                 <div class="w3-col s8 m3" >

                         <div class="inline-group" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                             <button type="button" id="minus_btn" class="btn plusminus eztouch-left" onclick="Increment('pieces_vendues', -1, 1, <?php echo $item['pieces'];?>); update_weight_and_price('poids_total', <?php echo $item['poids']; ?>, document.getElementById('pieces_vendues').value, 'prix_total', <?php echo $item['prix']; ?>)"><span class="no-select">-</span></button>
                             <input class="w3-input" type="number" id="pieces_vendues" name="pieces_vendues" value="1" min="1" max="<?php echo $item['pieces'];?>" step="0.1" onClick="this.select();" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateValue(this.id, 1, <?php echo $item['pieces'];?>);
                             update_weight_and_price('poids_total', <?php echo $item['poids']; ?>, this.value, 'prix_total', <?php echo $item['prix']; ?>)" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" style="text-align: center; width:45px; ">

                             <button type="button" id="plus_btn" class="btn plusminus eztouch-right"  onclick="Increment('pieces_vendues', 1, 1, <?php echo $item['pieces']; ?>); update_weight_and_price('poids_total', <?php echo $item['poids']; ?>, document.getElementById('pieces_vendues').value, 'prix_total', <?php echo $item['prix']; ?>)"><span class="no-select">+</span></button>
                             <p class="couleur3-text no-select">pièce(s)</p>
                         </div>

                     </div>
                      <div class="w3-col s2"></div>

             </div>

              <div id="row_poids" class ="w3-row" >
                    <div class="w3-col s1">
                          <i id='prefix_poids' class="fas fa-weight-hanging item-icon"></i>
                    </div>
                    <div class="w3-col s3 inline-group" >
                    <input id="poids_total" name="poids_total" class="w3-input" value="<?php echo $item['poids']; ?>">&nbsp; kg
                  </div>

           </div>

           <div id="row_prix" class ="row input-field" >

                  <div class="w3-col s1">
                    <i id='prefix_prix' class="fas fa-coins item-icon"></i>
                  </div>

                  <div class="w3-col s2 m2">
                    Prix :
                  </div>
                  <div class="w3-col s3 m3">
                    <input class="w3-input" id="prix_total" name="prix" type="number" value="<?php echo $item['prix']; ?>" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value" style="text-align: center">

                  </div>
             </div>


       <footer class="w3-container">
         <div class="w3-right">
           <button class="button-flex item-button" onclick="expand('loading_overlay'); document.forms['sell_form'].submit(); ">
             <div class="button-title">Vendre</div>
             <i class='button-icon w3-large fas fa-edit'></i>
           </button>
         </div>
       </footer>

     </form>
     </div>
   </div>
   </div>

  <script type="text/javascript" src="js/forms.js"></script>

</body>

</html>
