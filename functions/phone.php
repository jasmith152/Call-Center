<?
function prettyPhone($value){
	$value = preg_replace("/[^0-9]/", "", $value);
	if((!$value || $value == '')&& strlen($value) <> 10){
		$return = "N/A";
	}
	else
	{
	$pp1rev=strrev($value);
	$pp1rev=substr($pp1rev, 0, 10);
	$pp1rev1=substr($pp1rev, 0, 4);
	$pp1rev2=substr($pp1rev, 4, 3);
	$pp1rev3=substr($pp1rev, 7, 3);
	$pparray=array($pp1rev1, "-", $pp1rev2, " ",  ")", $pp1rev3, "(");
	$pparray = implode($pparray);
	$return=strrev($pparray);
	}
	return $return;
}
?>