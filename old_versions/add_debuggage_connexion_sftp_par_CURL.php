<html>
<body>
  <?php

  // At start of script
  $time_start = microtime(true);
  echo '<span style="color:red; ">Début de page : ' . (microtime(true) - $time_start)."</span><br />";
/*phpinfo();*/
?>

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);


if (function_exists('ssh2_connect')) {
echo "Les fonctions SSH2 sont disponibles.";
} else {
echo "Les fonctions SSH2 ne sont pas disponibles.";
}

?>

<table>
<?php
// At start of script
$time_start = microtime(true);

// Anywhere else in the script
echo '<span style="color:red; ">Avant tableau : ' . (microtime(true) - $time_start)."</span><br />";
/*
 foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        if ($key=="image_final")
        {    $extrait = substr($value, 0, 30);
             echo $extrait.'...';
        }
          else
        {
          echo $value;
        }
        echo "</td>";
        echo "</tr>";
    }
*/
echo '<span style="color:red; ">après tableau : ' . (microtime(true) - $time_start)."</span><br />";
    //connection database
    try{
      $bdd = new PDO('mysql:host=localhost;dbname=recuperatheques;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }

      //prep the request
      $req = $bdd->prepare('  SELECT MAX(`ID`)  AS `greatestID` FROM `catalogue`
                          ');
      //execute the request
      $req->execute();

    $object_id= $req->fetchColumn() + 1;

echo '<span style="color:red; ">après 1er accès bdd : ' . (microtime(true) - $time_start)."</span><br />";

    echo "<tr>";
    echo "<td>";
    echo "Object ID : ";
    echo "</td>";
    echo "<td>";
    echo $object_id;
    echo "</td></tr>";



$categorie = $_POST['cat'];
$souscategorie = $_POST['souscat'];
$tags = $_POST['tags'];
$pieces = $_POST['pieces'];
$poids= $_POST['poids'];
$etat= $_POST['etat'];
$prix= $_POST['prix'];
$remarques= $_POST['remarques'];
$dimensions= $_POST['dimensions'];
$localisation = $_POST['localisation'];
$today = date('Y-m-d');


$description="champ obsolète"; //à supprimer de la bdd et des requêtes
?>

</table>



<br /><br />
<?php
/*
  // --------------------
  // REQUETE MYSQL ICI
  // Encoder les données dans la bdd
  // --------------------
*/

echo '<span style="color:red; ">Avant requête INSERT : ' . (microtime(true) - $time_start)."</span><br />";
try {


    /*$req = "INSERT INTO catalogue (ID, ID_categorie ,	ID_souscategorie, nombre, mesure, état, tags, description, date_ajout  )
    VALUES ($object_id, $categorie, $souscategorie, '$pieces', '$poids', '$etat', '$tags', 'pas de description', '$today')";*/

    $req = $bdd ->prepare("INSERT INTO catalogue (ID, ID_categorie ,	ID_souscategorie, nombre, mesure, état, tags, description, date_ajout) VALUES (:ID, :ID_categorie ,	:ID_souscategorie, :nombre, :mesure, :etat, :tags, :description, :date_ajout)");
$req->bindParam(':ID', $object_id);
$req->bindParam(':ID_categorie', $categorie);
$req->bindParam(':ID_souscategorie', $souscategorie);
$req->bindParam(':nombre', $pieces);
$req->bindParam(':mesure', $poids);
$req->bindParam(':etat', $etat);
$req->bindParam(':tags', $tags);
$req->bindParam(':description', $description);
$req->bindParam(':date_ajout', $today);


    $req->execute();
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo  $e->getMessage();
    }

echo '<span style="color:red; ">Après requête INSERT : ' . (microtime(true) - $time_start)."</span><br />";

echo "Opérations sur l'image... <br />";
  $img = $_POST['image_final'];
  $img = str_replace('data:image/jpeg;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);


  // Create temporary file
   $local_file=fopen('php://temp', 'r+');
   fwrite($local_file, $data);
   rewind($local_file);



echo "Connexion au ftp... <br />";

/*
echo '<span style="color:red; ">Avant connexion FTP : ' . (microtime(true) - $time_start)."</span><br />";
   $ftp_conn= ftp_connect('sftp.sd3.gpaas.net', 22);
echo '<span style="color:red; ">Après ftp_connect : ' . (microtime(true) - $time_start)."</span><br />";*/
   echo "Conneté. <br />";

$i =1;

echo $_SERVER["DOCUMENT_ROOT"];
    // FTP login
    $host = 'sftp.sd3.gpaas.net';
    $port = 22;
    $username = '1685312';
    $password = 'r3cupp0w3r';
    $remotePath = '/vhosts/federation.recuperatheque.org/htdocs/photos/gaga.jpg';
    $remoteFilePath = getcwd().'/photos/'.$object_id.'.jpg';
    $ch = curl_init("sftp://$username:$password@$host$remotePath");
    echo '<span style="color:red; ">Après curl_init : ' . (microtime(true) - $time_start)."</span><br />";
    curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
curl_setopt($ch, CURLOPT_SSH_AUTH_TYPES, CURLSSH_AUTH_PUBLICKEY);
curl_setopt($ch, CURLOPT_SSH_PUBLIC_KEYFILE, $_SERVER["DOCUMENT_ROOT"]."/home/.ssh/id_rsa.pub");
curl_setopt($ch, CURLOPT_SSH_PRIVATE_KEYFILE, $_SERVER["DOCUMENT_ROOT"]."/home/.ssh/id_rsa");
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  echo '<span style="color:red; ">avant curl_exec : ' . (microtime(true) - $time_start)."</span><br />";
    $response= curl_exec ($ch);
      echo '<span style="color:red; ">après curl_exec : ' . (microtime(true) - $time_start)."</span><br />";
    curl_close ($ch);


  echo '<span style="color:red; ">avant file_put_contents : ' . (microtime(true) - $time_start)."</span><br />";
    file_put_contents($remoteFilePath, $local_file);
  echo '<span style="color:red; ">après file_put_contents : ' . (microtime(true) - $time_start)."</span><br />";

  ?>




</body>
</html>
