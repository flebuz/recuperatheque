
<div class="container recuperatheque">

    <h3> <?php echo $recup_info['nom'] ;?> </h3>

    <div class="recuperatheque-info">

      <?php if ($recup_info['adresse']){ ?>
        <div class="item-info-line">
          <i class="fas fa-map-marker-alt item-icon"></i>
          <div class="item-info"> <?php echo $recup_info['adresse'];?> </div>
        </div>
        <?php
        }
      ?>
      <?php if ($recup_info['telephone']){ ?>
        <div class="item-info-line">
          <i class="fas fa-phone item-icon"></i>
          <div class="item-info"> <?php echo $recup_info['telephone'];?> </div>
        </div>
        <?php
        }
      ?>
      <?php if ($recup_info['mail']){ ?>
        <div class="item-info-line">
          <i class="fas fa-envelope item-icon"></i>
          <a class="item-info" href="mailto:<?php echo $recup_info['mail'];?>"> <?php echo $recup_info['mail'];?></a>
        </div>
        <?php
        }
      ?>
      <?php if ($recup_info['site']){ ?>
        <div class="item-info-line">
          <i class="fas fa-link item-icon"></i>
          <a class="item-info" href="<?php echo $recup_info['site'];?>" target="_blank"> <?php echo $recup_info['site'];?></a>
        </div>
      <?php
      }
      ?>

    </div>

</div>
