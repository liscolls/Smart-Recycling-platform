<?php 
include("database.php");

$full_path = $_SERVER['SERVER_NAME'];
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 2];

$path=explode($currentFile, $full_path);
$urlnew = $path[0]."homePage";

function distance($lat1, $lon1, $lat2, $lon2, $unit) { 
  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344); 
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}
function newslist_service_get($searchterm) {
  $shownewslist = newslist_load($searchterm);
  if (empty($shownewslist)) {
        $shownewslist['status']="200";
	$shownewslist['binsList']=array();
}else{
        $shownewslist['status']="200";
}
  // Everything went right.
  return $shownewslist;
}
function newslist_load($searchterm) 
{
	$full_path = $_SERVER['SERVER_NAME'];
$v=$searchterm;
$x = str_replace(chr(226),'"',$v);
$x = str_replace(chr(128),'',$x);
$x = str_replace(chr(156),'',$x);
$x = str_replace(chr(157),'',$x);
$x = str_replace("\\",'',$x);
$param=json_decode($x,true);

		$sql="select bi.IDBin as binid, bi.imageName as url, bi.name, bi.hashtag, bi.status, bi.IDAddress, gm.name as groupmaterial from bins bi, groupmaterial gm where bi.IDGroupMaterial=gm.IDGroupMaterial";
		$exe=mysql_query($sql);
		$shownewslist=array();
        $i=0;
        while($fet = mysql_fetch_assoc($exe))
        {
				$sql2="select ad.streetAddress as streetaddress, ci.cityName as city, ci.country as country, ad.latitute as latitude, ad.longitute as longitude from address ad, city ci where ad.IDAddress='$fet[IDAddress]' and ad.IDCity=ci.IDCity";
				$exe2=mysql_query($sql2);
				$fet2=mysql_fetch_assoc($exe2);
				unset($fet['IDAddress']);

				$fet['address']=$fet2;

				if($fet['url']!="")
				{
					 
					$fet['imgurl']=$full_path ."/antigua/smartrecycler/homePage/imageapp/scaled_".$fet['url'];
				}

				$shownewslist['binsList'][]=$fet; 


				$i++;


        } 
	    return $shownewslist;
}
if($_POST['requestbody']){
        $x=newslist_service_get($_POST['requestbody']);
}else{
        $x['status'] = "201";
}
echo json_encode($x);	
?>			