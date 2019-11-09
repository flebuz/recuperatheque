
<div class="header-container">
  <div class="header quasi-fullwidth">

    <div class="header-title"><a href="catalogue.php">Mycélium</a></div>

    <?php

      $admin = false;

      if($admin){?>

        <div class="nom">
          <span>Bag</span>
        </div>

        <a href="catalogue.php" class="nav-button
          <?php if(in_array(basename($_SERVER['PHP_SELF']),array("catalogue.php","item_page.php"))){
              echo "page-selected"; } ?>">
          <div class="nav-title">Mon Catalogue</div>
          <i class="nav-icon fas fa-book-open"></i>
        </a>

        <a href="add_form.php" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="add_form.php"){
              echo "page-selected"; } ?>">
          <div class="nav-title">Ajouter</div>
          <i class="nav-icon fas fa-plus-circle"></i>
        </a>

        <a href="compte.php" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="compte.php"){
              echo "page-selected"; } ?>">
          <div class="nav-title">Mon Compte</div>
          <i class="nav-icon fas fa-user-lock"></i>
        </a>

      <?php
      }
      else{?>

        <a href="log.php" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="log.php"){
              echo "page-selected"; } ?>">
          <div class="nav-title">Se Connecter</div>
          <i class="nav-icon fas fa-user-lock"></i>
        </a>

      <?php
      }
    ?>

  </div>
</div>
