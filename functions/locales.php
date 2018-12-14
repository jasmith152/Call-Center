<div id="locales">
<div>
<?php
if($lcc_contact_postal && $lcc_contact_postal <> ''){
include 'dbcon/config.php';
include 'dbcon/opendb.php';
$bhills_postal = '90212';
$flauderdale_postal = '33334';
$philly_postal = '19087';
$san_diego_postal = '92110';
$scottsdale_postal = '85260';
$tampa_postal = '33607';
$villages_postal = '32162';
$okcity_postal = '73134';
$milage = '100';

function degrees_difference($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            cos(deg2rad($theta));

    $dist = acos($dist);
    $dist = rad2deg($dist);

    $distance = $dist * 60 * 1.1515;

    return $distance;
}

function difference_between($firstzip, $secondzip)
{
    $query = "select ZipCode,`Latitude` AS lat, `Longitude` AS lon from zipcode where ZipCode in ('".$firstzip."','".$secondzip."') AND PrimaryRecord = 'P'";
    $result = mysql_query($query) or die(mysql_error());

    $firstzips = mysql_fetch_array($result);
    $secondzips = mysql_fetch_array($result);

    return degrees_difference($firstzips['lat'], $firstzips['lon'], $secondzips['lat'], $secondzips['lon']);
}

function get_zips_within($zip, $miles)
{
    $milesperdegree = 69;
    $degreesdiff = $miles / $milesperdegree;

    $query = "select `Latitude` AS lat, `Longitude` AS lon from zipcode where ZipCode = '$zip' AND PrimaryRecord = 'P'";
    $result = mysql_query($query);
    $latlong = mysql_fetch_assoc($result);

    $lat1 = $latlong['lat'] - $degreesdiff;
    $lat2 = $latlong['lat'] + $degreesdiff;
    $lon1 = $latlong['lon'] - $degreesdiff;
    $lon2 = $latlong['lon'] + $degreesdiff;

    $query = "select ZipCode from zipcode where `Latitude` between '$lat1' and '$lat2' and `Longitude` between '$lon1' and '$lon2' AND PrimaryRecord = 'P'";

    $result = mysql_query($query);

    $zips = array();
    while ($row = mysql_fetch_assoc($result)) {
        $zips[] = $row['ZipCode'];
    }

    return $zips;
}

$zips = get_zips_within($lcc_contact_postal, $milage);
if(in_array($villages_postal,$zips)){$villages_prox = 1;}
if(in_array($san_diego_postal,$zips)){$san_diego_prox = 1;}
if(in_array($philly_postal,$zips)){$philly_prox = 1;}
if(in_array($scottsdale_postal,$zips)){$scottsdale_prox = 1;}
if(in_array($tampa_postal,$zips)){$tampa_prox = 1;}
if(in_array($bhills_postal,$zips)){$bhills_prox = 1;}
if(in_array($flauderdale_postal,$zips)){$flauderdale_prox = 1;}
if(in_array($okcity_postal,$zips)){$okcity_prox = 1;}
$villages_dis = round(difference_between($lcc_contact_postal,$villages_postal),2);
$san_diego_dis = round(difference_between($lcc_contact_postal,$san_diego_postal),2);
$philly_dis = round(difference_between($lcc_contact_postal,$philly_postal),2);
$scottsdale_dis = round(difference_between($lcc_contact_postal,$scottsdale_postal),2);
$tampa_dis = round(difference_between($lcc_contact_postal,$tampa_postal),2);
$tampa_dis = round(difference_between($lcc_contact_postal,$tampa_postal),2);
$bhills_dis = round(difference_between($lcc_contact_postal,$bhills_postal),2);
$flauderdale_dis = round(difference_between($lcc_contact_postal,$flauderdale_postal),2);
$okcity_dis = round(difference_between($lcc_contact_postal,$okcity_postal),2);
include 'dbcon/pcc_closedb.php';
echo '
<table border="0" cellpadding="1" cellspacing="1" width="100%" height="99%">
<tr>
<td align="center" bgcolor="#C4DEE6">';if($bhills_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td bgcolor="#C4DEE6">Bev. Hills</td>
<td align="right" bgcolor="#C4DEE6">';if($lcc_contact_postal == $bhills_postal){echo '0';}else{echo $bhills_dis;}echo' miles</td>
</tr>
<tr>
<td align="center">';if($flauderdale_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td>Ft. Laud.</td>
<td align="right">';if($lcc_contact_postal == $flauderdale_postal){echo '0';}else{echo $flauderdale_dis;}echo' miles</td>
</tr>
<tr>
<td align="center" bgcolor="#C4DEE6">';if($philly_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td bgcolor="#C4DEE6">Philly</td>
<td align="right" bgcolor="#C4DEE6">';if($lcc_contact_postal == $philly_postal){echo '0';}else{echo $philly_dis;}echo' miles</td>
</tr>
<tr>
<tr>
<td align="center">';if($san_diego_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td>San Diego</td>
<td align="right">'.$san_diego_dis.' miles</td>
</tr>
<td align="center" bgcolor="#C4DEE6">';if($scottsdale_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td bgcolor="#C4DEE6">Scottsdale</td>
<td align="right" bgcolor="#C4DEE6">';if($lcc_contact_postal == $scottsdale_postal){echo '0';}else{echo $scottsdale_dis;}echo' miles</td>
</tr>
<tr>
<td align="center">';if($tampa_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td>Tampa</td>
<td align="right">';if($lcc_contact_postal == $tampa_postal){echo '0';}else{echo $tampa_dis;}echo' miles</td>
</tr>
<tr>
<td align="center" bgcolor="#C4DEE6">';if($villages_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td bgcolor="#C4DEE6">The Villages</td>
<td align="right" bgcolor="#C4DEE6">';if($lcc_contact_postal == $villages_postal){echo '0';}else{echo $villages_dis;}echo' miles</td>
</tr>
<tr>
<td align="center">';if($okcity_prox == 1){echo '<img src="images/checkmark.gif">';}else{echo '<img src="images/denied.png">';} echo'</td>
<td>Oklahoma City</td>
<td align="right">';if($lcc_contact_postal == $okcity_postal){echo '0';}else{echo $okcity_dis;}echo' miles</td>
</tr>
</table>';
}
?>
</div>
</div>
