<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
        <title>Recupérathèque - Encoder un objet</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!--Let browser know website is optimized for mobile-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#f44336">
		<link rel="stylesheet" href="style.css"> 
		

      <!--Import Google Icon Font-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

      <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
	  
      
    </head>

    <body>
      <!--Import jQuery before materialize.js-->
     
    </body>
  </html>

		
<script>
$(function() {
	$('select').selectize(options);
});



</script>

</head>


    <body>
 

 
 <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
 {echo "<script>M.toast({html: 'Objet encodé, merci !'});</script>";}
 ?>
	  
<!--


<div class="wrapper tab-content" id="formulaire">-->
<!-- <div id="contenant_general" style="text-align: center"> <!--parent-wrapper ; ne semble définit nulle part-->
<!--<h4>Encodage d'un nouvel objet</h4>-->



<div class = "zone_camera" >
    <div class = "container grey darken-1 z-depth-0" style="width: 100%; max-width:720px;">
        

   
				<div class="grey darken-4 z-depth-2" style="padding: 20 !important; color:#FFFFFF; line-height:0px ; text-align: center">
      
	<!-- <p style="padding: 0 !important; "><i class="material-icons" style="line-height:0px; vertical-align: -5px;">add_box</i>&nbsp; Encoder un objet</p>-->
      
        <a href="#!" class="breadcrumb">Récupérathèque</a>
        <a href="#!" class="breadcrumb">Encoder un objet</a>
       
   
    			</div>
<video  class="responsive-video" id="video" autoplay></video>
<!--  <div class="row"></div> pour fixer le layout ? de la vidéo en dessous du bandeau ? -->
	<script>
// Ne fonctionne pas ? pourtant fonctionne très bien dans testcamera4.php -> fonctionne avec le div
// La solution miraculeuse ici : https://jsfiddle.net/jib1/aLn0dpvd/

//var log = msg => div.innerHTML += msg + "<br>";

var orgGetSupportedConstraints = navigator.mediaDevices.getSupportedConstraints.bind(navigator.mediaDevices);

//log(JSON.stringify(navigator.mediaDevices.getSupportedConstraints()));

navigator.mediaDevices.getUserMedia({ video: { facingMode: { exact: "environment"} }, audio: false })
  .then(stream => video.srcObject = stream)
  //.catch(e => log(e.name + ": "+ e.message));
</script>
		
			
	</div>
	

	
	<div class="row" style="width: 100%; max-width:720px; padding-top: 10px !important; ">
	   
	  
	  
	



	  
    <div class="col s12" style="width: 100% !important; max-width:720px !important; height:41px; margin-bottom:0 !important; padding-bottom:0 !important;"> <!-- Tout est dans le height:41px, c'est pas la marge qui créait un espace entre les deux colonnes !-->
		          
	
	<form name="formulaire_encodage" id="formulaire_encodage" method="post" action="?">
      <ul class="tabs z-depth-1" style="width: 100%; max-width:720px; ">
        <li class="tab col s3" style="width: 100%; max-width:720px;"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#bois" data-target='select-bois' style="color:#ffffff ">bois</a></li>
        <li class="tab col s3"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#metal" data-target='select-metal' style="color:#ffffff ">métal</a></li>
        <li class="tab col s3"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#papier" data-target='select-papier' style="color:#ffffff ">papier</a></li>
        <li class="tab col s3"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#plastique" data-target='select-plastique' style="color:#ffffff ">plastique</a></li>
		<li class="tab col s3"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#verre" data-target='select-verre' style="color:#ffffff ">verre</a></li>
		<li class="tab col s3"><a class='dropdown-trigger btn-flat waves-effect red lighten-1' href="#construction" data-target='select-construction' style="color:#ffffff ">construction</a></li>
		<li class="tab col s3"><a href="#test4">textile</a></li>
		<li class="tab col s3"><a href="#test4">quincaillerie</a></li>
		<li class="tab col s3"><a href="#test4">mobilier</a></li>
		<li class="tab col s3"><a href="#test4">électronique</a></li>
		<li class="tab col s3"><a href="#test4">insolite</a></li>
      </ul>
    
  
  
  <!-- https://codepen.io/anon/pen/XoLqyd un pen pour comment accéder aux div (avec un carousel ?) spécifique à chaque catégorie de matériaux -->
  
</div>

  
  <script>var instance = M.Tabs.init(el, {swipeable : true});

  // Or with jQuery

  $(document).ready(function(){
    $('.tabs').tabs();
  });</script>
 
   
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
    <script> document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.dropdown-trigger');
	var instance = M.Dropdown.init(elems, { coverTrigger: false, constrainWidth: false});
  });

  // Or with jQuery

  $('.dropdown-trigger').dropdown();</script>
  	  

	  
	  

<div class="col s12" style="width: 100% !important; max-width:720px !important; margin-top:0px !important; padding-top:0px !important;">
		          

	  
	  <div class="card white" style="padding-left:15px; padding-right:15px;" >
	<div class="card-content black-text">
	
	  <div class="row" id="range_row" style="padding-left:0px;">
	  <!--<label for="range_div" style="display:block; margin-bottom:0px; margin-top:0px;">Mesure :</label>-->
      <div class="input-field col s6" id="range_div" style="margin-top: 0px; padding-left:0px;"><input type="range" id="mesure" min="1" max="20" value="5" name="mesure" onchange="updateTextInput(this.value);" /> </div>

	   <div class="input-field col s2" style="margin-top: 0px;"><input type="text" id="indicateur_range" value="5" style="inline; text-align: center; "></div>
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
  <!-- <div class="input-field  col s3 offset-s6">
   </div>-->
	</div>




<div class ="row" style="margin-top: 0px; padding-left:0px;">
	<div class="col s12" style="margin-top: 0px; padding-left:0px;">
				
			
				
		<!--
			
				<div class="control-group">
					
					<select id="input-tags" class="kapoueh" placeholder="Entrer les tags...">
						<option value="">Entrer les tags...</option>
						<option value="1">brillant</option>
						<option value="2">mat</option>
						<option value="3">bosselé</option>
						<option value="4">torsadé</option>
						<option value="5">fendu</option>
				</div>
				<script type="text/javascript" style="display: none" class="hide">
				
				$('#input-tags').selectize({
					persist: true,
					createOnBlur: true,
					create: true,
				    maxItems: null
				});
				
				</script>
				-->
				
				<!--<div class="control-group">-->
					
					<input type="text" id="categ-descr" class="contacts" placeholder="Ajouter des tags ...">
					
					<!--
				<script>
				$('#categ-descr').selectize({
    persist: false,
    maxItems: null,
    valueField: 'email',
    labelField: 'name',
    searchField: ['name', 'email'],
    options: [
        {email: 'brian@thirdroute.com', name: 'Brian Reavis'},
        {email: 'nikola@tesla.com', name: 'Nikola Tesla'},
        {email: 'someone@gmail.com'}
    ],
    render: {
        item: function(item, escape) {
            return '<div>' +
                (item.name ? '<span class="name" style="float:left;">' + escape(item.name) + '</span>' : '') +
                (item.email ? '<small><span class="email" style="float:right;">' + escape(item.email) + '</span></small>' : '') +
            '</div>';
        },
        option: function(item, escape) {
            var label = item.name || item.email;
            var caption = item.name ? item.email : null;
            return '<div>' +
                '<span class="label">' + escape(label) + '</span>' +
                (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
            '</div>';
        }
    },
    createFilter: function(input) {
        var match, regex;

        // email@address.com
        regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');
        match = input.match(regex);
        if (match) return !this.options.hasOwnProperty(match[0]);

        // name <email@address.com>
        regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
        match = input.match(regex);
        if (match) return !this.options.hasOwnProperty(match[2]);

        return false;
    },
    create: function(input) {
        if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
            return {email: input};
        }
        var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
        if (match) {
            return {
                email : match[2],
                name  : $.trim(match[1])
            };
        }
        alert('Invalid email address.');
        return false;
    }
});
		
		</script>
		</div>
		-->
			<!--https://github.com/selectize/selectize.js/issues/1322 Créer des nouveaux tags & cie -->
			
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
		<a class='dropdown-trigger btn' href='#' data-target='select-bois' style="background-color:#fe0002; visibility: hidden;">Bois</a><a class='dropdown-trigger btn' href='#' data-target='select-metal'style="background-color:#fe0002; visibility: hidden;">Métaux</a>   <a class='dropdown-trigger btn' href='#' data-target='select-papier' style="background-color:#fe0002; visibility: hidden;">papier</a>   <a class='dropdown-trigger btn' href='#' data-target='select-plastique' style="background-color:#fe0002; visibility: hidden;">Plastique</a>   <a class='dropdown-trigger btn' href='#' data-target='select-verre' style="background-color:#fe0002; visibility: hidden;">verre</a> <a class='dropdown-trigger btn' href='#' data-target='select-construction' style="background-color:#fe0002; visibility: hidden;">Construction</a>
<a class='dropdown-trigger btn' href='#' data-target='select-mobilier' style="background-color:#fe0002; visibility: hidden;">mobilier</a>		
</form>

</body>
