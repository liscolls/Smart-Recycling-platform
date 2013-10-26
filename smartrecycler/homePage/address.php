<?php session_start();
//$username=$_SESSION['username'];
if(isset($_SESSION['username'])){
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
edited by chandan singh
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Address</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">


  <style type="text/css">
        #map_canvas {   
	  float: right;
  height: 268px;
    width: 388px;
	margin-top: -197px;
	}
	#latlong {
	  float: right;
	}
	#txtHint {
 width: 206px;
	}
    </style>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript">
        var map;
        var markersArray = [];

        function initMap()
        {
            var latlng = new google.maps.LatLng(41.39627393671217, 2.1391143798828125);
            var myOptions = {
                zoom: 12,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            // add a click event handler to the map object
            google.maps.event.addListener(map, "click", function(event)
            {
                // place a marker
                placeMarker(event.latLng);

              
				
				
				// display the lat/lng in your form's lat/lng fields
                document.address.latitude.value = event.latLng.lat();
                document.address.longitude.value = event.latLng.lng();

		 
	var url = 'test.php?latlng=' + event.latLng.lat() +',' + event.latLng.lng() +'&sensor=true';
		 
				// alert(url);

				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
					  	
											  
					if(xmlhttp.responseText == "wrongparameter")						  
						{
								alert("City , Country Match Not Found .")
						}
						else
						{
											  
							  var x = document.getElementById("selctdropdown").innerHTML+"<option value = '#"+xmlhttp.responseText+"#' selected>"+xmlhttp.responseText+"</option>";
							  document.getElementById("selctdropdown").innerHTML=x;

						}







					}
				  }
				xmlhttp.open("GET",url,true);
				xmlhttp.send();




 });



 
        }
        function placeMarker(location) {
            // first remove all markers if there are any
            deleteOverlays();

            var marker = new google.maps.Marker({
                position: location, 
                map: map
            });

            // add marker in markers array
            markersArray.push(marker);

            //map.setCenter(location);
        }

        // Deletes all markers in the array by removing references to them
        function deleteOverlays() {
            if (markersArray) {
                for (i in markersArray) {
                    markersArray[i].setMap(null);
                }
            markersArray.length = 0;
            }
        }

function alertContents(httpRequest){
    if (httpRequest.readyState == 4){
        // everything is good, the response is received
        if ((httpRequest.status == 200) || (httpRequest.status == 0)){
            // FIXME: perhaps a better example is to *replace* some text in the page.
            var htmlDoc=document.createElement('div'); // Create a new, empty DIV node.
            htmlDoc.innerHTML = httpRequest.responseText; // Place the returned HTML page inside the new node.
            alert( "The response was: " + httpRequest.status + httpRequest.responseText);
        }else{
            alert('There was a problem with the request. ' + httpRequest.status + httpRequest.responseText);
        }
    }
}
 
function send_with_ajax( the_url ){
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() { alertContents(httpRequest); };  
    httpRequest.open("GET", the_url, true);
    httpRequest.send(null);
}







</script>

<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
function showCustomer(str)
{
var xmlhttp;    
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","check.php?q="+str,true);
xmlhttp.send();
}
</script>

<script type="text/javascript">
function validateForm()
{

var s=document.forms["address"]["streetAddress"].value;

   if (s==null || s=="") {
    alert("streetAddress must be filled out");
    document.address.streetAddress.focus();
    return false;
  }
}
</script>

<script>
function convert_case() {
document.address.streetAddress.value =
document.address.streetAddress.value.substr(0,1).toUpperCase() + 
document.address.streetAddress.value.substr(1).toLowerCase();
}
</script>

<script type="text/javascript">
function add_city() {
var locate=document.forms["address"]["locate"].value;
var type=document.forms["address"]["type"].value;
var editid=document.forms["address"]["editid"].value;
if(type!=''){
window.location ="city.php?location="+locate+"&type="+type+"&editid="+editid;
}
else{
 window.location ="city.php?location="+locate;
}
}
</script>

<?php 
  include("serverconfig.php");
   
  $type=$_REQUEST['type'];
  $editid=$_REQUEST['editid'];
  $location=$_REQUEST['location'];

 if($type=='edit'){
  $selad="select * from address where IDAddress='$editid'";
  $exead=mysql_query($selad);
  $fetad=mysql_fetch_assoc($exead);
  
  $selad1="select * from city where IDCity='$fetad[IDCity]'";
  $exead1=mysql_query($selad1);
  $fetad1=mysql_fetch_assoc($exead1);
  
  }
	
  $selcity="select * from city";
  $exec = mysql_query($selcity);
 
  if($_REQUEST['submit']=='Submit'){
  
 

//if city id contains # ,insert in city 
$CityId = $_REQUEST['IDCity'];
$pos = strpos($CityId, "#");

	if ($pos === false) 
	  {
			  $selectedcity = "select * from city where IDCity='$_REQUEST[IDCity]'";
			  $getcity=mysql_query($selectedcity);
			  $fetchcity =mysql_fetch_assoc($getcity);
			
	  }
	  else
	  {	
			$str_explode = explode("#", $CityId);

			$cityState=$str_explode[1];
			$str_explode_again = explode(",", $cityState);

			$insertsql = "INSERT INTO city (IDCity,cityName, state,country)values('','".$str_explode_again[0]."','','".$str_explode_again[1]."')";
			mysql_query($insertsql);
			$CityId=mysql_insert_id();

			
			

	  }
  
   $street =$_REQUEST['streetAddress'];
   $north =$_REQUEST['latitude'];
   $east =$_REQUEST['longitude'];

  //$street =$street.','.$fetchcity['cityName'].','.$fetchcity['state'].','.$fetchcity['country'];
  //$whereurl = urlencode($street);
  //$location = file("http://maps.google.com/maps/geo?q=$whereurl&output=csv&key=ABQIAAAAvp3__HwvT3VkixIIbsW0axQuKI_6t1bH2P0vCI_Q8jfpn8qdNBQMnneljxh9czilkau_bYSCXteS_A");
  //list ($stat,$acc,$north,$east) = explode(",",$location[0]);
  
       if($type=='edit'){

			$ins ="update address set streetAddress='$_REQUEST[streetAddress]',latitute='$north',longitute='$east' where IDAddress='$editid'";
			$exe =mysql_query($ins);
			}else{

			$selnew="select a.IDAddress, ci.cityName, ci.country from address a, city ci where a.streetAddress='$_REQUEST[streetAddress]' and a.IDCity=ci.IDCity";
			$selexe=mysql_query($selnew);
			if(mysql_num_rows($selexe)>0){
			echo '<script>';
			echo 'alert("Address is already exist")';
			echo '</script>';
			}else{
                  
			echo $ins ="INSERT INTO address (IDCity,streetAddress,latitute,longitute)values('$CityId','$_REQUEST[streetAddress]','$north','$east')";
			mysql_query($ins);
			}
			}
	
	
		/*if($_REQUEST['location']=='bins_page' && isset($_REQUEST['type'])){
		echo('<script language="javascript">');
  		echo("window.location ='bins.php?type=$_REQUEST[type]&editid=$_REQUEST[editid]'");
  		echo('</script>');
		}
		else if($_REQUEST['location']=='centers_page' && isset($_REQUEST['type'])){
		echo('<script language="javascript">');
  		echo("window.location ='centers.php?type=$_REQUEST[type]&editid=$_REQUEST[editid]'");
  		echo('</script>');
		}
		else if($_REQUEST['location']=='bins_page'){
		echo('<script language="javascript">');
  		echo("window.location ='bins.php'");
  		echo('</script>');
		}
		else if($_REQUEST['location']=='centers_page') {
		  echo('<script language="javascript">');
  		 // echo("window.location ='centers.php'");
  		  echo('</script>');
		}
		else if($_REQUEST['location']=='address_page') {
		  echo('<script language="javascript">');
  		  echo("window.location ='address_list.php'");
  		  echo('</script>');
		}
		else {
		  echo('<script language="javascript">');
  		  echo("window.location ='address.php'");
  		  echo('</script>');
		}*/
}
    ?>
</head>
<body onload="initMap()">
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><a>SmartRecycling</a></h1>
				
			</div>
		</div>
	</div>
</div>
	<!-- end #header -->
	<?php include("menu.php");?>
	<!-- end #menu -->
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	<div id="mylogo">
		<h1><a>SmartRecycling</a></h1>
		</div>	
		
		
		<form id="form_319564" name="address" class="appnitro"  method="post" onsubmit="return validateForm()" action="address.php">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Address</p>
		</div>	
					
			<ul >
			
		<li id="li_1" >
		<label class="description" for="element_1">City </label>
		<div>
			<SELECT STYLE="width:190px" name ="IDCity" id="selctdropdown">
			<option>Select</option>
	  	<?php
		  	while($row=mysql_fetch_array($exec)) {
		if($fetad['IDCity']==$row['IDCity']){
			 echo "<option value='$row[IDCity]' selected='selected'>$row[cityName],$row[country]</option>";
			}else{
	     echo "<option value='$row[IDCity]'>$row[cityName],$row[country]</option>";}
	    }
	   ?>
	  </SELECT>
	  <input type="hidden" name="locate" value="<?php echo $location;?>" />
			<input type="button" onclick="add_city()" value="Add New" style="width:140px;" />
		</div>   </li>	
		
		<li id="li_2" >
		<label class="description" for="element_2">Street Address </label>
		<div>
			<textarea id="element_2" name="streetAddress" onkeypress="convert_case();" onchange="showCustomer(this.value)"><?php if(isset($type)){ echo $fetad['streetAddress'];}else{"";}?></textarea>
			
		</div>   </li>	
<div id="txtHint">
		<li id="li_3" >
		<label class="latitude" for="element_3"><b>Latitude</b></label>
		<div>
			<input id="element_2" name="latitude" STYLE="width:185px" value="<?php if(isset($type)){ echo $fetad['latitute'];}else{"";}?>">
			
		</div>   </li>	

		<li id="li_4" >
		<label class="longitude" for="element_4"><b>Longitude</b></label>
		<div>
			<input id="element_2" name="longitude" STYLE="width:185px" value="<?php if(isset($type)){ echo $fetad['longitute'];}else{"";}?>">
			
		</div>   </li>	
		
</div>		

<div id="map_canvas"></div>
<div id="latlong">
    <input type="hidden" id="latFld">
    <input type="hidden" id="lngFld">
</div>


		<li class="buttons">
			    <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
			    <input type="hidden" name="location" value="<?php echo $_REQUEST['location']; ?>">
<input type="hidden" name="type" value="<?php echo $_REQUEST['type']; ?>">
<input type="hidden" name="editid" value="<?php echo $_REQUEST['editid']; ?>">
		    </li>
			</ul>
			
			</form>
		</div> 

		<img id="bottom" src="bottom.png" alt="">
	<!-- end #page -->

<div id="footer">
	<p>Design By </a></p>
</div>
<!-- end #footer -->
</body>
</html>
<?php
}
else{
 echo "your session expired";
 echo "<p><a href='http://appsmartrecycling.es/antigua/smartrecycler/login/login.php'>click to login</a></p>";
}
?>