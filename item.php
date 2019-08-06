

<div class='w3-col s12 m6 l4 item-container'>

  <div class='item'>

    <div class="item-photo-container">
      <img class='photo' src='photos/<?php echo $item['ID_item']; ?>.jpg'>
    </div>

    <div class="item-info-container">
      <div class='categorie'>
        <?php echo $item['categorie']; ?> > <?php echo $item['sous_categorie']; ?>
      </div>
      <div class='quantite'>
        <?php echo $item['mesure']; ?> - <?php echo $unite; ?>
      </div>
      <div class='état'>
        état: <?php echo $item['état']; ?>/5
      </div>

      <div class='tags'>
          <?php
            for($n = 0; $n < count($tags); $n++){
              echo '<a class="tag" href=#>#' . $tags[$n] . '</a>';
              if($n!=count($tags)-1){ echo ', '; }
            }
          ?>
      </div>
    </div>

    <div class="item-date-container">
      récupéré le <?php echo $item['date_ajout_fr']; ?>
    </div>

  </div>

</div>
