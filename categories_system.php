
<!-- construction de l'objet $system qui résume la structure de catégorie actuelle -->

<?php
  //----- faire deux listes dont les clés sont les ID et les values le nb d'items

  //afin de savoir ce qu'il y a dans le catalogue
  $reqItem = $bdd->prepare('  SELECT * FROM ' . $recuperatheque);
  $reqItem->execute();
  $cat_counter = array();
  $sscat_counter = array();
  while($item = $reqItem->fetch()){
    if(array_key_exists($item['ID_categorie'],$cat_counter)){
      $cat_counter[$item['ID_categorie']] += 1;
    }
    else{
      $cat_counter[$item['ID_categorie']] = 1;
    }
    if(array_key_exists($item['ID_souscategorie'],$sscat_counter)){
      $sscat_counter[$item['ID_souscategorie']] += 1;
    }
    else{
      $sscat_counter[$item['ID_souscategorie']] = 1;
    }
  }
?>


<?php
  //----- faire une liste de liste qui contient les categorie et souscategorie

  // une categorie est:
  // ID => array( nom => nom, sscats => array())
  // une sscat est:
  // ID => nom

  //requete les sous-categories en joignant les infos de leur categorie associé
  $reqCat = $bdd->prepare('  SELECT cat.ID AS cat_ID, cat.nom AS cat_nom,
                             sscat.ID AS ID, sscat.ID_categorie, sscat.nom AS nom
                             FROM souscategorie sscat
                             INNER JOIN categorie cat ON sscat.ID_categorie=cat.ID
                             ORDER BY cat.ID, sscat.ID
                             ');
  $reqCat->execute();

  $system = array();
  $current_cat = '';
  //on parcour les souscategories
  while($sscat = $reqCat->fetch()){
    //si on a changé de categorie on crée une nouvelle
    if($current_cat != $sscat['cat_ID']){
      $system[$sscat['cat_ID']] = array('nom' => $sscat['cat_nom'], 'sscats' => array());
      $current_cat = $sscat['cat_ID'];
    }
    $system[$sscat['cat_ID']]['sscats'][$sscat['ID']] = $sscat['nom'];
  }

?>
