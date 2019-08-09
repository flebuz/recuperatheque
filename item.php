

<div class='w3-col s12 m6 l4 item-container'>

  <div class='item'>

    <div class="item-photo-container">
      <img class='photo' src='photos/<?php echo $item['ID_item']; ?>.jpg'>
    </div>

    <div class='item-categorie-container'>
      <?php echo $item['categorie']; ?> > <?php echo $item['sous_categorie']; ?>
    </div>

    <div class="item-info-container">
      <div class='quantite'>
        <i class='fas fa-ruler item-icon'></i> <?php echo $item['mesure']; ?> <br/>
        <i class='fas fa-cubes item-icon'></i> <?php echo $unite; ?>
      </div>
      <div class='état'>
        <?php
          for($n = 0; $n < 5; $n++){
            if($item['état'] > $n){
              echo '<i class="w3-small fas fa-star item-icon"></i>' ;
            } else{
              echo '<i class="w3-small far fa-star item-icon"></i>' ;
            }
          }
        ?>
      </div>
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
