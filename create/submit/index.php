<?php
session_start();
?>
<?php
foreach($_POST as $key => $value){
  if($value !== '' && !stristr($key,'seminar')){
    $fields[] = $key;
  }
  if($value !== '' && stristr($key,'seminar')){
    $seminar_fields[] = $key;
  }
}
print_r($fields);
print_r($seminar_fields);
?>