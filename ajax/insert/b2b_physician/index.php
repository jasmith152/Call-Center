<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/functions/databases.php';
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = (!$_POST['phone'])?'NULL':"'".$_POST['phone']."'";
$sql = "INSERT INTO contacts (`First Name`,`Last name`,`Business Phone`,`User Name`) VALUES ('".$fname."','".$lname."',".$phone.",'".$_SESSION['cc_user']." ".$_SESSION['cc_user_lname']."')";
$id = dbcon('mysql', 'lcc_ins', 'lsi_b2b_center', $sql);
echo $id;
?>
