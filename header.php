

<header>

  <div class="w3-sidebar w3-bar-block w3-collapse w3-card" style="width:250px;" id="mySidebar">
   <button class="w3-bar-item w3-button w3-hide-large"
   onclick="w3_close()">Close &times;</button>
   <ul>
     <!--<li><a href="#" class="nav-titre w3-bar-item hide-on-med-and-up">Mycelium</a></li>-->
     <li><div class="user-view">
       <a href="#name"><span class="w3-bar-item name">Utilisateur</span></a>
       <a href="#email"><span class="w3-bar-item email">federation@recuperatheque.org</span></a>
     </div></li>
     <li <?php if (isset($thisPage) && $thisPage=="catalogue") echo " class=\"sidebarhover\""; ?>>
         <a class="w3-bar-item w3-button pagelink" href="catalogue.php"><i class="fas fa-th prefix"></i> Catalogue</a></li>
     <li <?php if (isset($thisPage) && $thisPage=="add_form") echo " class=\"sidebarhover\""; ?>>
         <a class="w3-bar-item w3-button pagelink" href="add_form.php"><i class="fas fa-plus-square prefix"></i> Encoder un objet</a></li>

   </ul>
 </div>

 <div class="w3-main barretitre">

 <div class="w3-bar w3-large color-theme ">
   <button class="w3-button w3-xlarge w3-left" onclick="w3_open()">&#9776;</button>
   <span class="w3-bar-item w3-xlarge">
     Mycelium
   </span>
   </div>
 </div>

 <script>
 function w3_open() {
   document.getElementById("mySidebar").style.display = "block";
 }

 function w3_close() {
   document.getElementById("mySidebar").style.display = "none";
 }
 </script>

</header>


<!-- j'ai du désactivé les lien ici car ils changeait la mise en page de plein de chose dans le catalogue -->
<!-- <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/> -->
<!-- <link type="text/css" rel="stylesheet" href="css/tags-input.css"  media="screen,projection"/> -->
