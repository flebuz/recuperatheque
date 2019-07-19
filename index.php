<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <title>Webapp Recupérathèque - Encoder un objet</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#f44336">

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/add_form.css">

  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> <!--Nécessaire pour les icônes des boutons du widget vidéo et bouton Soumettre-->
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

  <script type="text/javascript" src="js/module_camera.js"></script>
</head>

<body>
  <div class="header">
    <a href="#!" class="breadcrumb">Récupérathèque</a>
    <a href="#!" class="breadcrumb">Encoder un objet</a>
  </div>

  <div class="container" id="cam_container">
      <div class="row">

        <!-- boutons prise de vue (pas complètement fonctionnels) -->
          <div class="col s1 offset-s1 offset-m2 offset-l3" id="cam_controls">
              <div class="row"></div>
              <!-- bouton upload photo -->
              <label for="file">
              <div class="btn-floating red lighten-1"><i class="material-icons photo-controls" title="Uploader une photo">cloud_upload</i></div>
              </label>
              <input id="file" type="file" accept="image/*" capture style="display:none;">

              <!-- bouton prise de vue -->
              <div  id="take-photo" title="Prendre un cliché" class="btn-floating red lighten-1 left"><i class="material-icons photo-controls">camera_alt</i></div>
              
          </div>


          <div class="col s8 m5 l5 center">
                  <video id="video" autoplay class="responsive-video"></video>

          </div>
          <div class="col s1" style="margin-left:-100px"> <!--oui je sais le css inline c'est mal mais j'arrivais pas à décaler le petit thumbnail et de toute façon c'est provisoire :o) -->
          <canvas id="canvas"></canvas>
          </div>
      </div>
  </div>

      <!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
      <script type="text/javascript" src="js/add_form_cam.js"></script>


<div class="container" id="formulaire">
    <!-- Les onglets avec les catégories de matériaux-->
    <div class="row" style="padding-top: 10px !important;  position:relative; z-index:11;">
      <!-- Tout est dans le height:41px, c'est pas la marge qui créait un espace entre les deux colonnes !-->
      <div class="col s12" style="height:41px; margin-bottom:0 !important; padding-bottom:0 !important;">

        <!-- Début du formulaire-->
        <form name="formulaire_encodage" id="formulaire_encodage" method="post" action="?">

          <!--Attention, petite complexité : le menu déroulant combine deux types de composants Materialize (activés par javascript): un composant Tabs, et un composant Dropdown. Du coup j'ai du ruser avec des boutons invisibles tout en bas de index.php (oui c'est un peu du bricolage... :p)-->
          <!--Les tabs reprenant les différentes catégories de matériaux -->
          <ul class="tabs z-depth-1">
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#bois" data-target='select-bois' style="color:#ffffff ">bois</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#metal" data-target='select-metal' style="color:#ffffff ">métal</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#papier" data-target='select-papier' style="color:#ffffff ">papier</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#plastique" data-target='select-plastique' style="color:#ffffff ">plastique</a></li>
	          <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#verre" data-target='select-verre' style="color:#ffffff ">verre</a></li>
	          <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#construction" data-target='select-construction' style="color:#ffffff ">construction</a></li>
	          <li class="tab col s3 l2"><a href="#test4">textile</a></li> <!-- pas encore fonctionnel -->
	          <li class="tab col s3 l2"><a href="#test4">quincaillerie</a></li>
	          <li class="tab col s3 l2"><a href="#test4">mobilier</a></li>
	          <li class="tab col s3 l2"><a href="#test4">électronique</a></li>
	          <li class="tab col s3 l2"><a href="#test4">insolite</a></li>
          </ul>

          <!-- Cf. https://codepen.io/anon/pen/XoLqyd un pen qui montre comment accéder aux div (avec un carousel ?) spécifique à chaque catégorie de matériaux (à implémenter si on veut faire joli?)-->

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

      <div class="col s12" style="margin-top:0px !important; padding-top:0px !important;">
        <div class="card white" style="padding-left:15px; padding-right:15px;" >
          <div class="card-content black-text">

            <div class="row" id="range_row" style="padding-left:0px;">

              <div class="range-field col s6" id="range_div" style="margin-top: 0px; padding-left:0px;">
                <input type="range" id="mesure" min="1" max="20" value="5" name="mesure" onchange="updateTextInput(this.value);" />
              </div>

              <div class="input-field col s2" style="margin-top: 0px;">
                <input type="text" id="indicateur_range" value="5" style="inline; text-align: center; ">
              </div>

              <!--Script pour mettre à jour l'affichage de la valeur du curseur "mesure"-->
              <script>
                function updateTextInput(val){
                  document.getElementById('indicateur_range').value=val;
                }
              </script>

                    <div class="col s2 l1">
                      <label>
                        <input name="unit" type="radio" checked />
                        <span>kg</span>
                      </label>
                    </div>

                    <div class="col s2 l1">
                      <label>
                        <input name="unit" type="radio"/>
                        <span>m²</span>
                      </label>
                    </div>

                    <div class="col s2 l1">
                      <label>
                        <input name="unit" type="radio"/>
                        <span>l</span>
                      </label>
                    </div>

                    <div class="col s2 l1">
                      <label>
                        <input name="unit" type="radio"/>
                        <span>pcs</span>
                      </label>
                    </div>

        </div>

            <div class ="row" style="margin-top: 0px; padding-left:0px;">
              <div class="input-field col s12">
                <i class="material-icons prefix">label</i>
                <input id="tags" type="text">
                <label for="tags">Ajouter des descriptifs :</label>
              </div>

            </div>

            <div class="row">
              <div class="col s4">
              </div>
        			<div class="col s4">
        			 <a class="waves-effect waves-light btn-small red lighten-1" value="submit" onclick="document.getElementById('formulaire_encodage').submit(); document.getElementById('client').reset(); " >
                 <i class="material-icons">thumb_up_alt</i>
                 Encoder
               </a>
        			</div>
			        <div class="col s4">
              </div>
            </div>

          </div>
        </div>
      </div>

		</div>
</div>
    <!-- Alors ci-dessous ça peut paraitre bizarre, mais il s'agit d'une série de boutons (invisibles) que j'utilise pour faire s'afficher le menu déroulant correctement. L'origine de la difficulté est que je combine deux composants Materialize, les Tabs https://materializecss.com/tabs.html et les Dropdown https://materializecss.com/dropdown.html . Il y a sûrement un moyen plus simple de produire le même effet... :p -->
    <div >
  		<a class='dropdown-trigger btn invisible' href='#' data-target='select-bois'>Bois</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-metal'>Métaux</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-papier'>Papier</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-plastique'>Plastique</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-verre'>verre</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-construction'>Construction</a>
      <a class='dropdown-trigger btn invisible' href='#' data-target='select-mobilier'>mobilier</a>
    </div>

  </form>

  <!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script> --> <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/adapter.js"></script> <!-- polyfill pour améliorer la compatibilité de WebRTC (getUserMedia) entre browsers -->

</body>

</html>
