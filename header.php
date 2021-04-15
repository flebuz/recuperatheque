<?php
session_start();
?>

<div class="header-container">
  <div class="header quasi-fullwidth">

    <div class="title"><a href="portal.php">Mycelium</a></div>

    <a href="https://forms.gle/iqQS8WYvnfcpT3dV8" class="nav-button">
      <div class="nav-title">(Problème ?)</div>
      <i class="fas fa-exclamation-triangle"></i>
    </a>
    <div class="nav-static">
      <div class="">&nbsp;|&nbsp;</div>
    </div>

    <?php
      if(isset($_SESSION['id']) AND isset($_SESSION['pseudo'])){?>

        <?php
          $cat_url = "catalogue.php?r=" . $_SESSION['pseudo'];
          $solo_url = "item_page.php?r=" . $_SESSION['pseudo'];
        ?>

        <a href="catalogue.php?r=<?php echo $_SESSION['pseudo']?>" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="catalogue.php"
                   && $_SESSION['pseudo']==$recuperatheque){
              echo "selected"; } ?>">
          <div class="nav-title">Mon Catalogue</div>
          <i class="nav-icon fas fa-book-open"></i>
        </a>

        <a href="add_form.php" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="add_form.php"){
              echo "selected"; } ?>">
          <div class="nav-title">Ajouter</div>
          <i class="nav-icon fas fa-plus-circle"></i>
        </a>

        <a href="user.php" class="nav-button
          <?php if(basename($_SERVER['PHP_SELF'])=="user.php"){
              echo "selected"; } ?>">
          <div class="nav-title">Mon Compte</div>
          <i class="nav-icon fas fa-user-lock"></i>
        </a>

      <?php
      }
      else{?>

        <a id="connection_btn" class="nav-button selected" >
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

<?php
  if(!isset($_SESSION['id']) AND !isset($_SESSION['pseudo'])){?>

    <!-- boite modal de connection -->
    <div id="connection"
         class="modal1 <?php if($connection_refused){ echo 'active'; }?>">

      <!-- Modal content -->
      <div class="modal1-content">

        <form method="POST">

          <div class="input-field">
            <label>Pseudo: </label>
            <input type="text" name="pseudo">
          </div>

          <div class="input-field">
            <label>Mot de passe: </label>
            <input type="password" name="mdp">
          </div>

          <?php
          if($connection_refused){
            echo '<div class="input-field"> Mauvais identifiant ou mot de passe </div>';
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

  <?php
  }
?>
