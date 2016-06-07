<?php
    $driver = 'mysql:host=localhost;dbname=helpdesk'; //make sure host and dbname are correct
    $user = ''; //username to access database here
    $pass = ''; //password goes here
    $attr = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
?>
