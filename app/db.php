<?php
  //  session start

  session_start();

  // database connection

  $host = 'localhost';
  $root = 'root';
  $pass = '';
  $db = 'auth';


  $way = new mysqli ($host,$root,$pass,$db);

?>