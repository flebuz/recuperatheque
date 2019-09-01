

<div class='w3-col s12 m6 l4'>

  <div class='item'>

    <div class="item-photo-container">


        <!-- $src='photos/' . $item['ID_item'] . '.jpg';
        $dest='photos/' . $item['ID_item'] . '_thumb.jpg';
        make_thumb($src, $dest); -->
        <?php
        echo '<img class="photo" src="photos/' . $item['ID_item'] . '.jpg" />'
        ?>


    </div>

    <div class='item-categorie-container'>
      <?php echo $item['categorie']; ?> <span style='color:#909090'>▸</span> <?php echo $item['sous_categorie']; ?>
    </div>

    <div class="item-info-container">
        <i class='fas fa-euro-sign item-icon'></i> <?php echo $item['prix']; ?> <br/>

        <i class='fas fa-heart-broken item-icon'></i> État:
        <?php
        //echo $item['etat'];
        for($n = 0; $n < 4; $n++){
          if($item['etat'] > $n){
            echo '<i class="w3-small fas fa-heart etat-icon"></i> ' ;
          } else{
            echo '<i class="w3-small far fa-heart etat-icon"></i> ' ;
          }
        }
        ?> <br/>

        <i class='fas fa-cubes item-icon'></i> <?php echo $unite; ?> <br/>
        <i class='fas fa-ruler item-icon'></i> <?php echo $item['dimensions']; ?> <br/>


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
