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
echo $id;
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


<div style="" class="scrolling-wrapper invisible">



  <?php
  //connection database
  try {
    //  $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'webappdev', 'datarecoulechemindejerusalem', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  } catch (Exception $e) {
      die('Erreur : '.$e->getMessage());
  }


    //prep the request
    //every line is a souscategorie
    $req = $bdd->prepare('  SELECT `nom`, `ID` FROM `categorie` ORDER BY `categorie`.`ID`
                        ');
    //execute the request
    $req->execute();

     // displaying buttons with the categories of materials
      while ($cat = $req->fetch()) {
          echo '<a id=\'dropdown_cat'.$cat['ID'].'\' class=\'dropdown-trigger btn-flat waves-effect white-text\' href=\'#'.$cat['ID'].'\'data-target=\'select-'.$cat['ID']."' onclick= \"set_active('.dropdown-trigger', this.id); this.classList.add('active'); set_value('nom_categorie','".$cat['nom']."'); set_value('id_categorie','".$cat['ID']."'); set_value('nom_souscategorie',''); set_value('id_souscategorie','');expand('categorisation','', 'down')\"".'\'>'.$cat['nom'].'</a>';
      }


        ?>
        <?php
              // Ici les sous-catégories de matériaux qui s'affichent des les menus déroulants-->

              $req = $bdd->prepare('  SELECT `ID`, `nom`, `ID_categorie` FROM `souscategorie` ORDER BY `souscategorie`.`ID_categorie`
                                  ');
              //execute the request
              $req->execute();

              $souscategories = $req->fetchAll();


        $current_cat=1;
        echo "<ul id='select-".$souscategories[0]['ID_categorie']."' class='dropdown-content'>";

        for ($row = 0; $row < sizeof($souscategories); $row++) {
            if ($souscategories[$row]['ID_categorie'] == $current_cat) {
                echo "<li><a href='#".$souscategories[$row]['ID']."' ontouchstart= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."')\" onclick= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."')\">".$souscategories[$row]['nom']."</a></li>";
            } else {
                echo '</ul>';
                echo "<ul id='select-".$souscategories[$row]['ID_categorie']."' class='dropdown-content'>";
                echo "<li><a href='#".$souscategories[$row]['ID']."' ontouchstart= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."')\" onclick= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."')\">".$souscategories[$row]['nom']."</a></li>";
                $current_cat++;
            }
        }
               ?>
             </ul>

</div>








      <div class="container no-select" id="formulaire" style="background-color:white">
          <!-- Les onglets avec les catégories de matériaux-->


              <!-- Début du formulaire-->
              <form name="formulaire_encodage" id="formulaire_encodage" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="post" novalidate>


                <div id="categorisation" class ="row " >
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
                       <input id="tags" name="tags" type="text" value="<?php echo $item['tags'];?>">
                       <label for="tags">Tags</label>
                     </div>

                  </div>


        <div id="row_pieces" class ="row input-field" >

          <div class="input-field col s2" style="width:55px !important; ">
            <i id='prefix_pieces' class="fas fa-cube prefix"></i>
          </div>
          <div class="input-field col s8 nopadding" >

            <div class="inline-group" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
            <div id="minus_btn" class="btn plusminus eztouch-left" onclick="Increment('pieces', -1, 1);"><span class="no-select">-</span></div>

              <input type="number" id="pieces" name="pieces" value="<?php echo $item['pieces'];?>" min="1" step="1" onClick="this.select();" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateNonEmpty(this.id, 1)" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" style="text-align: center; width:45px; ">

              <div id="plus_btn" class="btn plusminus eztouch-right"  onclick="Increment('pieces', 1, 1);"><span class="no-select">+</span></div>


              <p class="couleur3-text no-select">pièce(s)</p>
              </div>
          </div>
        </div>

        <div id="row_poids" class="row input-field">

            <div class="input-field col s4 m3">
              <i id="prefix_poids" class="fas fa-weight-hanging prefix"></i>
              <label for="indicateur_poids" class="couleur3-text">Poids:</label>
            <input type="number" id="indicateur_poids" name="poids" value="<?php echo $item['poids'];?>" min="1" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value; update_slider('slider_poids',this.value, this);" style="inline; text-align: center; ">
            <span id="" class="postfix">kg</span>
            </div>
            <div class="input-field col s8 m9" id="range_div" >

              <div id="slider_poids" class="input-field" overflow-scroll="false" onfocus="set_active('', 'prefix_poids')" onblur="set_inactive('prefix_poids')" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></div>
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
                <input id="prix" name="prix" type="number" value="<?php echo $item['prix'];?>"onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value" style="text-align: center">
                <label for="prix">Prix</label>
              </div>

          </div>







<div id="champs_facultatifs" class="">
  <div class="row">
  <div class="input-field col s12">
    <i class="fas fa-info-circle prefix"></i>
    <input id="remarques" name="remarques" value="<?php if (isset($item['remarques'])) {echo $item['remarques'];} else {echo "Pas de remarques";}?>" type="text">
    <label for="remarques">Remarques :</label>
  </div>
  <div class="input-field col s12">
    <i class="fas fa-ruler prefix"></i>
    <input id="dimensions" name="dimensions" type="text" value="<?php if (isset($item['dimensions'])) {echo $item['dimensions'];} else {echo "Pas dispo";}?>">
    <label for="dimensions">Dimensions précises :</label>
  </div>
</div>
    <div class="row">
      <div id="champ-localisation" class="input-field col s7 m9">
        <i class="fas fa-map-marked-alt prefix"></i>
        <input id="localisation" name="localisation" type="text">
        <label for="localisation">Localisation:</label>
      </div>

    </div>
</div>
<div class="row"></div>


            <div class="row hide-on-small-only">
        			<div class="col s12">
        			 <a class="waves-effect waves-light btn-small green accent-3 right" value="submit" onclick="expand('loading_overlay'); Soumettre('formulaire_encodage');" >
                 <i class="material-icons">thumb_up_alt</i>
                 Encoder
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
      <a class="btn-floating btn-large green accent-3" name="submit" value="submit" onclick="expand('loading_overlay'); Soumettre('formulaire_encodage'); ">
        <i class="material-icons">thumb_up_alt</i>
      </a>

  </form>



</main>

<?php include 'footer.php';

/*Message de succès ou d'échec du formulaire, si $_POST['cat'] est défini*/
if (isset($_POST['cat'])) {
    if ($add_result == 'success') {
        echo "<script>M.toast({html:\"L'objet ". $object_id ." a bien été ajouté à la base de données\"})</script>";
    } else {
        echo $add_result;
    }
}
?>
  <script type="text/javascript" src="js/adapter.js"></script> <!-- polyfill pour améliorer la compatibilité de WebRTC (getUserMedia) entre browsers -->


<!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/add_form.js"></script>
<script type="text/javascript" src="nouislider/nouislider.js"></script>


  <!-- On active le composant Tabs -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var el;
    var instance = M.Tabs.init(el, {swipeable : true});
  });
</script>

<script>

    var slider_poids = document.getElementById('slider_poids');


            noUiSlider.create(slider_poids, {
                start: [1],
                range: {
                    'min': [0.1, 0.1],
                    '30%': [1,1],
                    'max': [10]
                },
                pips: {
                        mode: 'steps',
                        density: 3.5,
                        stepped:true
                      }
            });




    slider_poids.noUiSlider.on('update', function( values, handle ) {
       var valeur = slider_poids.noUiSlider.get();

             valeur=  Math.round(valeur * 10) / 10;

       document.getElementById('indicateur_poids').value= valeur;

       });
    slider_poids.noUiSlider.on('start', function( values, handle ) {
      set_active('','prefix_poids');
       });
    slider_poids.noUiSlider.on('end', function( values, handle ) {
       slider_poids.focus(); //to keep prefix active until blur
       });




  </script>



</body>

<?php


//fonction pour  supprimer tous les caractères spéciaux pour pouvoir utiliser des noms de matériaux stockés dans la bdd comme ids d'éléments html
function abbrev($string)
{
    $result1 = str_replace(array( '\'', '"', ',' , ';', '<', '>','-','_','(',')','[',']', ' '), '', $string);
    return str_replace(array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $result1);
}


//DEV fonction pour logger les erreurs PHP dans la console
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
