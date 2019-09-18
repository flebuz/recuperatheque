<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<?php $thisPage="add_form"; ?>
<head>
  <title>Webapp Recupérathèque - Encoder un objet</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"> <!-- zoom désactivé pour éviter les zoom intempestifs sur mobile (aussi : , target-densitydpi=device-dpi)-->
  <meta name="theme-color" content="">

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/add_form.css">




  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!--Nécessaire pour les icônes des boutons du widget vidéo et bouton Soumettre-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!--<link rel="stylesheet" href="extras/noUiSlider/nouislider.css">-->
  <link rel="stylesheet" href="nouislider/nouislider.css">

  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
  <!--Import materialize.css-->

<!-- Ajout du formulaire précédent à la base de donnée si $_POST['cat'] est défini-->
<?php
if (!$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
echo "Erreur, pas d'objet sélectionné";
}
else {
      try {
        //  $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'webappdev', 'datarecoulechemindejerusalem', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
          $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      } catch (Exception $e) {
          die('Erreur : '.$e->getMessage());
      }

      //prep the request
      //every line is a souscategorie
      $req = $bdd->prepare('  SELECT
                              c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags, c.prix AS prix, c.poids AS poids, c.remarques AS remarques, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
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


}

?>

</head>

<body class="disable-dbl-tap-zoom">

<?php include 'header.php'; ?>

<main>
  <div id="loading_overlay" class="overlay invisible">


    <!-- Overlay content -->
    <div class="overlay-content">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

  </div>


  <div class="container" id="cam_container">
    <div class="row nomargin">

<div id="cam_col" class="col s12 center-align">

<img class="thumbnail" src="/photos/<?php echo $id ?>.jpg" style="max-width:400px;"></img>

<!-- IMAGE ICI -->

</div>



      </div>
  </div>



<div class="quasi-fullwidth" style="background-color:white">



      <div class="container no-select" id="formulaire" style="background-color:white">


          <!-- Début du formulaire-->
          <form name="formulaire_encodage" id="formulaire_encodage" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="post" novalidate>


                <div id="row_categorisation" class ="row " >
                   <div class="col s5 m5 input-field">
                     <input id="nom_categorie" class="input_categ" name="cat" type="text" value="<?php echo $item['categorie'];?>" required readonly>
                     <input id="id_categorie"  name="cat" type="text"  value="<?php echo $item['ID_categorie'];?>" readonly hidden>

                   </div>

                   <div class="col s1 input-field center-align">
                      <p>></p>
                   </div>

                   <div class="col s5 m6 input-field">
                     <input id="nom_souscategorie" class="input_categ" name="souscat" type="text" value="<?php echo $item['sous_categorie'];?>" required readonly>
                    <input id="id_souscategorie" name="souscat" type="text" value="<?php echo $item['ID_souscategorie'];?>"  readonly hidden>
                   </div>

                 </div>



                  <div id="row_tags" class ="row input-field" >
                     <div class="input-field col s12">
                       <i class="fas fa-tag prefix"></i>
                       <input id="tags" name="tags" type="text" value="<?php echo $item['tags'];?>" readonly>
                       <label for="tags">Tags</label>
                     </div>

                  </div>


                  <div id="row_pieces" class ="row input-field" >

                    <div class="input-field col s6" >

                      <div class="inline-group" >
                          <i id='prefix_pieces' class="fas fa-cube prefix"></i>
                          <input type="number" id="pieces" name="pieces" value="<?php echo $item['pieces'];?>" readonly style="text-align: center; width:45px; ">
                        <span class="couleur3-text no-select postfix">pièce(s)</span>
                        </div>
                    </div>

                      <div class="input-field col s4">
                        <i id="prefix_poids" class="fas fa-weight-hanging prefix"></i>
                        <label for="indicateur_poids" class="couleur3-text">Poids:</label>
                      <input type="number" id="indicateur_poids" name="poids" value="<?php echo $item['poids'];?>" readonly style="inline; text-align: center; ">
                      <span id="" class="postfix">kg</span>
                      </div>

                  </div>



                  <div id="row_etat" class ="row input-field">
                        <div class="input-field col s3 m2">
                          <i id="prefix_rating" class="fas fa-heart-broken prefix"></i>
                          <label for="range_etat" class="couleur3-text">Etat:</label>
                      </div>

                      <div class="input-field col s9 m5 no-select" id="etat_coeurs" style="max-height:53px; white-space: nowrap;">

                      <div class="rating" style="display:inline-block;" onfocus="set_active('', 'prefix_rating')" onblur="set_inactive('prefix_rating')" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                          <span id="heart1" class="checked" onclick="checkhearts(1); set_value('etat',1)" ontouchstart="checkhearts(1); set_value('etat',1)"><i class="fas fa-heart"></i></span><span id="heart2"                 onclick="checkhearts(2); set_value('etat',2)" ontouchstart="checkhearts(2); set_value('etat',2)"><i class="fas fa-heart"></i></span><span id="heart3"                 onclick="checkhearts(3); set_value('etat',3)" ontouchstart="checkhearts(3); set_value('etat',3)"><i class="fas fa-heart"></i></span><span id="heart4"                 onclick="checkhearts(4); set_value('etat',4)" ontouchstart="checkhearts(4); set_value('etat',4)"><i class="fas fa-heart"></i></span>
                          </div>
                          <input type="number" name="etat" id="etat" value="1" class="invisible">


                      </div>

                 </div>

                 <div id="row_prix" class ="row input-field" >
                    <div class="input-field col s4 m3">
                      <i class="fas fa-coins prefix"></i>
                      <input id="prix" name="prix" type="number" value="<?php echo $item['prix'];?>" readonly style="text-align: center">
                      <label for="prix">Prix</label>
                    </div>

                </div>







              <div id="champs_facultatifs" class="">
                <div class="row">
                <div class="input-field col s12">
                  <i class="fas fa-info-circle prefix"></i>
                  <textarea id="remarques" name="remarques" value="<?php if (isset($item['remarques'])) {echo $item['remarques'];} else {echo "Pas de remarques";}?>" type="text" onchange="console.log('ajustement du textarea');this.style.height = (this.scrollHeight)+'px';" readonly><?php if (isset($item['remarques'])) {echo $item['remarques'];} else {echo "Pas de remarques";}?></textarea>
                  <label for="remarques">Remarques :</label>
                </div>
                <div class="input-field col s12">
                  <i class="fas fa-ruler prefix"></i>
                  <input id="dimensions" name="dimensions" type="text" value="<?php if (isset($item['dimensions'])) {echo $item['dimensions'];} else {echo "Pas dispo";}?>" readonly>
                  <label for="dimensions">Dimensions précises :</label>
                </div>
              </div>
                  <div class="row">
                    <div id="champ-localisation" class="input-field col s7 m9">
                      <i class="fas fa-map-marked-alt prefix"></i>
                      <input id="localisation" name="localisation" type="text" readonly>
                      <label for="localisation">Localisation:</label>
                    </div>

                  </div>
              </div>
              <div class="row"></div>


            <div class="row hide-on-small-only">
              <div class='col s6'></div>

        			<div class="col s3">
        			 <a class="waves-effect waves-light btn-small green accent-3 " value="submit" onclick="expand('loading_overlay'); " >
                 <i class="fas fa-exchange-alt"></i>
                 Vendre
               </a>
             </div>
        			<div class="col s3">
        			 <a class="waves-effect waves-light btn-small grey accent-3" value="edit" onclick="expand('loading_overlay'); " >
                 <i class="fas fa-edit"></i>
                 Modifier
               </a>
        			<!-- <a class="waves-effect waves-light btn-small " onclick="download_img(this)" >
                 <i class="material-icons"></i>
                 Télécharger
               </a> -->
        			</div>
              <!-- https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation -->

            </div>

            <div class="row invisible"><input id="image_final" name="image_final" type="text"></div>
            <div class="row"></div>




		</div>
</div>

</div>



    <div class="fixed-action-btn hide-on-med-and-up">
      <a class="btn-floating btn-large green accent-3" name="submit" value="submit" onclick="expand('loading_overlay'); ">
        <i class="fas fa-exchange-alt"></i>
      </a>
    <div class="fixed-action-btn hide-on-med-and-up">
      <a class="btn-floating btn-large green accent-3" name="edit" value="edit" onclick="expand('loading_overlay'); ">
        <i class="fas fa-edit"></i>
      </a>

  </form>



</main>

<?php include 'footer.php'; ?>

<script type="text/javascript" src="js/forms.js"></script>
<!--
<script type="text/javascript" src="js/add_form.js"></script>  -->



  <!-- On active le composant Tabs -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

    var remarques = document.getElementById("remarques"),
    remarques_height = remarques.scrollHeight +0;
    remarques.style.height = (remarques_height)+'px';
    console.log('ajustement du textarea : '+ remarques_height);
  });
</script>



</body>

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

</html>
