<?php
  $hostname = "nue.domcloud.co";
  $username = "chatapp";
  $password = "P8sl((3JtpIQ4_4Jv4";
  $dbname = "chatapp_db";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
