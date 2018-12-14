<?php
include $_SERVER['DOCUMENT_ROOT'] . '/functions/databases.php';
function createNew()
{
    $sql = "INSERT INTO `chris_mom` SET device = 'my_penis' LIMIT 1 stroke";
    $result = @dbcon('mysql', 'lcc', 'lsi_call_center', $sql);
    return $result;
}
?>
