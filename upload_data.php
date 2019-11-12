<?php
    session_start();

    $userid = $_SESSION['userId'];
    require_once 'classes/dbh.class.php';

    /*Canvas image that is created in capture upload is sent to this file using ajax.
    Randomly change the name of the files. Save image into uploads file.*/

    $upload_dir = "assets/images/user/";
    $img = $_POST['hidden_data'];
    $img = str_replace('data:image/png;base64,','', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $fileNewName = uniqid('', true) . ".png";
    $move = $upload_dir . $fileNewName;
    file_put_contents($move, $data);

    //inssrt image into database
    $dbh = new Dbh();
    $dbh->setImage($userid, $fileNewName);
?>
