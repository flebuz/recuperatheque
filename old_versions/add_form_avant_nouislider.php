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
  <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="extras\noUiSlider\nouislider.css"  media="screen,projection"/>

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
          <ul class="tabs z-depth-1">
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#bois" data-target='select-bois'>bois</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#metal" data-target='select-metal'>métal</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#papier" data-target='select-papier'>papier</a></li>
            <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#plastique" data-target='select-plastique' >plastique</a></li>
	          <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#verre" data-target='select-verre'>verre</a></li>
	          <li class="tab col s3 l2"><a class='dropdown-trigger btn-flat waves-effect couleur2 white-text' href="#construction" data-target='select-construction'>construction</a></li>
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

</div>
<div class="container">
      <div class="col s12" style="">



            <div class="row" id="row_range">

              <div class="range-field col s5" id="range_div" >
                <input type="range" id="mesure" min="1" max="20" value="5" name="mesure" oninput="updateTextInput(this.value);" />
              </div>

              <div class="input-field col s2" style="margin-top: 0px;">
              <input type="number" id="indicateur_range" value="5" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="inline; text-align: center; ">
              </div>

              <!--Script pour mettre à jour l'affichage de la valeur du curseur "mesure"-->
              <script>
                function updateTextInput(val){
                  document.getElementById('indicateur_range').value=val;
                }
              </script>

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
          <div class="col s1">
            <div class="btn plusminus" onclick="DecrementPieces()">-</div>
          </div>
            <div class="col s2" style="min-width:50px">
              <input type="number" id="pieces" value="1" min="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" style="text-align: center; ">
            </div>
            <div class="col s1">
              <div class="btn plusminus" onclick="IncrementPieces()">+</div>
            </div>


                <!--Script pour mettre à jour l'affichage de la valeur du curseur "mesure"-->
                <script>
                  function IncrementPieces(){
                    var number=document.getElementById('pieces').value;
                    number++;
                    document.getElementById('pieces').value=number;
                  }
                  function DecrementPieces(){
                    var number=document.getElementById('pieces').value;
                    if (number> 1) {
                       number--;
                        document.getElementById('pieces').value=number;}

                  }
                </script>

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

                    <label for="range_usure" class="couleur3-text">Etat:</label>

                </div>
                <div class="input-field col s4 m2 l2">
                  <div class="center"><input type="text" id="indicateur_texte_usure" style="text-align:center" value="Top"></div>
                </div>
                <div class="input-field col s6">


                    <input type="range" id="range_usure" step="1" min="1" max="4" value="1" oninput="update_val_usure(this.value);">
<div id="range_etat" oninput="update_val_usure(this.value);"></div>
                </div>


                <script>
                  function update_val_usure(val){

                    var texte_usure;

                    switch (val) {
                      case "1":
                        texte_usure="Top";

                        document.getElementById('indicateur_texte_usure').value=texte_usure;
                        break;
                      case "2":
                        texte_usure="Okay";

                          document.getElementById('indicateur_texte_usure').value=texte_usure;
                        break;
                      case "3":
                        texte_usure="Mouaif";

                          document.getElementById('indicateur_texte_usure').value=texte_usure;
                        break;
                      case "4":
                        texte_usure="Bof";

                          document.getElementById('indicateur_texte_usure').value=texte_usure;
                        break;

                        default:
document.getElementById('indicateur_texte_usure').value="Erreur";
                        break;

                    }


                  }




                </script>

           </div>



           <div class ="row">
                 <div class="col s3">

                   <label for="prix" class="couleur3-text">Prix suggéré:</label>

               </div>
               <div class="col s3">
                  <input type="text" id="prix">


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
			        <div class="col s4">
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

<!-- Le script pour afficher la vidéo récupérée par getUserMedia-->
<script type="text/javascript" src="js/add_form_cam.js"></script>
<script type="text/javascript" src="extras\noUiSlider\nouislider.js"></script>



<script>

  var pipFormats = {'1':'Top', '2':'Okay', '3':'Mouaif','4':'Bof'};
  var slider = document.getElementById('range_etat');
  noUiSlider.create(slider, {
   start: [1],
   connect: true,
   step: 1,
   orientation: 'horizontal', // 'horizontal' or 'vertical'
   range: {
     'min': 1,
     'max': 4
   },
   format: {
   to: function(a){ return pipFormats[a]; },
   from:function(value) {return value;}
   },
   pips: {
      mode: 'steps',
      values: 4,
      density:100,
      stepped: true,
      format: {
      to: function(a){ return pipFormats[a]; }
      }

    }
  });

  slider.noUiSlider.on('update', function( values, handle ) {
     var valeur = slider.noUiSlider.get();
     	
     });


        </script>

<!-- https://github.com/tb/ng2-nouislider/issues/107#issuecomment-327940463
https://github.com/tb/ng2-nouislider/issues/140#issuecomment-352693962 -->

</body>

</html>
