<?php

// error message validation function

function error($msg){
  return "<p style='color:red; font-size:13px; padding:5px 0px;'>$msg</p>";
}


// email function

function emailcheck($table , $col , $val){
  global $way;
  $check = $way -> query ("SELECT $col FROM $table WHERE $col = '$val' ");
  return  $check -> num_rows ;
}


?>