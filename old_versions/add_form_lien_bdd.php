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
  <!--<link rel="stylesheet" href="extras/noUiSlider/nouislider.css">-->
  <link rel="stylesheet" href="nouislider/nouislider.css">


  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!--Nécessaire pour les icônes des boutons du widget vidéo et bouton Soumettre-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">

  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
  <!--Import materialize.css-->



</head>

<body class="disable-dbl-tap-zoom">

<?php include 'header.php'; ?>

<main>

  <div class="container" id="cam_container">
    <div class="row nomargin">

<div class="col s1"></div>


          <canvas id="hidden_streaming_canvas" class="invisible"></canvas>
          <canvas id="hidden_snap_canvas" class="invisible"></canvas>
          <canvas id="hidden_rotate_canvas" class="invisible"></canvas>
<div id="cam_col" class="col s10 m10 l10 center-align">


                <div class="overlay" id="video_streaming_overlay">
                  <canvas id="video_streaming" autoplay class="invisible"></canvas></div>
                  <canvas id="snap_final" class="invisible"></canvas>
                  <video id="video" autoplay class="invisible"></video>


                  <div id="file_upload_container">
                          <label for="file">
                          <canvas id="image_final" class="invisible"></canvas>
                          <div  id="upload-file-default" title="Prendre un cliché / Uploader une photo" class="btn-floating btn-large cam_btn_default  waves-effect"><i class="material-icons photo-controls">camera_alt</i></div>
                        </label>
                        <input id="file" type="file" accept="image/*" capture class="invisible">
                  </div>

</div>

<div class="col s1 pull-s1 " id="cam_controls" style:"height:400">
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
  try{
    $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  }
  catch(Exception $e){
      die('Erreur : '.$e->getMessage());
  }


    //prep the request
    //every line is a souscategorie
    $req = $bdd->prepare('  SELECT `nom`, `ID` FROM `categorie` ORDER BY `categorie`.`ID`
                        ');
    //execute the request
    $req->execute();


      while($cat = $req->fetch()){

        echo '<a class=\'dropdown-trigger btn-flat waves-effect couleur2 white-text\' href=\'#'.$cat['ID'].'\'data-target=\'select-'.$cat['ID']."' onclick= \"set_value('categorie','".$cat['ID']."')\"".'\'>'.$cat['nom'].'</a>';
  }


        ?>
          <?php
          $categories= array('bois','métal','papier','plastique','verre','construction','textile','quincaillerie','mobilier','électronique','insolite');
          $sous_categories= array(

            'bois' => array('bois médium','bois massif','bois 3 plis','OSB'),
            'metal' => array('acier','acier galvanisé','fer à beton','aluminium', 'laiton')
          );

          // --------------------
          // REQUETE MYSQL ICI
          // remplir deux tableaux avec les catégories et les sous-catégories
          // --------------------


          //shuffle ($categories);


        /*  foreach ($categories as $key => $value) {
            echo '<a class=\'dropdown-trigger btn-flat waves-effect couleur2 white-text\' href=\'#'.abbrev($value).'\'data-target=\'select-'.abbrev($value)."' onclick= \"set_value('categorie','".abbrev($value)."')\"".'\'>'.$value.'</a>';
          }*/
          ?>

</div>




      <!-- Ici les sous-catégories de matériaux qui s'affichent des les menus déroulants-->
<?php
      $req = $bdd->prepare('  SELECT `ID`, `nom`, `ID_categorie` FROM `souscategorie` ORDER BY `souscategorie`.`ID_categorie`
                          ');
      //execute the request
      $req->execute();

      $souscategories = $req->fetchAll();

      /*
      echo '<pre>';
    print_r($souscategories);
    echo '</pre>';
*/


/*
$current_cat = 1;

echo '<table>';
for ($row = 0; $row < sizeof($souscategories); $row++) {
echo '<tr>';
if ($souscategories[$row]['ID_categorie'] == $current_cat)
    {

        echo "<td>";
        echo "IDcat: ".$souscategories[$row]['ID_categorie'];
        echo "</td>";
        echo "<td>";
        echo "nom: ".$souscategories[$row]['nom'];
        echo "</td>";
        echo "<td>";
        echo "ID: ".$souscategories[$row]['ID'];
        echo "</td>";

      }
      else {
              echo '</tr>';
              echo '<tr>';
        $current_cat++;
      }
      echo '</tr>';
}

echo '</table>';

*/
$current_cat=1;
echo "<ul id='select-".$souscategories[0]['ID_categorie']."' class='dropdown-content'>";

for ($row = 0; $row < sizeof($souscategories); $row++) {
if ($souscategories[$row]['ID_categorie'] == $current_cat)
    {
  echo "<li><a href='#".$souscategories[$row]['ID']."'>".$souscategories[$row]['nom']."</a></li>";

      }
      else {
              echo '</ul>';
              echo "<ul id='select-".$souscategories[$row]['ID_categorie']."' class='dropdown-content'>";


            $current_cat++;
      }

}

//  echo '</ul>';
       ?>
     </ul>

     <ul id="select-18" class="dropdown-content">
      <li><a href="#!">une flûte à 6 schtrompf</a></li>
      <li class="divider" tabindex="-1"></li>
      <li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
     </ul>

      <ul id="select-bois" class="dropdown-content">
    	  <li><a href="#!">bois médium</a></li>
    	  <li><a href="#!">bois massif</a></li>
    	  <li><a href="#!">bois 3 plis</a></li>
    	  <li><a href="#!">OSB</a></li>
    	  <li class="divider" tabindex="-1"></li>
    	  <li><a href="#!"><i class="material-icons">more_horiz</i>Autres bois</a></li>
      </ul>
      <ul id="select-metal" class="dropdown-content">
    	  <li><a href="#!">acier</a></li>
    	  <li><a href="#!">acier galvanisé</a></li>
    	  <li><a href="#!">fer à beton</a></li>
    	  <li><a href="#!">aluminium</a></li>
    	  <li><a href="#!">laiton</a></li>
    	  <li class="divider" tabindex="-1"></li>
    	  <li><a href="#!"><i class="material-icons">more_horiz</i>Autres métal</a></li>
      </ul>
      <ul id="select-papier" class="dropdown-content">
    	  <li><a href="#!">papier</a></li>
      	<li><a href="#!">carton</a></li>
      	<li><a href="#!">fil de reliure</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autres papetterie</a></li>
      </ul>
      <ul id="select-plastique" class="dropdown-content">
      	<li><a href="#!">plexiglas</a></li>
      	<li><a href="#!">dibon</a></li>
      	<li><a href="#!">mousse</a></li>
      	<li><a href="#!">PVC</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autres plastique</a></li>
      </ul>
      <ul id="select-verre" class="dropdown-content">
      	<li><a href="#!">plaque de verre</a></li>
      	<li><a href="#!">miroir</a></li>
      	<li><a href="#!">verre martelé</a></li>
      	<li><a href="#!">récipient</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autres verre</a></li>
      </ul>
      <ul id="select-construction" class="dropdown-content">
      	<li><a href="#!">béton</a></li>
      	<li><a href="#!">béton cellulaire</a></li>
      	<li><a href="#!">plâtre</a></li>
      	<li><a href="#!">carrelage</a></li>
      	<li><a href="#!">pierre</a></li>
      	<li><a href="#!">terre</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autres construction</a></li>
      </ul>
      <ul id="select-mobilier" class="dropdown-content">
      	<li><a href="#!">table</a></li>
      	<li><a href="#!">table a dessin</a></li>
      	<li><a href="#!">table à couture</a></li>
      	<li><a href="#!">vitrine</a></li>
      	<li><a href="#!">chevalet</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre mobilier</a></li>
      </ul>
      <ul id="select-textile" class="dropdown-content">
      	<li><a href="#!">du tissu</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
      </ul>
      <ul id="select-quincaillerie" class="dropdown-content">
      	<li><a href="#!">racagnac</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
      </ul>
      <ul id="select-electronique" class="dropdown-content">
      	<li><a href="#!">transistor</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
      </ul>
      <ul id="select-insolite" class="dropdown-content">
      	<li><a href="#!">une flûte à 6 schtrompf</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
      </ul>



      <div class="container" id="formulaire" style="background-color:white">
          <!-- Les onglets avec les catégories de matériaux-->


              <!-- Début du formulaire-->
              <form name="formulaire_encodage" id="formulaire_encodage" action="add.php" method="post" action="?">


                <input id="image_url" name="image_url" type="text" value="none" class="invisible">

                <div id="categorisation" class ="row" >
                   <div class="col s5 m3 input-field">
                     <input id="categorie" name="cat" type="text" disabled>

                   </div>

                   <div class="col s1 input-field center-align">
                      <p>></p>
                   </div>

                   <div class="col s5 m3 input-field">
                     <input id="souscategorie" name="souscat" type="text" disabled>

                   </div>

                 </div>

<div class='row' id="champs_getusermedia"><div class="col s6 m6 input-field"><select id="videoSelect" class="browser-default" onchange="document.querySelector('#rearcameraID').value=this.value; setConstraints();
PlayVideo();"></select>
</div>
<div class="col s6 m6 input-field"><input type="text" id="rearcameraID" disabled></div></div>


        <div id="row_pieces" class ="row" >

          <div class="input-field col s2 m1 ">
            <i class="fas fa-cube prefix"></i>
          </div>
          <div class="input-field col s3 m2 nopadding" style="text-align: right;" onclick="Increment('pieces', -1, 1);">

            <div id="minus_btn" class="btn plusminus waves-effect"><span class="no-select">-</span></div>
          </div>
            <div class="input-field col s2 m1">
              <input type="number" id="pieces" name="pieces" value="1" min="1" step="1" onClick="this.select();" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateNonEmpty(this.id, 1)" style="text-align: center; ">
            </div>
            <div class="input-field col s2 nopadding" onclick="Increment('pieces', 1, 1);">
              <div id="plus_btn" class="btn plusminus waves-effect no-select"><span class="no-select">+</span></div>
            </div>

            <div class="input-field col s3 m2">
              <p class="couleur3-text no-select">pièce(s)</p>
            </div>

        </div>

        <div id="row_range" class="row">

            <div class="input-field col s9 l8" id="range_div" >
              <i class="fas fa-weight-hanging prefix"></i>
              <input type="range" id="poids" min="0.1" max="10" value="1.0" step="0.1" name="poids" oninput="updateTextInput('indicateur_poids', this.value);" />
            </div>

            <div class="input-field col s2 l3 m1">
            <input type="number" id="indicateur_poids" name="poids" value="1" min="1" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value;" style="inline; text-align: center; ">
            </div>
            <div class="input-field col s1">
              <p class="no-select">kg</p>
            </div>

        </div>

        <div id="row_tags" class ="row" >
           <div class="input-field col s12">
             <i class="fas fa-tags prefix"></i>
             <input id="tags" name="tags" type="text">
             <label for="tags">Ajouter des tags :</label>
           </div>

         </div>

            <div id="row_etat" class ="row">
                  <div class="input-field col s3">
                    <i class="fas fa-heart-broken prefix"></i>
                    <label for="range_etat" class="couleur3-text">Etat:</label>
                </div>

             <div class="input-field col s7 m6 offset-s1 nopadding" id="etat" style="max-height:53px;">

<input type="range" class="browser-default" id="range_etat" name="etat" value="4"  style="z-index:30;width: 100% !important;  margin-bottom: 5px;" min="1" max="4" onupdate="ModifierBulle(etat)">

<div class="pips-container">
  <div class="noUi-pips noUi-pips-horizontal">
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 0.00000%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 0.00000%">1/4</div>
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 33.33333%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 33.33333%">2/4</div>
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 66.66667%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 66.66667%">3/4</div>
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 100.00000%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 100.00000%">4/4</div>
	</div>
</div>

            </div>

           </div>

           <div id="row_prix" class ="row" >
              <div class="input-field col s4 m2">
                <i class="fas fa-coins prefix"></i>
                <input id="prix" name="prix" type="number" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value" style="text-align: center">
                <label for="prix">Prix</label>
              </div>

              <div class="input-field col s5"><p>(par pièce)</p>
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
      <div class="input-field col s6 m3">

            <label>
                <input type="checkbox" name="externe" class="filled-in" onchange="check_expand_hide(this, 'champ-localisation', 'champ-localisation', 'right');"/>
                <span>Hors les murs?</span>
              </label>

      </div>
      <div id="champ-localisation" class="input-field col s6 m6 invisible">
        <i class="fas fa-map-marked-alt prefix"></i>
        <input id="localisation" name="localisation" type="text">
        <label for="localisation">Localisation:</label>
      </div>

    </div>
</div>
<div class="row"></div>


            <div class="row hide-on-small-only">
        			<div class="col s12">
        			 <a class="waves-effect waves-light btn-small green accent-3 right" value="submit" onclick="document.getElementById('formulaire_encodage').submit(); document.getElementById('client').reset(); " >
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

            <div class="row"></div>
            <div class="row"></div>




		</div>
</div>

</div>


    <!-- Alors ci-dessous ça peut paraitre bizarre, mais il s'agit d'une série de boutons (invisibles) que j'utilise pour faire s'afficher le menu déroulant correctement. L'origine de la difficulté est que je combine deux composants Materialize, les Tabs https://materializecss.com/tabs.html et les Dropdown https://materializecss.com/dropdown.html . Il y a sûrement un moyen plus simple de produire le même effet... :p -->
    <div >
<?php

      foreach ($categories as $key => $value) {
        echo '<a class=\'dropdown-trigger btn invisible\' href=\'#'.abbrev($value).'\' data-target=\'select-'.abbrev($value).'\'>'.$value.'</a>';
      }

      ?>

    </div>

    <div class="fixed-action-btn hide-on-med-and-up">
      <a class="btn-floating btn-large green accent-3" value="submit" onclick="document.getElementById('formulaire_encodage').submit(); document.getElementById('client').reset(); ">
        <i class="material-icons">thumb_up_alt</i>
      </a>

  </form>



</main>

<?php include 'footer.php'; ?>
  <script type="text/javascript" src="js/adapter.js"></script> <!-- polyfill pour améliorer la compatibilité de WebRTC (getUserMedia) entre browsers -->


<!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
<script type="text/javascript" src="js/forms.js"></script>
<script type="text/javascript" src="js/add_form.js"></script>



  <!-- On active le composant Tabs -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var el;
    var instance = M.Tabs.init(el, {swipeable : true});
  });
</script>

</body>

<?php
//fonction pour  supprimer tous les caractères spéciaux pour pouvoir utiliser des noms de matériaux stockés dans la bdd comme ids d'éléments html
function abbrev($string){
		$result1 = str_replace( array( '\'', '"', ',' , ';', '<', '>','-','_','(',')','[',']', ' '), '', $string);
    return str_replace( array('à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array('a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $result1);
	}


//DEV fonction pour logger les erreurs PHP dans la console
  function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>

</html>
