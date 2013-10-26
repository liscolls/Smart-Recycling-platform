<?php
$latlang=$_GET['latlng'];

$getlatlang=explode(",",$latlang);
$latitude = $getlatlang[0]; 

$longitude = $getlatlang[1];

$json = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$latlang.'&sensor=false');

$array = json_decode($json);

$city = $array->results[0]->address_components[4]->long_name;
$country = $array->results[0]->address_components[5]->long_name;

if(is_numeric($city) || is_numeric($country) || $city == "" || $country == "")
{
 
		echo "wrongparameter";
}
 else
 {
		echo $array->results[0]->address_components[4]->long_name.", ".$array->results[0]->address_components[5]->long_name;
 }
?>