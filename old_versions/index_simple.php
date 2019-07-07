<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
        <title>Webapp Recupérathèque - Encoder un objet</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#f44336">
		<link rel="stylesheet" href="style.css">

      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!--Nécessaire pour les icônes des boutons du widget vidéo et bouton Soumettre-->
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>  <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/adapter.js"></script> <!-- polyfill pour améliorer la compatibilité de WebRTC & getUserMedia entre browsers)
    </head>

    <body>

<!-- Message toast quand un objet est encodé -->
 <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
 {echo "<script>M.toast({html: 'Objet encodé, merci !'});</script>";}
 ?>

<div class = "container" style="width: 100%; max-width:720px; text-align=center;">
<div class="row nomargin">
    <div class = "col s12" style="height:225px">

				<div class="grey darken-4 z-depth-2 bandeau-noir">
          <a href="#!" class="breadcrumb">Récupérathèque</a>
          <a href="#!" class="breadcrumb">Encoder un objet</a>
    		</div>

<input style="position: relative; z-index=1;" id="file" type="file" accept="image/*" capture>
          <video   style="position: relative; z-index=3;" class="responsive-video" id="video" autoplay ></video>
          <canvas style="position: relative;  margin-top: -205px; margin-left: 55px; z-index: 10"></canvas>

<!-- boutons prise de vue (NON FONCTIONNELS) -->
<!-- Désolé, c'est fait super à l'arrache cette partie-ci :p -->
          <img id="snap">

          <div class="controls" style="position: relative;
              top: -125px; left: 20px; margin-top:-24px; z-index: 15; width:50px" >
              <div class="row nomargin">
                <a href="#" id="delete-photo" title="Delete Photo" class="disabled"><i class="material-icons">delete</i></a></div>
                <div class="row nomargin">
                <a href="#" id="take-photo" title="Take Photo"><i class="material-icons">camera_alt</i></a></div>
                <div class="row nomargin">
                <a href="#" id="download-photo" download="objet.png" title="Save Photo" class="disabled"><i class="material-icons">file_download</i></a>
              </div>
              </div>
          <!-- boutons prise de vue -->


<!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
  	<script>

// solution issue de https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
    // Contraintes : préférer la caméra arrière sur mobile ; pas d'audio
    var constraints = {  video: { facingMode: { exact: "environment"} }, audio: false };

    navigator.mediaDevices.getUserMedia(constraints)
    .then(function(mediaStream) {
      var video = document.querySelector('video');

        video.srcObject = mediaStream;
      video.onloadedmetadata = function(e) {
        video.play();
      };
    })
    .catch(function(err) { console.log(err.name + ": " + err.message); }); // always check for errors at the end.


      var take_photo_btn = document.querySelector('#take-photo');
          take_photo_btn.addEventListener("click", function(e){

            e.preventDefault();
            var snap = takeSnapshot();

            // Show image.
            image.setAttribute('src', snap);
            image.classList.add("visible");

            // Enable delete and save buttons
            delete_photo_btn.classList.remove("disabled");
            download_photo_btn.classList.remove("disabled");

            // Set the href attribute of the download button to the snap url.
            download_photo_btn.href = snap;

            // Pause video playback of stream.
            navigator.mediaDevices.getUserMedia.stop();
          });

          //Sauve un snapshot dans notre Canvas
          function takeSnapshot(){
            // Here we're using a trick that involves a hidden canvas element.
            var hidden_canvas = document.querySelector('canvas'),
                context = hidden_canvas.getContext('2d');

            var width = video.videoWidth,
                height = video.videoHeight;

            if (width && height) {
              // Setup a canvas with the same dimensions as the video.
              hidden_canvas.width = 125;
              hidden_canvas.height = 125;

              // Make a copy of the current frame in the video on the canvas.
            	context.drawImage(video, 0, 0, 125, 125); //Suppression Xime

              // Turn the canvas image into a dataURL that can be used as a src for our photo.
              return hidden_canvas.toDataURL('image/png');
            }
          }



          </script>


	</div>
</div>

<!-- Les onglets avec les catégories de matériaux-->
	<div class="row" style="padding-top: 10px !important; position:relative; z-index:5;">
    <div class="col s12" style="height:41px; margin-bottom:0 !important; padding-bottom:0 !important;"> <!-- Tout est dans le height:41px, c'est pas la marge qui créait un espace entre les deux colonnes !-->

<!-- Début du formulaire-->
	<form name="formulaire_encodage" id="formulaire_encodage" method="post" action="?">

<!--Attention, petite complexité : le menu déroulant combine deux types de composants Materialize (activés par javascript): un composant Tabs, et un composant Dropdown. Du coup j'ai du ruser avec des boutons invisibles tout en bas de index.php (oui c'est un peu du bricolage... :p)-->
    <!--Les tabs reprenant les différentes catégories de matériaux -->
      <ul class="tabs z-depth-1">
        <li class="tab col s2" ><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#bois" data-target='select-bois' style="color:#ffffff ">bois</a></li>
        <li class="tab col s2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#metal" data-target='select-metal' style="color:#ffffff ">métal</a></li>
        <li class="tab col s2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#papier" data-target='select-papier' style="color:#ffffff ">papier</a></li>
        <li class="tab col s2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#plastique" data-target='select-plastique' style="color:#ffffff ">plastique</a></li>
		<li class="tab col s2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#verre" data-target='select-verre' style="color:#ffffff ">verre</a></li>
		<li class="tab col s2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#construction" data-target='select-construction' style="color:#ffffff ">construction</a></li>
		<li class="tab col s2"><a href="#test4">textile</a></li> <!-- pas encore fonctionnel -->
		<li class="tab col s2"><a href="#test4">quincaillerie</a></li>
		<li class="tab col s2"><a href="#test4">mobilier</a></li>
		<li class="tab col s2"><a href="#test4">électronique</a></li>
		<li class="tab col s2"><a href="#test4">insolite</a></li>
      </ul>
  <!-- Cf. https://codepen.io/anon/pen/XoLqyd un pen qui montre comment accéder aux div (avec un carousel ?) spécifique à chaque catégorie de matériaux (à implémenter si on veut faire joli?)-->

</div>


<!-- Script requis par Materialize pour activer le composant Tabs (et faire qu'il puisse être swipeable sur mobile)-->
  <script>var instance = M.Tabs.init(el, {swipeable : true});
  // Or with jQuery
  $(document).ready(function(){
    $('.tabs').tabs();
  });</script>


<!-- Ici les sous-catégories de matériaux qui s'affichent des les menus déroulants-->
  <ul id="select-bois" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">bois médium</a></li>
	<li><a href="#!" style="color:#fe0002;">bois massif</a></li>
	<li><a href="#!" style="color:#fe0002;">bois 3 plis</a></li>
	<li><a href="#!" style="color:#fe0002;">OSB</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autres bois</a></li>
</ul>


  <ul id="select-metal" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">acier</a></li>
	<li><a href="#!" style="color:#fe0002;">acier galvanisé</a></li>
	<li><a href="#!" style="color:#fe0002;">fer à beton</a></li>
	<li><a href="#!" style="color:#fe0002;">aluminium</a></li>
	<li><a href="#!" style="color:#fe0002;">laiton</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autres métal</a></li>
</ul>

 <ul id="select-papier" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">papier</a></li>
	<li><a href="#!" style="color:#fe0002;">carton</a></li>
	<li><a href="#!" style="color:#fe0002;">fil de reliure</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autres papetterie</a></li>
</ul>
 <ul id="select-plastique" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">plexiglas</a></li>
	<li><a href="#!" style="color:#fe0002;">dibon</a></li>
	<li><a href="#!" style="color:#fe0002;">mousse</a></li>
	<li><a href="#!" style="color:#fe0002;">PVC</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autres plastique</a></li>
</ul>
 <ul id="select-verre" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">plaque de verre</a></li>
	<li><a href="#!" style="color:#fe0002;">miroir</a></li>
	<li><a href="#!" style="color:#fe0002;">verre martelé</a></li>
	<li><a href="#!" style="color:#fe0002;">récipient</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autres verre</a></li>
</ul>
 <ul id="select-construction" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">béton</a></li>
	<li><a href="#!" style="color:#fe0002;">béton cellulaire</a></li>
	<li><a href="#!" style="color:#fe0002;">plâtre</a></li>
	<li><a href="#!" style="color:#fe0002;">carrelage</a></li>
	<li><a href="#!" style="color:#fe0002;">pierre</a></li>
	<li><a href="#!" style="color:#fe0002;">terre</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autres construction</a></li>
</ul>

 <ul id="select-mobilier" class="dropdown-content">
	<li><a href="#!" style="color:#fe0002;">table</a></li>
	<li><a href="#!" style="color:#fe0002;">table a dessin</a></li>
	<li><a href="#!" style="color:#fe0002;">table à couture</a></li>
	<li><a href="#!" style="color:#fe0002;">vitrine</a></li>
	<li><a href="#!" style="color:#fe0002;">chevalet</a></li>
	<li class="divider" tabindex="-1"></li>
	<li><a href="#!" style="color:#fe0002;"><i class="material-icons">more_horiz</i>Autre mobilier</a></li>
</ul>

<!-- Script requis par Materialize pour activer le composant Dropdown (qui sont définis en "visibility:hidden" trouvent tout en bas de index.php)-->
    <script> document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
	var instance = M.Dropdown.init(elems, { coverTrigger: false, constrainWidth: false});
  });
  // Or with jQuery
  $('.dropdown-trigger').dropdown();</script>





<div class="col s12" style="margin-top:0px !important; padding-top:0px !important;">



	  <div class="card white" style="padding-left:15px; padding-right:15px;" >
	<div class="card-content black-text">

	  <div class="row" id="range_row" style="padding-left:0px;">

      <div class="input-field col s6" id="range_div" style="margin-top: 0px; padding-left:0px;"><input type="range" id="mesure" min="1" max="20" value="5" name="mesure" onchange="updateTextInput(this.value);" /> </div>

	   <div class="input-field col s2" style="margin-top: 0px;"><input type="text" id="indicateur_range" value="5" style="inline; text-align: center; "></div>

<!--Script pour mettre à jour l'affichage de la valeur du curseur "mesure"-->
	  <script>
	  function updateTextInput(val) {
          document.getElementById('indicateur_range').value=val;
        }
	  </script>
	  <div class="input-field col s2" style="margin-top: 0px;">
      <label>
        <input name="group1" type="radio" checked />
        <span>kg</span>
      </label>
	  </div> <div class="input-field col s2" style="margin-top: 0px;">
	  <label>
        <input name="group1" type="radio"/>
        <span>m²</span>
      </label>
	  </div> <div class="input-field col s2">
	  <label>
        <input name="group1" type="radio"/>
        <span>litre</span>
      </label>
   </div><div class="input-field col s2">
	  <label>
        <input name="group1" type="radio"/>
        <span>pcs</span>
      </label>
   </div>
	</div>




<div class ="row" style="margin-top: 0px; padding-left:0px;">
	<div class="col s12" style="margin-top: 0px; padding-left:0px;">

					<input type="text" id="categ-descr" class="contacts" placeholder="Ajouter des tags ...">


			&nbsp;&nbsp;&nbsp;
	</div>
</div>
			<div class="row">
			<div class="col s4"></div>
			<div class="col s4">
			 <a class="waves-effect waves-light btn-small red lighten-1" value="submit" onclick="document.getElementById('formulaire_encodage').submit(); document.getElementById('client').reset(); " ><i class="material-icons">thumb_up_alt</i> Encoder</a>
			</div>
			<div class="col s4"></div>
</div>
<div class="row"></div>
		</div>
	</div>
		</div>
		 </div>

<!-- Alors ci-dessous ça peut paraitre bizarre, mais il s'agit d'un bouton (invisible) que j'utilise pour faire s'afficher le menu déroulant correctement. L'origine de la difficulté est que je combine deux composants Materialize, les Tabs https://materializecss.com/tabs.html et les Dropdown https://materializecss.com/dropdown.html . Il y a sûrement un moyen plus simple de produire le même effet... :p -->

		<a class='dropdown-trigger btn' href='#' data-target='select-bois' style="visibility: hidden;">Bois</a>
    <a class='dropdown-trigger btn' href='#' data-target='select-metal'style="visibility: hidden;">Métaux</a>
    <a class='dropdown-trigger btn' href='#' data-target='select-papier' style="visibility: hidden;">Papier</a>
    <a class='dropdown-trigger btn' href='#' data-target='select-plastique' style="visibility: hidden;">Plastique</a>
    <a class='dropdown-trigger btn' href='#' data-target='select-verre' style="visibility: hidden;">verre</a>
    <a class='dropdown-trigger btn' href='#' data-target='select-construction' style="visibility: hidden;">Construction</a>
    <a class='dropdown-trigger btn' href='#' data-target='select-mobilier' style="visibility: hidden;">mobilier</a>
</form>

</body>
</html>
