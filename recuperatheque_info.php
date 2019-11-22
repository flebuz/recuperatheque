
<div class="container recuperatheque">

    <h3> <?php echo $recup_info['nom'] ;?> </h3>

    <div class="recuperatheque-info">

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
