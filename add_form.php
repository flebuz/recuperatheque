<!DOCTYPE html>
<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<?php
// Prevent caching on this page to make sure it is always up-to-date
// TO DO : Check if there is a less aggressive way to do it
// header("Cache-Control: max-age=0");

?>

<head>

  <title>Mycélium : L'app des Recupérathèques - Encoder un objet</title>
  <meta charset='utf-8'>

  <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"> <!-- zoom désactivé pour éviter les zoom intempestifs sur mobile (aussi : , target-densitydpi=device-dpi)-->


  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/add_form.css">
  <meta name="theme-color" content="#303030"><!-- Chrome -->



  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
  <!--<link rel="stylesheet" href="extras/noUiSlider/nouislider.css">-->
  <link rel="stylesheet" href="nouislider/nouislider.min.css">
  <!-- la typo JOST -->
  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />

  <!--Import materialize.css-->


  <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/tags-input.css"  media="screen,projection"/>

<!-- Ajout du formulaire précédent à la base de donnée si $_POST['cat'] est défini-->
<?php
  include('connection_db.php');
?>



</head>

<body class="disable-dbl-tap-zoom">

  <?php
    include('header.php');

    if(isset($_SESSION['pseudo'])){
            $recuperatheque = $_SESSION['pseudo'];
            $recuperatheque_catalogue = $recuperatheque . '_catalogue';
            $recuperatheque_journal = $recuperatheque . '_journal';
    }
    ?>

    <?php
    if (isset($_POST['cat'])) {
        include 'add.php';
        console_log("include de add.php");
    } ?>

    <?php
    //----- construction de l'objet $system ----
    //-> résume la structure de catégorie-sscat-comptage de la recuperatheque
  //  if($recuperatheque){
  //    include('categories_system.php');
  //  }
  ?>




<main class="space-header">
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

<div id="cam_col" class="col s10 m10 l10 center-align">


                  <div class="streaming_container">
                  <canvas id="video_streaming" autoplay class="video_streaming invisible"></canvas>
                  </div>

                  <video id="video" autoplay class="invisible"></video>



<label for="file_upload" style="text-align:center">

    <canvas id="snap_final" class="invisible"></canvas>

                  <div id="file_upload_container" style="display:inline-block; margin:20px 0 20px 0;">

                          <div id="bords_file_upload" style="position:absolute; cursor: pointer;"><svg viewBox="0 0 100 100" width="100px" style="width:100px;">
                            <path d="M25,2 L2,2 L2,25" fill="none" stroke="#9e9e9e" stroke-width="3" />
                            <path d="M2,75 L2,98 L25,98" fill="none" stroke="#9e9e9e" stroke-width="3" />
                            <path d="M75,98 L98,98 L98,75" fill="none" stroke="#9e9e9e" stroke-width="3" />
                            <path d="M98,25 L98,2 L75,2" fill="none" stroke="#9e9e9e" stroke-width="3" />
                          </svg></div>

                          <div  id="upload-file-default" title="Prendre un cliché / Uploader une photo" class="cam_btn_default" style="width:100px; height:100px; cursor:pointer"><i class="fas fa-camera" style="font-size: 64px !important; line-height: 100px !important;"></i>  </div>
                          <div id="spinner_imagesnap" class="lds-spinner color-grey invisible"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                        </label>
                        <input id="file_upload" type="file" accept="image/*" capture="environment" class="invisible">
                  </div>

</div>

    <div class="col s1 pull-s1 a" id="cam_controls">
        <div class="row"></div>
        <div class="row"></div>
        <div class="row"></div>

          <div class="invisible center" id="video_streaming_controls">
            <div class="row center"><div  id="take-photo" title="Prendre un cliché" class="btn-floating btn-large waves-effect"><i class="fas fa-camera"></i></div></div>

          </div>
    </div>



  </div>
</div>






<div class="quasi-fullwidth" style="background-color:white">


<div style="" class="scrolling-wrapper">



  <?php
    //prep the request
    //every line is a souscategorie
    $req = $bdd->prepare('  SELECT `nom`, `ID` FROM `_global_categories` ORDER BY `_global_categories`.`score` DESC
                        ');
    //execute the request
    $req->execute();

     // displaying buttons with the categories of materials
      while ($cat = $req->fetch()) {
          echo '<a id=\'dropdown_cat'.$cat['ID'].'\' class=\'dropdown-trigger btn-flat waves-effect white-text btn-cat\' href=\'#'.$cat['ID'].'\'data-target=\'select-'.$cat['ID']."' onclick= \"update_cat(this.id,".$cat['ID'].",'".$cat['nom']."');\"".'\'>'.$cat['nom'].'</a>';
      }


        ?>
        <?php
              // Here we prepare to fetch subcategories that display in the dropdown menus
              $req = $bdd->prepare('  SELECT `ID`, `nom`, `ID_categorie`, `unite`, `prix` FROM `_global_souscategories` ORDER BY `_global_souscategories`.`ID_categorie`
                                  ');
              //execute the request
              $req->execute();

              $souscategories = $req->fetchAll();


        $current_cat=1;
        echo "<ul id='select-".$souscategories[0]['ID_categorie']."' class='dropdown-content'>";

        for ($row = 0; $row < sizeof($souscategories); $row++) {
            if ($souscategories[$row]['ID_categorie'] == $current_cat) {
                echo "<li><a href='#".$souscategories[$row]['ID']."' ontouchstart= \"update_subcat('".$souscategories[$row]['ID']."','".$souscategories[$row]['nom']."','".$souscategories[$row]['prix']."','".$souscategories[$row]['unite']."');\" onclick= \"update_subcat('".$souscategories[$row]['ID']."','".$souscategories[$row]['nom']."','".$souscategories[$row]['prix']."','".$souscategories[$row]['unite']."');\">".$souscategories[$row]['nom']."</a></li>";
            } else {
                echo '</ul>';
                echo "<ul id='select-".$souscategories[$row]['ID_categorie']."' class='dropdown-content'>";
                echo "<li><a href='#".$souscategories[$row]['ID']."' ontouchstart= \"update_subcat('".$souscategories[$row]['ID']."','".$souscategories[$row]['nom']."','".$souscategories[$row]['prix']."','".$souscategories[$row]['unite']."');\" onclick= \"update_subcat('".$souscategories[$row]['ID']."','".$souscategories[$row]['nom']."','".$souscategories[$row]['prix']."','".$souscategories[$row]['unite']."');\">".$souscategories[$row]['nom']."</a></li>";
                $current_cat++;
            }
        }
               ?>
             </ul>

</div>



      <div class="container no-select" id="formulaire" style="background-color:white">

              <!-- Début du formulaire-->
              <form name="formulaire_encodage" id="formulaire_encodage" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"  method="post" novalidate>


                <div id="categorisation" class ="row invisible" >
                   <div class="col s5 m5 input-field">
                     <input id="nom_categorie" class="input_categ" name="cat" type="text" required readonly>
                     <input id="id_categorie"  name="cat" type="text" readonly hidden>

                   </div>

                   <div class="col s1 input-field center-align">
                      <p>></p>
                   </div>

                   <div class="col s5 m6 input-field">
                     <input id="nom_souscategorie" class="input_categ" name="souscat" type="text" required readonly>
                    <input id="id_souscategorie" name="souscat" type="text" readonly hidden>

                    <input type="text" id="has_weight" name="has_weight" value="1" readonly hidden>

                   </div>

                 </div>



    <div class='row input-field invisible' id='champs_getusermedia'>
          <div class="col s6 m6 input-field"><select id="videoSelect" class="browser-default" onchange="document.querySelector('#rearcameraID').value=this.value; setConstraints();
          PlayVideo();"></select>
          </div>
          <div class="col s6 m6 input-field"><input type="text" id="rearcameraID" disabled></div>
    </div>


    <div id="row_pieces" class ="row input-field" >

          <div class="input-field col s2" style="width:55px !important; ">
            <i id='prefix_pieces' class="fas fa-cube prefix"></i>
          </div>
          <div class="input-field col s8 nopadding" >

            <div class="inline-group" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
            <div id="minus_btn" class="btn plusminus eztouch-left"><span class="no-select">-</span></div>

              <input type="number" id="pieces" name="pieces" value="1" min="1" step="1"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateNonEmpty(this.id, 1)" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" style="text-align: center; width:45px; ">

              <div id="plus_btn" class="btn plusminus eztouch-right"><span class="no-select">+</span></div>

              <p class="couleur3-text no-select">pièce(s)</p>
            </div>
          </div>
    </div>

        <div id="row_poids" class="row input-field">
          <div class="input-field col s4 m3">
            <i id="prefix_poids" class="fas fa-weight-hanging prefix"></i>
            <label for="indicateur_poids" class="couleur3-text">Poids&nbsp;/&nbsp;pc</label>
            <input type="text" id="indicateur_poids" name="poids" value="1" min="1"  style="inline; text-align:center;">
            <span id="" class="postfix">kg</span>
          </div>
          <div class="input-field col s8 m9" id="range_div" >
              <div id="slider_poids" class="input-field" overflow-scroll="false" onfocus="set_active('', 'prefix_poids')" onblur="set_inactive('prefix_poids')" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
              </div>
          </div>
        </div>


            <div id="row_etat" class ="row input-field">
                <div class="input-field col s3 m2">
                    <i id="prefix_rating" class="fas fa-heart-broken prefix"></i>
                    <label for="range_etat" class="couleur3-text">Etat:</label>
                </div>

               <div class="input-field col s9 m5 no-select" id="etat_coeurs" style="max-height:53px; white-space: nowrap;">

                  <div class="rating" style="display:inline-block;" onfocus="set_active('', 'prefix_rating')" onblur="set_inactive('prefix_rating')" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                      <span id="heart1" class="checked"><i class="fas fa-heart"></i></span>
                      <span id="heart2">                <i class="fas fa-heart"></i></span>
                      <span id="heart3">                <i class="fas fa-heart"></i></span>
                      <span id="heart4">                <i class="fas fa-heart"></i></span>
                      <input class="invisible" type="number" name="etat" id="etat" value="1">
                  </div>
                </div>

           </div>

           <div id="row_prix" class ="row input-field" >
              <div class="input-field col s4 m3">
                <i class="fas fa-coins prefix"></i>
                <input id="prix" name="prix" type="number" value="0" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value" style="text-align: center">
                <input id="price_per_kg" name="rate" type="number" value="0" readonly hidden>
                <label for="prix">Prix&nbsp;/&nbsp;pc</label>
              </div>
          </div>

          <div id="row_tags" class ="row flex-input-field" >

             <div class="col s12 flex-input-field">
               <div id="label_bricole" class="row nomargin nopadding" style="margin-left: 3rem !important;">
               <label for="tags">Tags: (séparés par ' , ' ou ' . ')</label>
             </div>
               <i id="prefix_tags" class="fas fa-tag prefix"></i>
               <div onfocus="set_active('', 'prefix_tags');"
                    onblur="set_inactive('prefix_tags');"
                    tabindex="-1"
                    style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">

                    <input
                     class="invisible" id="input-tags" name="tags" type="text"
                     onfocus="set_active('','prefix_tags');" onblur="set_inactive('prefix_tags');">
               </div>

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
    <div class="row input-field">
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

            <div class="row invisible" id="hidden_inputs">
              <input id="image_final" name="image_final" type="text"></div> <!-- hidden input where the blob of the image will be stored -->
            <div class="row"></div>

		</div>

</div>

<div class="quasi-fullwidth">
<div class="row hide-on-small-only">
  <div class="col s12">
   <a id="submit_mobile" class="waves-effect waves-light btn-small green accent-3 right" value="" onclick="" >
     <i class="fa fa-paper-plane"></i>
     Encoder
   </a>
  </div>

</div>
</div>


  <div class="fixed-action-btn hide-on-med-and-up">
      <a id="submit_desktop" class="btn-floating btn-large green accent-3" name="" value="" onclick="">
        <i class="fa fa-paper-plane"></i>
      </a>
  </div>

  </form>


</main>


<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/tags-input.js"></script>


<!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/add_form.js"></script>
<script type="text/javascript" src="nouislider/nouislider.min.js"></script>


<?php

/*Message de succès ou d'échec du formulaire, si $_POST['cat'] est défini*/
if (isset($_POST['cat'])) {
    if ($result == 'success') {
        echo "<script>M.toast({html:\"L'objet ". $last_id ." a bien été encodé. <a class='btn-flat toast-action' href=item_page.php?r=". $recuperatheque ."&id=". $last_id .">Voir l'objet</a>\"})</script>";
    } else {
        echo $result;
    }
}
?>

  <!-- Initializeing Materialize components -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

document.getElementById('submit_mobile').addEventListener("click", SubmitForm);
document.getElementById('submit_desktop').addEventListener("click", SubmitForm);
document.getElementById('heart1').addEventListener("click", function(){update_hearts(1)});
document.getElementById('heart2').addEventListener("click", function(){update_hearts(2)});
document.getElementById('heart3').addEventListener("click", function(){update_hearts(3)});
document.getElementById('heart4').addEventListener("click", function(){update_hearts(4)});
document.getElementById('heart1').addEventListener("touchend", function(){update_hearts(1)});
document.getElementById('heart2').addEventListener("touchend", function(){update_hearts(2)});
document.getElementById('heart3').addEventListener("touchend", function(){update_hearts(3)});
document.getElementById('heart4').addEventListener("touchend", function(){update_hearts(4)});
document.getElementById('minus_btn').addEventListener("click", function(){Increment('pieces', -1, 1);});
document.getElementById('plus_btn').addEventListener("click",  function(){Increment('pieces', 1, 1);});
document.getElementById('indicateur_poids').addEventListener("click",  function(){this.select();});
document.getElementById('indicateur_poids').addEventListener("keypress",  function(){return ValidateNumKeyPress(event);});
document.getElementById('indicateur_poids').addEventListener("focus",  function(){this.oldvalue = this.value;});
document.getElementById('indicateur_poids').addEventListener("change",  function(){ValidateNumber(this); this.oldvalue = this.value; update_slider('slider_poids',this.value, this); compute_price('prix','price_per_kg', 'indicateur_poids', 'etat');});


document.getElementById('prix').addEventListener("click",  function(){this.select();});
document.getElementById('pieces').addEventListener("click",  function(){this.select();});

/*
var nodes = document.querySelectorAll("[type=text]");
for (var i=0; i<nodes.length; i++)
  {
    console.log(nodes[i]);
    nodes[i].addEventListener("click", function() {this.select();}  );
  }
*/
//onClick="this.select();"
init_materialize();
init_nouislider();

  });

function SubmitForm()
{
  const mandatory_fields = [ 'image_final', 'id_categorie', 'id_souscategorie' ];
  const fields_visible_name = [ "une photo de l'objet", "une catégorie", "une sous-catégorie" ];
  var error_msg;
  var isOnline = window.navigator.onLine;

  if (error_msg= ValidateForm(mandatory_fields, fields_visible_name))
        {
        M.toast({html: "Formulaire incomplet !"});
        M.toast({html: error_msg });
        console.log("Erreur : formulaire incomplet"+ error_msg);
        return 0;
        }

  else if (isOnline == false)
        {
            M.toast({html: "Pas de connexion ! Veuillez vous connectez avant d'ajouter l'objet."});
        }

  else {
         //the form is validated and we're online, so we can submit it
          window.setTimeout( function() {
              M.toast({html: "Connexion lente, veuillez patienter..."});
          }, 5000 ); // show a Toast after 5 sec to warn of slightly slow loading
          window.setTimeout( function() {
              M.toast({html: "Pfiou ! Encore un peu de patience..."});
          }, 12000 ); // show a Toast after 12 sec to warn of really slow loading
          window.setTimeout( function() {
              M.toast({html: "La connexion semble anormalement longue :'( <a id='stop_submit' class='btn-flat toast-action' onclick='stopsubmit();''>Interrompre</a>"});
          }, 25000 ); // show a Toast after 25 sec to warn of *anormaly slow* loading and allow user to cancel form submission

          expand('loading_overlay'); //show loading overlay to prevent clicking
          Soumettre('formulaire_encodage'); // submit form
       }
}

function stopsubmit()
{
  event.preventDefault();
  hide('loading_overlay'); //hide loading overlay to prevent clicking
  window.history.back();
   M.Toast.dismissAll();
}



function init_materialize() {

    /* Script requis par Materialize pour activer le composant Dropdown*/
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instance = M.Dropdown.init(elems, {
      coverTrigger: false,
      constrainWidth: false,
      outDuration: 250,
      inDuration: 0
    });

    var elems2 = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(elems2);

  }


function init_nouislider()
{
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
      compute_price('prix','price_per_kg', 'indicateur_poids', 'etat');
       });
    slider_poids.noUiSlider.on('start', function( values, handle ) {
      set_active('','prefix_poids');
       });
    slider_poids.noUiSlider.on('end', function( values, handle ) {
       slider_poids.focus(); //to keep prefix active until blur
       });

}


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
