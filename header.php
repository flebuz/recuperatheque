
<div class="header-container">
  <div class="header quasi-fullwidth">

    <div class="header-title"><a href="portal.php">Mycélium</a></div>

    <?php
      session_start();

      if(isset($_SESSION['id']) AND isset($_SESSION['pseudo'])){?>

        <div class="nom">
          <span>Bag</span>
        </div>

        <?php
          $cat_url = "catalogue.php?r=" . $_SESSION['pseudo'];
          $solo_url = "item_page.php?r=" . $_SESSION['pseudo'];
        ?>

        <a href="catalogue.php?r=<?php echo $_SESSION['pseudo']?>" class="nav-button
          <?php if(in_array(basename($_SERVER['PHP_SELF']),array($cat_url,$solo_url))){
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

        <a href="user.php" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="user.php"){
              echo "page-selected"; } ?>">
          <div class="nav-title">Mon Compte</div>
          <i class="nav-icon fas fa-user-lock"></i>
        </a>

      <?php
      }
      else{?>

        <a id="connection_btn" class="nav-button
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


<!-- boite modal de connection -->
<div id="connection" class="modal">

  <!-- Modal content -->
  <div class="modal-content">

    <form action="log.php" method="POST">

      <div class="flex-input">
        <label>Nom: </label>
        <input type="text" class="" name="pseudo">
      </div>

      <div class="flex-input">
        <label>Mot de passe: </label>
        <input type="password" class="" name="mdp">
      </div>

      <button class="button-flex" type="submit">
        <div class="button-title">Connection</div>
      </button>

    </form>

  </div>
</div>

<script>
  var modal = document.getElementById("connection");
  var btn = document.getElementById("connection_btn");

  // When the user clicks on the button, open the modal
  btn.onclick = function() {
    modal.style.display = "block";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
