<header>
<div class="button-menu hide-on-med-and-up" >
<a href="#" class="btn-floating sidenav-trigger " data-target="slide-out">
  <i class="fas fa-bars"></i>
</a>
</div>

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




  <nav class="hide-on-small-only">
    <div class="nav-wrapper">
      <a href="#" class="brand-logo right">Mycelium</a>
    <div class="left">
      <a href="#" class="sidenav-trigger " data-target="slide-out">
        <i class="fas fa-bars"></i>
      </a>
    </div>
  </nav>

</header>



<link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
