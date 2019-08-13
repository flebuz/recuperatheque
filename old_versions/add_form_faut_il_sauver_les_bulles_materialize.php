<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <title>Webapp Recupérathèque - Encoder un objet</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#00ff4e">

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/add_form.css">
  <!--<link rel="stylesheet" href="extras/noUiSlider/nouislider.css">-->
  <link rel="stylesheet" href="nouislider/nouislider.css">


  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!--Nécessaire pour les icônes des boutons du widget vidéo et bouton Soumettre-->



  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>


</head>

<body>
  <div class="header">
    <a href="#!" class="breadcrumb">Récupérathèque</a>
    <a href="#!" class="breadcrumb">Encodage</a>
  </div>

  <div class="container" id="cam_container">
    <div class="row nomargin">

        <!-- boutons prise de vue (pas complètement fonctionnels) -->
          <div class="col s1 offset-s1 offset-m2 offset-l2" id="cam_controls">
              <div class="row"></div>
              <!-- bouton upload photo -->
              <!--<label for="file">
              <div class="btn-floating waves-effect"><i class="material-icons photo-controls" title="Uploader une photo">cloud_upload</i></div>
              </label>
              <input id="file" type="file" accept="image/*" capture style="display:none;">-->

              <!-- bouton prise de vue -->
              <div class="row">
                <div  id="take-photo" title="Prendre un cliché" class="btn-floating btn-large  waves-effect invisible"><i class="material-icons photo-controls">camera_alt</i></div>

              </div>
              <!--<div  id="play" title="Activer la camera" class="btn-floating  waves-effect"><i class="material-icons photo-controls">play</i></div>
              <div  id="stop" title="Stopper la camera" class="btn-floating  waves-effect"><i class="material-icons photo-controls">stop</i></div> -->

          </div>


          <div id="video_container" class="col s8 m5 l5 center invisible" >

                  <video id="video" autoplay class="responsive-video" style="position:relative"></video>

          </div>

        <div id="file_upload_container" class="col s8 m5 l5 center" style="position:relative">
                <label for="file">
                <div  id="upload-file-default" title="Prendre un cliché / Uploader une photo" class="btn-floating btn-large cam_btn_default  waves-effect "><i class="material-icons photo-controls">camera_alt</i></div>
              </label>
              <input id="file" type="file" accept="image/*" capture style="display:none;">
        </div>

          <div class="col s1" style="margin-left:-100px"> <!--oui je sais le css inline c'est mal mais j'arrivais pas à décaler le petit thumbnail et de toute façon c'est provisoire :o) -->
          <canvas id="canvas"></canvas>
          </div>
      </div>
  </div>




<div class="container" id="formulaire">
    <!-- Les onglets avec les catégories de matériaux-->
    <div class="row nopadding" >
      <!-- Tout est dans le height:41px, c'est pas la marge qui créait un espace entre les deux colonnes !-->
      <div class="col s12" style="height:41px;">

        <!-- Début du formulaire-->
        <form name="formulaire_encodage" id="formulaire_encodage" method="post" action="?">

          <!--Attention, petite complexité : le menu déroulant combine deux types de composants Materialize (activés par javascript): un composant Tabs, et un composant Dropdown. Du coup j'ai du ruser avec des boutons invisibles tout en bas de index.php (oui c'est un peu du bricolage... :p)-->
          <!--Les tabs reprenant les différentes catégories de matériaux -->
        <!-- <ul class="tabs z-depth-1">
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#bois" data-target='select-bois'>bois</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#metal" data-target='select-metal'>métal</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#papier" data-target='select-papier'>papier</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#plastique" data-target='select-plastique' >plastique</a></li>
	          <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#verre" data-target='select-verre'>verre</a></li>
	          <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#construction" data-target='select-construction'>construction</a></li>
	          <li class="tab col s3 l2"><a href="#test4">textile</a></li>
	          <li class="tab col s3 l2"><a href="#test4">quincaillerie</a></li>
	          <li class="tab col s3 l2"><a href="#test4">mobilier</a></li>
	          <li class="tab col s3 l2"><a href="#test4">électronique</a></li>
	          <li class="tab col s3 l2"><a href="#test4">insolite</a></li>
          </ul> -->


<ul class="tabs z-depth-1">
          <?php
          $categories= array('bois','metal','papier','plastique','verre','construction','textile','quincaillerie','mobilier','électronique','insolite');
          $sous_catégories= array(

            'bois' => array('bois médium','bois massif','bois 3 plis','OSB'),
            'metal' => array('acier','acier galvanisé','fer à beton','aluminium', 'laiton')
          );

          shuffle ($categories);


          foreach ($categories as $key => $value) {
            echo '<li class="tab col s3 l2"><a class=\'dropdown-trigger btn-flat waves-effect couleur2 white-text\' href=\'#'.$value.'\'data-target=\'select-'.$value.'\'>'.$value.'</a></li>';
          }
          ?>
</ul>

      </div>

      <!-- Script requis par Materialize pour activer le composant Tabs (et faire qu'il puisse être swipeable sur mobile)-->
      <script>
        var instance = M.Tabs.init(el, {swipeable : true});

        /*
        // Or with jQuery
        $(document).ready(function(){
          $('.tabs').tabs();
        });
        */

      </script>

      <!-- Ici les sous-catégories de matériaux qui s'affichent des les menus déroulants-->
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
      <ul id="select-électronique" class="dropdown-content">
      	<li><a href="#!">transistor</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
      </ul>
      <ul id="select-insolite" class="dropdown-content">
      	<li><a href="#!">une flûte à 6 schtrompf</a></li>
      	<li class="divider" tabindex="-1"></li>
      	<li><a href="#!"><i class="material-icons">more_horiz</i>Autre textile</a></li>
      </ul>



</div>
<div class="container">
      <div class="col s12" style="">



            <div class="row" id="row_range">

              <div class="range-field col s5" id="range_div" >
                <input type="range" id="mesure" min="0.1" max="20" value="5" step="0.1" name="mesure" oninput="updateTextInput('indicateur_range', this.value);" />
              </div>

              <div class="input-field col s2" style="margin-top: 0px;">
              <input type="number" id="indicateur_range" value="5" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value;" style="inline; text-align: center; ">
              <!--<input type="number" id="indicateur_range" value="5" onkeypress="return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 188))" style="inline; text-align: center; ">-->
              </div>



                    <div class="col s2 l2">
                      <label>
                        <input name="unit" type="radio" value="kg" checked />
                        <span class="couleur3-text">kg</span>
                      </label>
                    </div>

                    <div class="col s2 l2">
                      <label>
                        <input name="unit" type="radio" value="m2"/>
                        <span class="couleur3-text">m²</span>
                      </label>
                    </div>

                    <div class="col s2 l2">
                      <label>
                        <input name="unit" type="radio" value="l"/>
                        <span class="couleur3-text">l</span>
                      </label>
                    </div>

                    <div class="col s2 l2">
                      <label>
                        <input name="unit" type="radio" value="cm"/>
                        <span class="couleur3-text">cm</span>
                      </label>
                    </div>

        </div>
        <div class ="row" >
          <div class="col s3 m2">
            <label for="pieces" class="couleur3-text">Nb de pièce(s):</label>
          </div>
          <div class="col s2 m1 nopadding" style="text-align: right;">
            <div class="btn plusminus waves-effect" onclick="Increment('pieces', -1, 1)">-</div>
          </div>
            <div class="col s2 m1">
              <input type="number" id="pieces" value="1" min="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateNonEmpty(this.id, 1)" style="text-align: center; ">
            </div>
            <div class="col s1 nopadding">
              <div class="btn plusminus waves-effect" onclick="Increment('pieces', 1, 1)">+</div>
            </div>




            </div>


           <div class ="row" >
              <div class="input-field col s12">
                <i class="material-icons prefix">label</i>
                <input id="tags" type="text">
                <label for="tags">Ajouter des descriptifs :</label>
              </div>

            </div>


            <div class ="row">
                  <div class="input-field col s2">

                    <label for="range_etat" class="couleur3-text">Etat:</label>

                </div>








<!-- Tentative d'émuler en css les tick marks de nouislider (pour éviter d'avoir à charger un module de +) mais pas super propre ?-->
           <style>.noUi-pips-horizontal {

    padding-top: 0px !important;
    height: auto;
    top: 100%;
    left: auto;
    width: 96%;
    right: auto;
    margin-left: 5px;
}

.noUi-pips {

    position: relative;
    color: #999;
    }</style>


             <div class="input-field col s10 m6" id="etat">

<input type="range" class="browser-default" id="range_etat" value="1"  style="z-index:30;width: 100% !important;  margin-bottom: 5px;" min="1" max="4" onupdate="ModifierBulle(etat)">


	<div class="noUi-pips noUi-pips-horizontal">
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 0.00000%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 0.00000%">Top</div>
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 33.33333%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 33.33333%">Okay</div>
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 66.66667%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 66.66667%">Mouaif</div>
	<div class="noUi-marker noUi-marker-horizontal noUi-marker-large" style="left: 100.00000%"></div>
	<div class="noUi-value noUi-value-horizontal noUi-value-large" style="left: 100.00000%">Bof</div>
	</div>

                </div>
           </div>




<div class="row">
  <div class="col s12">



  </div>
</div>



            <div class="row">
              <div class="col s4">
              </div>
        			<div class="col s4">
        			 <a class="waves-effect waves-light btn-small " value="submit" onclick="document.getElementById('formulaire_encodage').submit(); document.getElementById('client').reset(); " >
                 <i class="material-icons">thumb_up_alt</i>
                 Encoder
               </a>
        			</div>
              <!-- https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation -->

			        <div class="col s4">
              </div>
            </div>



      </div>

		</div>
</div>

</div>
    <!-- Alors ci-dessous ça peut paraitre bizarre, mais il s'agit d'une série de boutons (invisibles) que j'utilise pour faire s'afficher le menu déroulant correctement. L'origine de la difficulté est que je combine deux composants Materialize, les Tabs https://materializecss.com/tabs.html et les Dropdown https://materializecss.com/dropdown.html . Il y a sûrement un moyen plus simple de produire le même effet... :p -->
    <div >

<?php

      foreach ($categories as $key => $value) {
        echo '<a class=\'dropdown-trigger btn invisible glabu\' href=\'#\' data-target=\'select-'.$value.'\'>'.$value.'</a>';
      }

      ?>

  	<!--<a class='dropdown-trigger btn invisible' href='#' data-target='select-bois'>Bois</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-metal'>Métaux</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-papier'>Papier</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-plastique'>Plastique</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-verre'>verre</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-construction'>Construction</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-mobilier'>mobilier</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-textile'>mobilier</a>-->
    </div>


  </form>

  <!--<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>--> <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/adapter.js"></script> <!-- polyfill pour améliorer la compatibilité de WebRTC (getUserMedia) entre browsers -->

<!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
<script type="text/javascript" src="js/add_form.js"></script>
<script type="text/javascript" src="js/forms.js"></script>


<!-- Script requis par Materialize pour activer le composant Dropdown (qui sont définis en "visibility:hidden" trouvent tout en bas de index.php)-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
    var instance = M.Dropdown.init(elems, { coverTrigger: false, constrainWidth: false});
  });
  /*
  // Or with jQuery
  $('.dropdown-trigger').dropdown();
  */
</script>

<script type="text/javascript">

var span_bulle = document.getElementById("etat").querySelector(".value") ;

console.log(span_bulle.outerHTML);



var element=document.getElementById("etat");
console.log(element);

</script>

</body>

</html>
