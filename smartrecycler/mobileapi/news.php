<?php 
include("database.php");
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
	$shownewslist['newsList']=array();
}else{
        $shownewslist['status']="200";
}
  // Everything went right.
  return $shownewslist;
}
function newslist_load($searchterm) 
{
$v=$searchterm;
$x = str_replace(chr(226),'"',$v);
$x = str_replace(chr(128),'',$x);
$x = str_replace(chr(156),'',$x);
$x = str_replace(chr(157),'',$x);
$x = str_replace("\\",'',$x);
$param=json_decode($x,true);

		$sel="select nw.IDNews as newsid, nw.title, nw.descriptionNews as descritpion, nw.rssUrl as rssurl, ty.nameTypeNews as newstype from news nw, typenews ty where nw.IDTypeNews=ty.IDTypeNews order by IDNews desc";
		$exe=mysql_query($sel);

        $i=0;
        $shownewslist=array(); 
        while($row = mysql_fetch_assoc($exe))
        {
		$shownewslist['newsList'][]=$row;
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