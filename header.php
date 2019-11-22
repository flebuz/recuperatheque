
<div class="header-container">
  <div class="header quasi-fullwidth">

    <div class="header-title"><a href="portal.php">Mycélium</a></div>

    <?php
      session_start();

      if(isset($_SESSION['id']) AND isset($_SESSION['pseudo'])){?>

        <div class="nom">
          <span><?php echo $_SESSION['pseudo']; ?></span>
        </div>

        <?php
          $cat_url = "catalogue.php?r=" . $_SESSION['pseudo'];
          $solo_url = "item_page.php?r=" . $_SESSION['pseudo'];
        ?>

        <a href="catalogue.php?r=<?php echo $_SESSION['pseudo']?>" class="nav-button
          <?php if(in_array(basename($_SERVER['PHP_SELF']),array("catalogue.php","item_page.php"))
                   && $_SESSION['pseudo']==$recuperatheque){
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

<?php

  $connection_refused = false;

  //  si on a envoyé un pseudo/mdp en POST
  if(isset($_POST['pseudo']) && isset($_POST['mdp'])){

    //  Récupération de l'utilisateur et de son pass hashé
    $req = $bdd->prepare('SELECT id, pseudo, mdp FROM _global_recuperatheques WHERE pseudo = :pseudo');
    $req->execute(array('pseudo' => $_POST['pseudo']));
    $resultat = $req->fetch();

    // Comparaison du pass envoyé via le formulaire avec la base
    $isPasswordCorrect = password_verify($_POST['mdp'], $resultat['mdp']);

    if ($resultat && $isPasswordCorrect) {
      session_start();
      $_SESSION['id'] = $resultat['id'];
      $_SESSION['pseudo'] = $resultat['pseudo'];

      header("Location: catalogue.php?r=" . $_POST['pseudo']);
    }
    else{
      $connection_refused = true;
    }

  }
?>


<!-- boite modal de connection -->
<div id="connection"
     class="modal <?php if($connection_refused){ echo 'active'; }?>">

  <!-- Modal content -->
  <div class="modal-content">

    <form method="POST">

      <div class="flex-input">
        <label>Pseudo: </label>
        <input type="text" class="" name="pseudo">
      </div>

      <div class="flex-input">
        <label>Mot de passe: </label>
        <input type="password" class="" name="mdp">
      </div>

      <?php
      if($connection_refused){
        echo '<div class="flex-input"> Mauvais identifiant ou mot de passe </div>';
      }
      ?>

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
    modal.classList.toggle('active');
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.classList.toggle('active');
    }
  }
</script>
