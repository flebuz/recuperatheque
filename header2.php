
<div class="header-container">
  <div class="header quasi-fullwidth">

    <div class="header-title"><a href="catalogue.php">Mycélium</a></div>

    <a href="catalogue.php" class="nav-button
      <?php if(in_array(basename($_SERVER['PHP_SELF']),array("catalogue.php","item_page2.php"))){
          echo "page-selected"; } ?>">
      <div class="nav-title">Catalogue</div>
      <i class="nav-icon w3-large fas fa-book-open"></i>
    </a>
    <a href="add_form.php" class="nav-button
      <?php if(basename($_SERVER['PHP_SELF'])=="add_form.php"){
          echo "page-selected"; } ?>">
      <div class="nav-title">Ajout</div>
      <i class="nav-icon w3-large fas fa-plus-circle"></i>
    </a>
    <a href="log.php" class="nav-button
      <?php if(basename($_SERVER['PHP_SELF'])=="log.php"){
          echo "page-selected"; } ?>">
      <div class="nav-title">Admin</div>
      <i class="nav-icon w3-large fas fa-user-lock"></i>
    </a>

  </div>
</div>
