
<div class='w3-col s12 m6 l4'>

  <div class='item'>

    <div class="item-photo-container">

        <?php
        echo '<img class="photo" src="photos/' . $item['ID_item'] . '.jpg" />'
        ?>

    </div>

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

        <?php
        // calcul du prix
        if ($item['unitesscat']=='kg'){
          $prix = $item['prixsscat'] * $item['poids'] / $item['pieces'];
        }
        else{
          $prix = $item['prixsscat'];
        }
        $prix = $prix * ($item['etat']/4);

        //pluriel ou non sur le nombre d'unités
        $unite = "1 unité";
        if ($item['pieces']>1){
          $unite = $item['pieces'] . " unités";
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
        ?>

        <i class='fas fa-coins item-icon'></i> <?php echo $prix; ?> par pièce<br/>

        <i class='fas fa-heart-broken item-icon'></i> État:
        <span class='etat-icon-container'>
        <?php
        //echo $item['etat'];
        for($n = 0; $n < 4; $n++){
          if($item['etat'] > $n){
            echo '<i class="fas fa-heart etat-icon"></i> ' ;
          } else{
            echo '<i class="far fa-heart etat-icon"></i> ' ;
          }
        }
        ?>
        </span><br/>

        <i class='fas fa-cubes item-icon'></i> <?php echo $unite; ?> <br/>
        <i class='fas fa-ruler item-icon'></i> <?php echo $dimensions; ?> <br/>


    </div>

    <div class='item-tags-container'>
        <i class='fas fa-tag item-icon'></i>
        <?php
          for($n = 0; $n < count($tags); $n++){
            echo '<a class="tag" href=#>#' . $tags[$n] . '</a>';
            if($n!=count($tags)-1){ echo ', '; }
          }
        ?>
    </div>

    <div class="item-date-container">
      <i class='far fa-calendar item-icon'></i> récupéré le <?php echo $item['date_ajout_fr']; ?>
    </div>

  </div>

</div>
