<html>
<body>
  <?php
/*phpinfo();*/
?>

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>

<table>
<?php

 foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }

     ?>
  </table>

  // --------------------
  // REQUETE MYSQL ICI
  // Encoder les données dans la bdd
  // -------------------- <br />

<?php

  $unique_id = rand(100, 1000000); //A remplacer par l'ID unique à fetcher dans la DB

echo "opérations sur l'image <br />";
  $img = $_POST['image_final'];
  $img = str_replace('data:image/jpeg;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $data = base64_decode($img);


  // Create temporary file
   $local_file=fopen('php://temp', 'r+');
   fwrite($local_file, $data);
   rewind($local_file);



echo "tentative ftp <br />";



   $ftp_conn= ssh2_connect('sftp.sd3.gpaas.net', 22);
     echo "Connexion : ".$ftp_conn;
    // FTP login
    @$login_result=ssh2_auth_password($ftp_conn, '1685312', 'r3cupp0w3r');
    echo $login_result;


    $sftp = ssh2_sftp($ftp_conn);

$stream = fopen('ssh2.sftp://' . intval($sftp) . '//ftpphotos', 'r');

    // FTP upload
    if($login_result) $upload_result=ftp_fput($ftp_conn, "//ftpphotos//".$unique_id.'jpeg', $local_file, FTP_ASCII);

    // Error handling
    if(!$login_result or !$upload_result)
    {
        echo('FTP error: The file could not be written on the remote server.');
    }



</body>
</html>
