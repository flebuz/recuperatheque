
<!-- menu tris -->
<div id="tri" class="menu" style="display:none">

  <?php
    foreach($tri_option as $param => $nom){
      $getURL = '?' . http_build_query(array_merge($_GET, array('order' => $param)));
    ?>

      <a href="<?php echo $getURL;?>"
         class="w3-block souscategorie-title <?php if($tri==$param){echo 'selected'; }?>">
         <?php echo $nom; ?>
      </a>

    <?php
    }
  ?>

</div>
