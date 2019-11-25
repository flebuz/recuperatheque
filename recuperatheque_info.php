
<div class="container recuperatheque
      <?php if(in_array(basename($_SERVER['PHP_SELF']),array("catalogue.php","item_page.php"))){
        //le menu recuperatheque est depliable seulement pour la page catalogue et item_page
        //dans les autres il est directement ouvert
        echo "depliable" ;}
      ?>">

    <h2> <?php echo $recup_info['nom'] ;?> </h2>

    <div class="info">

      <?php if ($recup_info['adresse']){ ?>
        <div class="info-line">
          <i class="fas fa-map-marker-alt info-icon"></i>
          <div class="info-text"> <?php echo $recup_info['adresse'];?> </div>
        </div>
        <?php
        }
      ?>
      <?php if ($recup_info['telephone']){ ?>
        <div class="info-line">
          <i class="fas fa-phone info-icon"></i>
          <div class="info-text"> <?php echo $recup_info['telephone'];?> </div>
        </div>
        <?php
        }
      ?>
      <?php if ($recup_info['mail']){ ?>
        <div class="info-line">
          <i class="fas fa-envelope info-icon"></i>
          <a class="info-text" href="mailto:<?php echo $recup_info['mail'];?>"> <?php echo $recup_info['mail'];?></a>
        </div>
        <?php
        }
      ?>
      <?php if ($recup_info['site']){ ?>
        <div class="info-line">
          <i class="fas fa-link info-icon"></i>
          <a class="info-text" href="<?php echo $recup_info['site'];?>" target="_blank"> <?php echo $recup_info['site'];?></a>
        </div>
      <?php
      }
      ?>

    </div>

</div>

<script>
  var recuperatheque = document.getElementsByClassName("recuperatheque")[0];

  recuperatheque.onclick = function() {
    recuperatheque.classList.toggle('active');
  }
</script>
