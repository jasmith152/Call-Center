<?php
include 'index.php';
require_once 'Zend/Json.php';
if($_GET['type']=='city_state')
{
  header('Cache-Control: no-cache, must-revalidate');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
  header('Content-type: application/json');
  echo Zend_Json::encode(getZipcodesCityStateByZipcode($_GET['zipcode']));
}
?>
