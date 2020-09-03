
  <?php
    $prix = $item['prix'];

    //pluriel ou non sur le nombre de pièces
    $piece = "1 pièce";
    if ($item['pieces']>1){
      $piece = $item['pieces'] . " pièces";
    }

    //divise les tags en list php
    $tags = explode(", ",$item['tags']);

    //dimensions dispo ou non
    if ($item['dimensions']==''){
      $dimensions='non-disponibles';
    }
    else{
      $dimensions=$item['dimensions'];
    }

    //remarques ou pas
    if ($item['remarques']==''){
      $remarques='pas de remarques';
    }
    else{
      $remarques=$item['remarques'];
    }

    // calculate number of days between $enddate and $startdate
    $startdate = $item['date_ajout'];
    $enddate = date('Y-m-d');
    $days = (strtotime($enddate) - strtotime($startdate)) / (60 * 60 * 24);
  ?>



  <div class='item'>

    <?php
      if(basename($_SERVER['PHP_SELF'])=="catalogue.php"){
        // on met un lien vers la page de l'item s'il on est dans le catalogue ?>
        <a class="hidden-link" href="item_page.php?r=<?php echo $recuperatheque?>&id=<?php echo $item['ID_item']?>">
          <span></span>
        </a>
      <?php
      }
    ?>

    <div class="photo-container">
        <?php
          //localisation seulement si hors les murs
          if ($days<7){ ?>
              <div class="new"> NEW </div>
          <?php
          }
        ?>
        <?php

        // If the photo has just been updated (in edit.php)
        if (isset($_GET['update']) && ($_GET['update']==1))
        {
          // Forces updating the cache by querying a random number after the photo filename
          $image_url = 'photos/' . $recuperatheque . '/' . $item['ID_item'] . '.jpg?'.rand(1,32000);
          /*N.B. Maxime : this is not optimal. Ideally, the photo url should be unique to each uploaded,
           and should be stored in the database rather than relying on the ID of the item*/
        }
        else {
          $image_url = 'photos/' . $recuperatheque . '/' . $item['ID_item'] . '.jpg';
        }
        ?>
        <img class="item-photo" src=<?php echo $image_url; ?> />
        <?php
          //localisation seulement si hors les murs
          if ($item['localisation']){ ?>
              <div class="hors-les-murs"> <i class="fas fa-map-marker-alt"></i> Hors-les-murs </div>
          <?php
          }
        ?>
    </div>

    <div class="text-container">

      <div class='categorie-container'>
        <!-- deux choix d'affichage si la sscat est Autre ou pas -->
        <?php
        if ($item['sous_categorie']!='Autre'){
          ?>
          <span class="souscat"> <?php echo $item['sous_categorie']; ?> </span>
          <span class="cat"> (<?php echo $item['categorie']; ?>) </span>
        <?php
        }
        else{
          ?>
          <span class="souscat"> <?php echo $item['categorie']; ?> </span>
        <?php
        }
        ?>

      </div>

      <div class="info-container separateur">

        <div class="info-line">
          <i class='fas fa-coins info-icon'></i>
          <div class="info-text"><?php echo $prix; ?> <b><?php echo $recup_info['monnaie'];; ?></b> /pc </div>
        </div>

        <div class="info-line">
          <i class='fas fa-heart-broken info-icon'></i>
          <div class="info-text"> État:
            <span class='etat-icon-container'>
            <?php
            //echo $item['etat'];
            for($n = 0; $n < 4; $n++){
              if($item['etat'] > $n){
                echo '<i class="fas fa-heart"></i>' ;
              } else{
                echo '<i class="far fa-heart"></i>' ;
              }
            }
            ?>
            </span>
          </div>
        </div>

        <div class="info-line">
          <i class='fas fa-cubes info-icon'></i>
          <div class="info-text"><?php echo $piece; ?></div>
        </div>

      </div>

      <div class="info-plus-container separateur">
        <!-- les info qui apparaissent dans la page single -->

        <?php
          //poids seulement si c'est dans la sscat
          if ($item['unitesscat']=='kg'){ ?>
            <div class="info-line">
              <i class='fas fa-weight-hanging info-icon'></i>
              <div class="info-text"> <?php echo $item['poids']; ?> </div>
            </div>
          <?php
          }
        ?>

        <div class="info-line">
          <i class='fas fa-ruler info-icon'></i>
          <div class="info-text"> <?php echo $dimensions; ?> </div>
        </div>

        <div class="info-line">
          <i class='fas fa-info-circle info-icon'></i>
          <div class="info-text"> <?php echo $remarques; ?> </div>
        </div>

        <?php
          //localisation seulement si hors les murs
          if ($item['localisation']){ ?>
            <p>
              <b>Hors-les-murs</b><br/>
              Cet objet ne se trouve pas dans notre récupérathèque, mais à l'adresse suivante:
            </p>
            <div class="info-line">
              <i class="fas fa-map-marker-alt info-icon"></i>
              <div class="info-text"> <?php echo $item['localisation']; ?> </div>
            </div>
          <?php
          }
        ?>

      </div>

      <div class='tags-container separateur'>

        <div class="info-line">
          <i class='fas fa-tag info-icon'></i>
          <div class="info-text">
            <?php
              for($n = 0; $n < count($tags); $n++){?>
                <a class="tag" href= <?php echo link_construct(array('q'=>$tags[$n],'id'=>null, 'page'=>1), 'catalogue.php') ?> >#<?php echo $tags[$n];?></a>
                <?php
                if($n!=count($tags)-1){ echo ', '; }
              }
            ?>
          </div>
        </div>

      </div>

      <div class="date-container">

        <div class="info-line">
          <i class='far fa-calendar info-icon'></i>
          <div class="info-text">récupéré le <?php echo $item['date_ajout_fr']; ?></div>
        </div>

      </div>

    </div>

  </div>
