<?php
include("serverconfig.php");
$street =$_GET['q'];

$sel= "select IDCity from address where streetAddress='$street'";
$exe=mysql_query($sel);
$fet=mysql_fetch_assoc($exe);

$selectedcity = "select * from city where IDCity='$fet[IDCity]'";
$getcity=mysql_query($selectedcity);
$fetchcity =mysql_fetch_assoc($getcity);
 
  $street =$street.','.$fetchcity['cityName'].','.$fetchcity['country'];
  $whereurl = urlencode($street);
  $location = file("http://maps.google.com/maps/geo?q=$whereurl&output=csv&key=ABQIAAAAvp3__HwvT3VkixIIbsW0axQuKI_6t1bH2P0vCI_Q8jfpn8qdNBQMnneljxh9czilkau_bYSCXteS_A");
  list ($stat,$acc,$north,$east) = explode(",",$location[0]);
?>

<li id="li_3" >
		<label class="latitude" for="element_3"><b>Latitude</b></label>
		<div>
			<input id="element_2" name="latitude" STYLE="width:185px" value="<?php echo $north;?>">
			
		</div>   </li>	

		<li id="li_4" >
		<label class="longitude" for="element_4"><b>Longitude</b></label>
		<div>
			<input id="element_2" name="longitude" STYLE="width:185px" value="<?php echo $east;?>">
		
 
