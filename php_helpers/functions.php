<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/functions/databases.php');
function getCenterPostalcodes()
{
  $array = array(
          array('center' => 'Albuquerque', 'zip' => '87008 '),
          array('center' => 'Beverly Hills', 'zip' => '90212'),
          array('center' => 'Ft. Lauderdale', 'zip' => '33334'),
          array('center' => 'Philadelphia', 'zip' => '19087'),
          array('center' => 'San Diego', 'zip' => '92110'),
          array('center' => 'Scottsdale', 'zip' => '85260'),
          array('center' => 'Tampa', 'zip' => '33607'),
          array('center' => 'The Villages', 'zip' => '32162'),
          array('center' => 'Oklahoma City', 'zip' => '73134'),
          array('center' => 'Cincinnati', 'zip' => '45242')
  );
  return $array;
}
function getOpCenterPostalcodes(){
    $sql="SELECT `name`, `center_postalcode` FROM `lcc_operation_center` WHERE center_postalcode != 'None' AND `locked` = 0";
    $result = dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
    while($r=  mysql_fetch_array($result)){
        $return[] = array('center' => $r['name'],'zip' => $r['center_postalcode']);
    }
    return $return;
    mysql_free_result($result);
}
?>
