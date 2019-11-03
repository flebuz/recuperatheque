
<?php
//connection database
try{
  $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  // $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'webappdev', 'datarecoulechemindejerusalem', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

}
catch(Exception $e){
  die('Erreur : '.$e->getMessage());
}
?>

<?php
  //fonction pratique
  function link_construct($params, $web_page = 1){
    //crée un lien vers $web_page, dont les params GET sont ceux précisé dans $params + ceux déjà la
    if ($web_page==1){
      $web_page = basename($_SERVER['PHP_SELF']);
    }
    $getURL = $web_page . '?' . http_build_query(array_merge($_GET, $params));
    return $getURL;
  }
?>
