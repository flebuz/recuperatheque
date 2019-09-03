  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

<header>


<!--
<div class="button-menu hide-on-med-and-up" >
<a href="#" class="btn-floating sidenav-trigger " data-target="slide-out">
  <i class="fas fa-bars"></i>
</a>
</div>
-->


<!--
<ul id="slide-out" class="sidenav sidenav-fixed">
  <li><a href="#" class="nav-titre white-text hide-on-med-and-up">Mycelium</a></li>
  <li><div class="user-view">
    <a href="#name"><span class="name">Utilisateur</span></a>
    <a href="#email"><span class="email">federation@recuperatheque.org</span></a>
  </div></li>
  <li <?php if (isset($thisPage) && $thisPage=="catalogue") echo " class=\"couleur2\""; ?>>
      <a class="waves-effect pagelink" href="catalogue.php"><i class="fas fa-th white-text"></i> Catalogue</a></li>
  <li <?php if (isset($thisPage) && $thisPage=="add_form") echo " class=\"couleur2\""; ?>>
      <a class="waves-effect pagelink" href="add_form.php"><i class="fas fa-plus-square white-text"></i>Encoder un objet</a></li>
</ul>
-->



<!--
  <nav class="hide-on-small-only">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo right">Mycelium</a>
    <div class="left">
      <a href="#" class="sidenav-trigger " data-target="slide-out">
        <i class="fas fa-bars"></i>
      </a>
    </div>
  </nav> -->

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



<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
<link type="text/css" rel="stylesheet" href="css/tags-input.css"  media="screen,projection"/>
