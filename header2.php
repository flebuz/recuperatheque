
<div class="header-container">
  <div class="header quasi-fullwidth">

    <div class="header-title"><a href="catalogue.php">Mycélium</a></div>

    <a href="catalogue.php" class="nav-icon
      <?php if(in_array(basename($_SERVER['PHP_SELF']),array("catalogue.php","item_page2.php"))){
          echo "page-selected"; } ?>">
      <i class="w3-medium fas fa-book-open"></i>
    </a>
    <a href="add_form.php" class="nav-icon
      <?php if(basename($_SERVER['PHP_SELF'])=="add_form.php"){
          echo "page-selected"; } ?>">
      <i class="w3-medium fas fa-plus-circle"></i>
    </a>
    <a href="log.php" class="nav-icon
      <?php if(basename($_SERVER['PHP_SELF'])=="log.php"){
          echo "page-selected"; } ?>">
      <i class="w3-medium fas fa-user-lock"></i>
    </a>

  </div>
</div>
