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
if (isset($_POST['cat'])) {
    include 'add.php';
    console_log("include de add.php");
} ?>

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

<div class="col s1"></div>


          <canvas id="hidden_streaming_canvas" class="invisible"></canvas>
          <canvas id="hidden_snap_canvas" class="invisible"></canvas>
          <canvas id="hidden_rotate_canvas" class="invisible"></canvas>
<div id="cam_col" class="col s10 m10 l10 center-align">


                  <div class="streaming_container">
                  <canvas id="video_streaming" autoplay class="video_streaming invisible"></canvas>
                  </div>

                  <video id="video" autoplay class="invisible"></video>


            <canvas id="snap_final" class="invisible"></canvas>
<label for="file" style>
                  <div id="file_upload_container" style="display:inline-block; margin:20px 0 20px 0;">


                          <div id="bords_file_upload" style="position:absolute; cursor: pointer;"><svg viewBox="0 0 100 100" width="100px" style="width:100px;">
                            <path d="M25,2 L2,2 L2,25" fill="none" stroke="#9e9e9e" stroke-width="3" />
                            <path d="M2,75 L2,98 L25,98" fill="none" stroke="#9e9e9e" stroke-width="3" />
                            <path d="M75,98 L98,98 L98,75" fill="none" stroke="#9e9e9e" stroke-width="3" />
                            <path d="M98,25 L98,2 L75,2" fill="none" stroke="#9e9e9e" stroke-width="3" />
                          </svg></div>

                          <div  id="upload-file-default" title="Prendre un cliché / Uploader une photo" class="cam_btn_default" style="width:100px; height:100px; cursor:pointer"><i class="material-icons photo-controls" style="font-size: 64px !important; line-height: 100px !important;">camera_alt</i>   </div>
                        </label>
                        <input id="file" type="file" accept="image/*" capture class="invisible">
                  </div>

</div>

<div class="col s1 pull-s1 " id="cam_controls">
    <div class="row"></div>
    <div class="row"></div>
    <div class="row"></div>

    <div class="invisible center" id="video_streaming_controls">
      <div class="row center"><div  id="take-photo" title="Prendre un cliché" class="btn-floating btn-large waves-effect"><i class="fas fa-camera"></i></div></div>
      <div class="row center invisible" id="camera_settings_row"><div  id="camera_settings" title="Paramètre camera" class="btn-floating camera_settings waves-effect" onclick="return expand('champs_getusermedia', 'camera_settings_row', 'down');"><i class="fas fa-cog"></i></div></div>
    </div>
</div>



      </div>
  </div>





</div>


<div class="quasi-fullwidth" style="background-color:white">


<div style="" class="scrolling-wrapper">
  <!--Attention, petite complexité : le menu déroulant combine deux types de composants Materialize (activés par javascript): un composant Tabs, et un composant Dropdown. Du coup j'ai du ruser avec des boutons invisibles tout en bas de index.php (oui c'est un peu du bricolage... :p)-->
  <!--Les tabs reprenant les différentes catégories de matériaux -->

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


      while ($cat = $req->fetch()) {
          echo '<a class=\'dropdown-trigger btn-flat waves-effect white-text\' href=\'#'.$cat['ID'].'\'data-target=\'select-'.$cat['ID']."' onclick= \"set_active('.dropdown-trigger', this); this.classList.add('active'); set_value('nom_categorie','".$cat['nom']."'); set_value('id_categorie','".$cat['ID']."'); set_value('nom_souscategorie',''); set_value('id_souscategorie','');expand('categorisation','', 'down')\"".'\'>'.$cat['nom'].'</a>';
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

        //  echo '</ul>';
               ?>
             </ul>

</div>








      <div class="container no-select" id="formulaire" style="background-color:white">
          <!-- Les onglets avec les catégories de matériaux-->


              <!-- Début du formulaire-->
              <form name="formulaire_encodage" id="formulaire_encodage" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="post" novalidate>


                <div id="categorisation" class ="row invisible" >
                   <div class="col s5 m5 input-field">
                     <input id="nom_categorie" name="cat" type="text" required readonly>
                     <input id="id_categorie" name="cat" type="text" readonly hidden>

                   </div>

                   <div class="col s1 input-field center-align">
                      <p>></p>
                   </div>

                   <div class="col s5 m6 input-field">
                     <input id="nom_souscategorie" name="souscat" type="text" required readonly>
                    <input id="id_souscategorie" name="souscat" type="text" readonly hidden>
                   </div>

                 </div>



                 <div id="row_tags" class ="row flex-input-field" >

                    <div class="col s12 flex-input-field">
                      <div id="label_bricole" class="row nomargin nopadding" style="margin-left: 3rem !important;">
                      <label for="tags">Tags: (séparés par ' , ' ou ' . ')</label>
                    </div>
                      <i class="fas fa-tags prefix"></i>
                      <input class="invisible" id="input-tags" name="tags" type="text">

                    </div>

                  </div>

    <?php if (isset($_GET["camdetails"])) {
                   echo "<div class='row input-field' id='champs_getusermedia'>";
               } else {
                   echo "<div class='row input-field invisible' id='champs_getusermedia'>";
               }
        ?>
<div class="col s6 m6 input-field"><select id="videoSelect" class="browser-default" onchange="document.querySelector('#rearcameraID').value=this.value; setConstraints();
PlayVideo();"></select>
</div>
<div class="col s6 m6 input-field"><input type="text" id="rearcameraID" disabled></div></div>


        <div id="row_pieces" class ="row input-field" >

          <div class="input-field col s2" style="width:55px !important; ">
            <i class="fas fa-cube prefix"></i>
          </div>
          <div class="input-field col s8 nopadding" >

            <div class="inline-group">
            <div id="minus_btn" class="btn plusminus eztouch-left" onclick="Increment('pieces', -1, 1);"><span class="no-select">-</span></div>

              <input type="number" id="pieces" name="pieces" value="1" min="1" step="1" onClick="this.select();" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateNonEmpty(this.id, 1)" style="text-align: center; width:45px; ">

              <div id="plus_btn" class="btn plusminus eztouch-right"  onclick="Increment('pieces', 1, 1);"><span class="no-select">+</span></div>


              <p class="couleur3-text no-select">pièce(s)</p>
              </div>
          </div>
        </div>

        <div id="row_poids" class="row input-field">

            <div class="input-field col s9 l8" id="range_div" >
              <i class="fas fa-weight-hanging prefix"></i>
            <!--  <input type="range" id="poids" min="0.1" max="2.9" value="1.0" step="0.1" name="poids" oninput="set_range_value('indicateur_poids', this.value);" /> -->
              <div id="poids" class="input-field" style="touch-action: none" overflow-scroll="false" style="margin-left:3rem !important;"></div>
            </div>

            <div class="input-field col s2">
            <input type="number" id="indicateur_poids" name="poids" value="1" min="1" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value;" style="inline; text-align: center; ">
            </div>
            <div class="input-field col s1">
              <p class="no-select">kg</p>
            </div>

        </div>



            <div id="row_etat" class ="row input-field">
                  <div class="input-field col s3 m2">
                    <i class="fas fa-heart-broken prefix"></i>
                    <label for="range_etat" class="couleur3-text">Etat:</label>
                </div>

             <div class="input-field col s9 m5 no-select" id="etat_coeurs" style="max-height:53px; white-space: nowrap;">

              <div class="rating" style="display:inline-block;">
<span id="heart1" class="checked" onclick="checkhearts(1); set_value('etat',1)" ontouchstart="checkhearts(1); set_value('etat',1)"><i class="fas fa-heart"></i></span><span id="heart2"                 onclick="checkhearts(2); set_value('etat',2)" ontouchstart="checkhearts(2); set_value('etat',2)"><i class="fas fa-heart"></i></span><span id="heart3"                 onclick="checkhearts(3); set_value('etat',3)" ontouchstart="checkhearts(3); set_value('etat',3)"><i class="fas fa-heart"></i></span><span id="heart4"                 onclick="checkhearts(4); set_value('etat',4)" ontouchstart="checkhearts(4); set_value('etat',4)"><i class="fas fa-heart"></i></span>
</div>
<input type="number" name="etat" id="etat" value="1" class="invisible">


            </div>

           </div>

           <div id="row_prix" class ="row input-field" >
              <div class="input-field col s4 m3">
                <i class="fas fa-coins prefix"></i>
                <input id="prix" name="prix" type="number" value="0" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value" style="text-align: center">
                <label for="prix">Prix</label>
              </div>

          </div>



  <div id="plusdedetails" class="row">
    <div class="col s12">
      <div class="" style="margin-top: 1rem;"><a href="" onclick="return expand('champs_facultatifs', 'plusdedetails', 'down');" style="color: #6f6972;"><i class="fas fa-plus-circle separator-label prefix"></i>&nbsp;Plus de détails</a></div>

    </div>
  </div>


<div id="champs_facultatifs" class="invisible">
  <div class="row">
  <div class="input-field col s12 m6">
    <i class="fas fa-info-circle prefix"></i>
    <input id="remarques" name="remarques" type="text">
    <label for="remarques">Ajouter des remarques :</label>
  </div>
  <div class="input-field col s12 m6">
    <i class="fas fa-ruler prefix"></i>
    <input id="dimensions" name="dimensions" type="text">
    <label for="dimensions">Dimensions précises :</label>
  </div>
</div>
    <div class="row">
      <div class="input-field col s5 m3">

            <label>
                <input type="checkbox" name="externe" class="filled-in" onchange="check_expand_hide(this, 'champ-localisation', 'champ-localisation', 'right');"/>
                <span>Hors les murs?</span>
              </label>

      </div>
      <div id="champ-localisation" class="input-field col s7 m9 invisible">
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


    <!-- Alors ci-dessous ça peut paraitre bizarre, mais il s'agit d'une série de boutons (invisibles) que j'utilise pour faire s'afficher le menu déroulant correctement. L'origine de la difficulté est que je combine deux composants Materialize, les Tabs https://materializecss.com/tabs.html et les Dropdown https://materializecss.com/dropdown.html . Il y a sûrement un moyen plus simple de produire le même effet... :p -->
    <div >



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
var Formats = {'0.1':'0.1', '1':'1','1.0':'1','1.9':'10','2':'11','2.0':'11', '2.9':'20'};
var pipFormats = {'0':'0.1','1':'0.2','2':'0.3','3':'0.4','4':'0.5','1':'1','1':'1','1':'1'};
    var slider = document.getElementById('poids');

    noUiSlider.create(slider, {
     start: [1],
     connect: true,
     step: 0.10,
     stepped: true,
     orientation: 'horizontal', // 'horizontal' or 'vertical'
     range: {
       'min': 0.1,
       'max': 2.9
     },


     pips: {
       stepped: true,
       format: {
           to: function(a){  a=  Math.round(a * 10) / 10; console.log("valeur: "+a+", format: "+ Formats[a]); return Formats[a];},
         },
        mode: 'values',
                values: [0.1, 1, 1.9, 2.9],
                density: 3.5
            }




/*
     pips: {
       mode: 'count',
       values: 6,
        stepped: true,
        format: {
            to: function(a){ return pipFormats[a]; },
          }
      } */
    });

    slider.noUiSlider.on('update', function( values, handle ) {
       var valeur = slider.noUiSlider.get();

      // console.log(valeur);

       if (valeur > 1) {


             valeur = ((valeur - 1) * 10 + 1);


           }

             valeur=  Math.round(valeur * 10) / 10;

       document.getElementById('indicateur_poids').value= valeur;

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
