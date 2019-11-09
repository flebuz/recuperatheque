
<div class="container border-bottom recuperatheque">

  <?php
    //Afficher les infos de la recuperatheque
    $req = $bdd->prepare(' SELECT * FROM recuperatheques WHERE raccourci = :recuperatheque ');
    $req->bindValue(':recuperatheque', $recuperatheque , PDO::PARAM_STR);
    $req->execute();
    $item = $req->fetch();

    //on recupere la monnaie pour la suite
    $monnaie = $item['monnaie'];
    ?>

    <h3> <?php echo $item['nom'] ;?> </h3>

    <?php if ($item['adresse']){ ?>
      <div class="item-info-line">
        <i class="fas fa-map-marker-alt item-icon"></i>
        <div class="item-info"> <?php echo $item['adresse'];?> </div>
      </div>
      <?php
      }
    ?>
    <?php if ($item['telephone']){ ?>
      <div class="item-info-line">
        <i class="fas fa-phone item-icon"></i>
        <div class="item-info"> <?php echo $item['telephone'];?> </div>
      </div>
      <?php
      }
    ?>
    <?php if ($item['site']){ ?>
      <div class="item-info-line">
        <i class="fas fa-link item-icon"></i>
        <a class="item-info" href="<?php echo $item['site'];?>" target="_blank"> <?php echo $item['site'];?></a>
      </div>
    <?php
    }
    ?>

</div>
