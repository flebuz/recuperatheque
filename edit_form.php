<html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">


<head>
  <title>Mycélium : L'app des Recupérathèques - Modifier un objet</title>
  <meta charset='utf-8'>


  <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height"> <!-- zoom désactivé pour éviter les zoom intempestifs sur mobile (aussi : , target-densitydpi=device-dpi)-->
  <meta name="theme-color" content="">

  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/add_form.css">
  <link rel="stylesheet" href="css/menu.css">
  <meta name="theme-color" content="#00E676">


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">


  <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/tags-input.css"  media="screen,projection"/>


  <?php
  // Prevent caching on the catalogue to make sure it is always up-to-date
  // TO DO : Check if there is a less aggressive way to do it
  header("Cache-Control: max-age=0");
  ?>

  <?php

  include('connection_db.php');?>

</head>


<body class="disable-dbl-tap-zoom">

  <?php
    include('header.php');

    if(isset($_SESSION['pseudo'])){
            $recuperatheque = $_SESSION['pseudo'];
            $recuperatheque_catalogue = $recuperatheque . '_catalogue';
            $recuperatheque_journal = $recuperatheque . '_journal';
    }
    ?>

  <?php
  // if previous form was submitted to self
  if (isset($_POST['action'])) {
    // process the edit/removal
    include 'edit.php';
    console_log("include de add.php");

    }
  ?>

<?php
if  ( (!$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) && (!$id = filter_input(INPUT_POST, 'ID_item', FILTER_VALIDATE_INT)) )
 {
$item = 0;
$item_status = 0;
}



      //prep the request
      //every line is a souscategorie
      $req = $bdd->prepare('  SELECT
                              c.ID AS ID_item, c.ID_categorie, c.ID_souscategorie, c.pieces AS pieces, c.dimensions AS dimensions, c.etat AS etat, c.tags AS tags, c.prix AS prix, c.poids AS poids, c.remarques AS remarques, c.localisation AS localisation, DATE_FORMAT(c.date_ajout, \'%d/%m/%Y\') AS date_ajout_fr,
                              cat.ID, cat.nom AS categorie,
                              sscat.ID AS sscatID, sscat.ID_categorie, sscat.unite AS unitesscat, sscat.prix AS prixsscat, sscat.nom AS sous_categorie
                              FROM '. $recuperatheque_catalogue .' c
                              INNER JOIN _global_categories cat ON c.ID_categorie=cat.ID
                              INNER JOIN _global_souscategories sscat ON c.ID_souscategorie=sscat.ID
                              WHERE c.id=:id');

      $req->bindValue(':id', $id, PDO::PARAM_INT);
      //execute the request
      $req->execute();

      if ($req->rowCount() > 0) {
        $item = $req->fetch();
        $item_status =1;
    }
    else
    {  $item = 0;
    $item_status= 0;}

    // if the action was a removal
    if  ( (isset($_POST['action'])) &&($_POST['action'] =='remove') )
         {
           //redirect to catalogue in 3 seconds since there is no item to display
          header("refresh:2; url='catalogue.php?r=$recuperatheque'");
          $item_status=999; //set value to 999 to mean "destroyed"
         }
?>


<main class="space-header">

  <div class="containerbis border-top border-bottom sticky">

    <a href="item_page.php?r=<?php echo $recuperatheque."&id=".$id ?>"><i class="fas fa-chevron-left"></i> &emsp; retour à l'objet</a>

  </div>

  <!-- Show modal in case of ID error -->
   <div id="modal_iderror" class="modal">
     <div class="modal-content">
      <img src="/assets/sad_android.svg"  style="float:right; width:64px;height:64px;"> <h4>Erreur</h4>
       <p>Pas d'objet sélectionné ou objet invalide !</p>
       <p>Si vous pensez qu'il s'agit d'un bug, envoyez un (gentil) courriel à <a href="mailto:federation@recuperatheque.org" style="color:blue">federation@recuperatheque.org<a></p>
     </div>
     <div class="modal-footer">
       <a href="catalogue.php" class="modal-close waves-effect waves-green btn-flat">Retour</a>
     </div>
   </div>

  <div id="loading_overlay" class="overlay invisible">


    <!-- Overlay content -->
    <div class="overlay-content">
    <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
    </div>

  </div>




  <div class="container" id="cam_container">
    <div class="row nomargin">

<div id="cam_col" class="col s12 center-align">
  <label for="file_upload" style="text-align:center">

      <canvas id="snap_final" class="invisible"></canvas>
      <img id="snap" class="thumbnail responsive-img" src="/photos/<?php echo $recuperatheque ?>/<?php echo $id ?>.jpg"></img>

                              <div id="spinner_imagesnap" class="lds-spinner color-grey invisible"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                          </label>
                          <input id="file_upload" type="file" accept="image/*" capture="environment" class="invisible">



<!-- IMAGE ICI -->

</div>



      </div>
  </div>



<div class="quasi-fullwidth" style="background-color:white">


  <div style="" class="scrolling-wrapper">

    <?php
      //prep the request
      //every line is a souscategorie
      $req = $bdd->prepare('  SELECT `nom`, `ID` FROM `_global_categories` ORDER BY `_global_categories`.`ID`
                          ');
      //execute the request
      $req->execute();

       // displaying buttons with the categories of materials
        while ($cat = $req->fetch()) {

              if ($cat['ID']== $item['ID_categorie'])
              {
                echo '<a id=\'dropdown_cat'.$cat['ID'].'\' class=\'dropdown-trigger btn-flat waves-effect white-text btn-cat active\' href=\'#'.$cat['ID'].'\'data-target=\'select-'.$cat['ID']."' onclick= \"set_active('.dropdown-trigger', this.id); this.classList.add('active'); set_value('nom_categorie','".$cat['nom']."'); set_value('id_categorie','".$cat['ID']."'); set_value('nom_souscategorie',''); set_value('id_souscategorie','');\"".'\'>'.$cat['nom'].'</a>';
              }
              else {
                echo '<a id=\'dropdown_cat'.$cat['ID'].'\' class=\'dropdown-trigger btn-flat waves-effect white-text btn-cat\' href=\'#'.$cat['ID'].'\'data-target=\'select-'.$cat['ID']."' onclick= \"set_active('.dropdown-trigger', this.id); this.classList.add('active'); set_value('nom_categorie','".$cat['nom']."'); set_value('id_categorie','".$cat['ID']."'); set_value('nom_souscategorie',''); set_value('id_souscategorie','');\"".'\'>'.$cat['nom'].'</a>';
              }
        }


          ?>
          <?php
                // Here we prepare to fetch subcategories that display in the dropdown menus
                $req = $bdd->prepare('  SELECT `ID`, `nom`, `ID_categorie`, `unite`, `prix` FROM `_global_souscategories` ORDER BY `_global_souscategories`.`ID_categorie`
                                    ');
                //execute the request
                $req->execute();

                $souscategories = $req->fetchAll();


          $current_cat=1;
          echo "<ul id='select-".$souscategories[0]['ID_categorie']."' class='dropdown-content'>";

          for ($row = 0; $row < sizeof($souscategories); $row++) {
              if ($souscategories[$row]['ID_categorie'] == $current_cat) {
                  echo "<li><a href='#".$souscategories[$row]['ID']."' ontouchstart= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."'); set_value('prix','".$souscategories[$row]['prix']."');check_default_unit('".$souscategories[$row]['unite']."', 'row_poids');\" onclick= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."'); set_value('prix','".$souscategories[$row]['prix']."'); check_default_unit('".$souscategories[$row]['unite']."', 'row_poids');\">".$souscategories[$row]['nom']."</a></li>";
              } else {
                  echo '</ul>';
                  echo "<ul id='select-".$souscategories[$row]['ID_categorie']."' class='dropdown-content'>";
                  echo "<li><a href='#".$souscategories[$row]['ID']."' ontouchstart= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."'); set_value('prix','".$souscategories[$row]['prix']."'); check_default_unit('".$souscategories[$row]['unite']."', 'row_poids');\" onclick= \"set_value('nom_souscategorie','".$souscategories[$row]['nom']."'); set_value('id_souscategorie','".$souscategories[$row]['ID']."'); set_value('prix','".$souscategories[$row]['prix']."'); check_default_unit('".$souscategories[$row]['unite']."', 'row_poids');\">".$souscategories[$row]['nom']."</a></li>";
                  $current_cat++;
              }
          }
                 ?>
               </ul>
  </div>



  <div class="container no-select" id="formulaire" style="background-color:white">


          <!-- Début du formulaire-->
          <form name="edit_form" id="edit_form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?id=<?php echo $item['ID_item']; ?>"  method="post" novalidate>

<input id="ID_item" name="ID_item" class="invisible" value="<?php echo $item['ID_item'];?>">
                <div id="row_categorisation" class ="row " >
                   <div class="col s5 m5 input-field">
                     <input id="nom_categorie" class="input_categ" name="cat" type="text" value="<?php echo $item['categorie'];?>" required readonly>
                     <input id="id_categorie"  name="cat" type="text"  value="<?php echo $item['ID_categorie'];?>" readonly hidden>

                   </div>

                   <div class="col s1 input-field center-align">
                      <p>></p>
                   </div>

                   <div class="col s5 m6 input-field">
                     <input id="nom_souscategorie" class="input_categ" name="souscat" type="text" value="<?php echo $item['sous_categorie'];?>" required readonly>
                    <input id="id_souscategorie" name="souscat" type="text" value="<?php echo $item['ID_souscategorie'];?>"  readonly hidden>
                   </div>

                 </div>



                  <div id="row_tags" class ="row input-field" >
                     <div class="input-field col s12">
                       <i class="fas fa-tag prefix"></i>
                      <input class="invisible" id="source-tags" name="tags" type="text" value="<?php echo $item['tags'];?>">

                       <input
                        class="invisible" id="input-tags" name="tags" type="text"
                        onfocus="set_active('','prefix_tags');" onblur="set_inactive('prefix_tags');">

                     </div>

                  </div>


                  <div id="row_pieces" class ="row input-field" >

                    <div class="input-field col s6" >

                      <div class="inline-group" >
                          <i id='prefix_pieces' class="fas fa-cube prefix"></i>
                          <input type="number" id="pieces" name="pieces" value="<?php echo $item['pieces'];?>" min="1" step="1" onClick="this.select();" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onchange="ValidateNonEmpty(this.id, 1)" onfocus="set_active('','prefix_pieces');" onblur="set_inactive('prefix_pieces');" style="text-align: center; width:45px; ">
                        <span class="couleur3-text no-select postfix">pièce(s)</span>
                        </div>
                    </div>

                      <div class="input-field col s4">
                        <i id="prefix_poids" class="fas fa-weight-hanging prefix"></i>
                        <label for="indicateur_poids" class="couleur3-text">Poids:</label>
                        <input type="number" id="indicateur_poids" name="poids" value="<?php echo $item['poids'];?>" min="1" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value; " style="inline; text-align:center;">
                      <span id="" class="postfix">kg</span>
                      </div>

                  </div>



                  <div id="row_etat" class ="row input-field">
                        <div class="input-field col s3 m2">
                          <i id="prefix_rating" class="fas fa-heart-broken prefix"></i>
                          <label for="range_etat" class="couleur3-text">Etat:</label>
                      </div>

                      <div class="input-field col s9 m5 no-select" id="etat_coeurs" style="max-height:53px; white-space: nowrap;">

                      <div class="rating" style="display:inline-block;" onfocus="set_active('', 'prefix_rating')" onblur="set_inactive('prefix_rating')" tabindex="-1" style="outline: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                          <span id="heart1" class="checked" onclick="checkhearts(1); set_value('etat',1)" ontouchstart="checkhearts(1); set_value('etat',1)"><i class="fas fa-heart"></i></span><span id="heart2"                 onclick="checkhearts(2); set_value('etat',2)" ontouchstart="checkhearts(2); set_value('etat',2)"><i class="fas fa-heart"></i></span><span id="heart3"                 onclick="checkhearts(3); set_value('etat',3)" ontouchstart="checkhearts(3); set_value('etat',3)"><i class="fas fa-heart"></i></span><span id="heart4"                 onclick="checkhearts(4); set_value('etat',4)" ontouchstart="checkhearts(4); set_value('etat',4)"><i class="fas fa-heart"></i></span>
                          </div>
                          <input type="number" name="etat" id="etat" value="1" class="invisible">


                      </div>

                 </div>

                 <div id="row_prix" class ="row input-field" >
                    <div class="input-field col s4 m3">
                      <i class="fas fa-coins prefix"></i>
                        <input id="prix" name="prix" type="number" value="<?php echo $item['prix'];?>" onClick="this.select();" onkeypress="return ValidateNumKeyPress(event);" onfocus="this.oldvalue = this.value;" onchange="ValidateNumber(this);this.oldvalue = this.value" style="text-align: center">
                      <label for="prix">Prix&nbsp;/&nbsp;pc</label>
                    </div>

                </div>



              <div id="champs_facultatifs" class="">
                <div class="row">
                <div class="input-field col s12">
                  <i class="fas fa-info-circle prefix"></i>
                  <textarea id="remarques" name="remarques" value="<?php if ($item['remarques'] !== '') {echo $item['remarques'];} else {echo "Pas de remarques";}?>" type="text" onchange="console.log('ajustement du textarea');this.style.height = (this.scrollHeight)+'px';"><?php if (isset($item['remarques'])) {echo $item['remarques'];} else {echo "Pas de remarques";}?></textarea>
                  <label for="remarques">Remarques :</label>
                </div>
                <div class="input-field col s12">
                  <i class="fas fa-ruler prefix"></i>
                  <input id="dimensions" name="dimensions" type="text" value="<?php if ($item['dimensions']!=='') {echo $item['dimensions'];}?>">
                  <label for="dimensions">Dimensions précises :</label>
                </div>
              </div>
                  <div class="row">
                    <div id="champ-localisation" class="input-field col s7 m9">
                      <i class="fas fa-map-marked-alt prefix"></i>
                      <input id="localisation" name="localisation" type="text" value="<?php echo $item['localisation'];?>">
                      <label for="localisation">Localisation:</label>
                    </div>

                  </div>
              </div>

              <div class="row invisible"><input id="image_final" name="image_final" type="text"></div> <!-- hidden input where the blob of the image will be stored -->



            <!-- Show modal in case of ID error -->
             <div id="modal_remove" class="modal">
               <div class="modal-content">
                 <i class="fas fa-trash-alt" style="float:right; font-size:64; color:#606060"></i>
                <h4>Êtes-vous sûr ?</h4>
                 <p>La suppression d'un objet du catalogue est irréversible. </p>
                 <p>(Si vous souhaitez vendre l'objet, utiliser la fonction "Vendre" ;) )</p>
               </div>
               <div class="modal-footer">
                 <a href="#!" class="modal-close waves-effect waves-green btn-flat" onclick="document.getElementById('action').value='remove'; document.forms['edit_form'].submit();"> OK</a>
                 <a href="#!" class="modal-close waves-effect waves-green btn-flat"> Annuler</a>
               </div>
             </div>

</div>

</div>

<div class="quasi-fullwidth">
  <div class="row">


<div class="item-buttons-container right">


     <a class="waves-effect waves-light btn-small green accent-3" name="submit_edit" id ="submit_edit" style="margin:6px;">
       Modifier
       <i class="fas fa-edit"></i>
     </a>
     <a class="waves-effect waves-light btn-small modal-trigger" href="#modal_remove"  style="background-color: #909090; margin:6px;">
        Supprimer
        <i class="fas fa-trash-alt"></i>
      </a>

      <input id="action" name="action" class="invisible" value="edit">


    <!-- https://developer.mozilla.org/en-US/docs/Learn/HTML/Forms/Form_validation -->

   </div>
  </div>
</div>

  </form>


</main>

<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/tags-input.js"></script>

<script type="text/javascript" src="js/forms.js"></script>


</script>



<script type="text/javascript" src="js/edit_form.js"></script>

<?php
/*Message de succès ou d'échec du formulaire, si $_POST['cat'] est défini*/
if (isset($_POST['action'])) {
    if ($result == 'success') {
      if ($_POST['action'] =='edit')
          {
          echo "<script>M.toast({html:\"L'objet (". $object_id .") ".$item['categorie']." - ".$item['sous_categorie']." a bien été modifié.\"})</script>";
          }
      else if
      ($_POST['action'] =='remove')
          {
            echo "<script>M.toast({html:\"L'objet (". $object_id .") ".$item['categorie']." - ".$item['sous_categorie']." a bien été supprimé.\"})</script>";
          }
    } else {
        echo $result;
    }
}
?>


  <!-- On active le composant Tabs -->
<script>
  document.addEventListener('DOMContentLoaded', function() {

document.querySelector('#submit_edit').addEventListener("click", SubmitForm);
var file_upload = document.getElementById('file_upload');
file_upload.addEventListener('change', UploadFichier); //on active le bouton d'upload de photo

    init_materialize();

      });


      function SubmitForm()
      {
        const mandatory_fields = [ 'id_categorie', 'id_souscategorie' ];
        const fields_visible_name = [ "une catégorie", "une sous-catégorie" ];
        var error_msg;
        var isOnline = window.navigator.onLine;

        if (error_msg= ValidateForm(mandatory_fields, fields_visible_name))
              {
              M.toast({html: "Formulaire incomplet !"});
              M.toast({html: error_msg });
              console.log("Erreur : formulaire incomplet"+ error_msg);
              return 0;
              }

        else if (isOnline == false)
              {
                  M.toast({html: "Pas de connexion ! Veuillez vous connectez avant d'ajouter l'objet."});
              }

        else {
               //the form is validated and we're online, so we can submit it
                window.setTimeout( function() {
                    M.toast({html: "Connexion lente, veuillez patienter..."});
                }, 5000 ); // show a Toast after 5 sec to warn of slow loading

                expand('loading_overlay'); //show loading overlay to prevent clicking
                Soumettre('edit_form'); // submit form
             }
      }

function init_materialize() {

    var remarques = document.getElementById("remarques"),
    remarques_height = remarques.scrollHeight +0;
    remarques.style.height = (remarques_height)+'px';
    console.log('ajustement du textarea : '+ remarques_height);



      // check php variable to see if an item was found
      var item_status = "<?php echo $item_status; ?>";
      if (item_status == 0)
      {
        //initialize modal_error modal
        var modal_error = document.getElementById('modal_iderror');
         var instance = M.Modal.init(modal_error, {dismissible: false});
         instance.open();
      }
      else if (item_status == 999)
      {
        expand('loading_overlay');  //show loading overlay to prevent click events
      }

      // initialize modal_remove modal on call of trigger button
      var modal_remove = document.getElementById('modal_remove');
      var instance = M.Modal.init(modal_remove);

      checkhearts(<?php echo $item['etat']; ?>); // updating hearts to match bdd "etat" variable

         var elems = document.querySelectorAll('.dropdown-trigger');
         var instance = M.Dropdown.init(elems, {
           coverTrigger: false,
           constrainWidth: false,
           outDuration: 250,
           inDuration: 0
         });
  }
</script>


</body>

<?php


//TEMPORAIRE fonction pour logger des messages PHP dans la console via console.log() en JS
  function console_log($output, $with_script_tags = true)
  {
      $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
');';
      if ($with_script_tags) {
          $js_code = '<script>' . $js_code . '</script>';
      }
      echo $js_code;
  }
?>


</html>
