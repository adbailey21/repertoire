<?php

session_start();

$_CONFIGS['default_band_id'] = '1';
$_CONFIGS['site_title'] = 'Rhythm Red Devils';


$servername = "db722159157.db.1and1.com";
$username = "dbo722159157";
$password = "playlist@123";
$db = "db722159157";

$con=mysqli_connect($servername,$username,$password,$db);

// Check connection

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>