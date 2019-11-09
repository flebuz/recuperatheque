

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

    <?php if(basename($_SERVER['PHP_SELF'])=="catalogue.php"){ ?>
      <!-- on met un lien vers la page de l'item sur la photo s'il on est dans le catalogue -->
      <a class="item-link" href="item_page.php?r=<?php echo $recuperatheque?>&id=<?php echo $item['ID_item']?>">
      <?php
      }
    ?>

    <div class="item-photo-container">
        <?php
          //localisation seulement si hors les murs
          if ($days<7){ ?>
              <div class="new"> NEW </div>
          <?php
          }
        ?>
        <?php
        echo '<img class="item-photo" src="photos/' . $item['ID_item'] . '.jpg" />'
        ?>
        <?php
          //localisation seulement si hors les murs
          if ($item['localisation']){ ?>
              <div class="hors-les-murs"> <i class="fas fa-map-marker-alt"></i> Hors-les-murs </div>
          <?php
          }
        ?>
    </div>

    <?php if(basename($_SERVER['PHP_SELF'])=="catalogue.php"){?>
      </a>
      <?php
      }
    ?>

    <div class="item-text-container">

      <div class='item-categorie-container'>
        <!-- deux choix d'affichage si la sscat est Autre ou pas -->
        <?php
        if ($item['sous_categorie']!='Autre'){
          ?>
          <span class="item-souscategorie"> <?php echo $item['sous_categorie']; ?> </span>
          <span class="item-categorie"> (<?php echo $item['categorie']; ?>) </span>
        <?php
        }
        else{
          ?>
          <span class="item-souscategorie"> <?php echo $item['categorie']; ?> </span>
        <?php
        }
        ?>

      </div>

      <div class="item-info-container">

        <div class="item-info-line">
          <i class='fas fa-coins item-icon'></i>
          <div class="item-info"><?php echo $prix; ?> (par pièce) </div>
        </div>

        <div class="item-info-line">
          <i class='fas fa-heart-broken item-icon'></i>
          <div class="item-info"> État:
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

        <div class="item-info-line">
          <i class='fas fa-cubes item-icon'></i>
          <div class="item-info"><?php echo $piece; ?></div>
        </div>

      </div>

      <div class="item-info-plus-container">
        <!-- les info qui apparaissent dans la page single -->

        <?php
          //poids seulement si c'est dans la sscat
          if ($item['unitesscat']=='kg'){ ?>
            <div class="item-info-line">
              <i class='fas fa-weight-hanging item-icon'></i>
              <div class="item-info"> <?php echo $item['poids']; ?> </div>
            </div>
          <?php
          }
        ?>

        <div class="item-info-line">
          <i class='fas fa-ruler item-icon'></i>
          <div class="item-info"> <?php echo $dimensions; ?> </div>
        </div>

        <div class="item-info-line">
          <i class='fas fa-info-circle item-icon'></i>
          <div class="item-info"> <?php echo $remarques; ?> </div>
        </div>

        <?php
          //localisation seulement si hors les murs
          if ($item['localisation']){ ?>
            <div class="item-info-line">
              <i class="fas fa-map-marker-alt item-icon"></i>
              <div class="item-info"> <?php echo $item['localisation']; ?> </div>
            </div>
          <?php
          }
        ?>

      </div>

      <div class='item-tags-container'>

        <div class="item-info-line">
          <i class='fas fa-tag item-icon'></i>
          <div class="item-info">
            <?php
              for($n = 0; $n < count($tags); $n++){?>
                <a class="item-tag" href= <?php echo link_construct(array('q'=>$tags[$n],'id'=>null), 'catalogue.php') ?> >#<?php echo $tags[$n];?></a>
                <?php
                if($n!=count($tags)-1){ echo ', '; }
              }
            ?>
          </div>
        </div>

      </div>

      <div class="item-date-container">

        <div class="item-info-line">
          <i class='far fa-calendar item-icon'></i>
          <div class="item-info">récupéré le <?php echo $item['date_ajout_fr']; ?></div>
        </div>

      </div>

    </div>

  </div>
