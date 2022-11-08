<?php

$post_type_includes = [
  'inc/methods/remove-empty-paragraph.php',
];

foreach ($post_type_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'seiu'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}


function phone_number_format($number) {
  // Allow only Digits, remove all other characters.
  $number = preg_replace("/[^\d]/","",$number);
 
  // get number length.
  $length = strlen($number);
 
 // if number = 10
 if($length == 10) {
  $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $number);
 }
  
  return $number;

}