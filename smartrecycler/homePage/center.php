<?php session_start();
include("database.php");
function centerlist_service_get($searchterm) {
  $centerlist = centerlist_load($searchterm);
  if (empty($centerlist)) {
        $centerlist['status']="200";
		$centerlist['centersList']=array();
}else{
        $centerlist['status']="200";
}
  // Everything went right.
  return $centerlist;
}

function centerlist_load($searchterm) 
{
$full_path = $_SERVER['SERVER_NAME'];
$v=$searchterm;
$x = str_replace(chr(226),'"',$v);
$x = str_replace(chr(128),'',$x);
$x = str_replace(chr(156),'',$x);
$x = str_replace(chr(157),'',$x);
$x = str_replace("\\",'',$x);
$param=json_decode($x,true);
if($param['type']=='centersList'){
	$full_path = $_SERVER['SERVER_NAME'];
    $sql = "select cen.IDCenters as centerid, cen.name, cen.telephone, cen.webSite as weburl, cen.description, gc.name as groupcenter,cen.IDAddress,cen.IDGroupCenter, cen.imageName as imgpath from centers cen, groupcenter gc where cen.IDGroupCenter=gc.IDGroupCenter";
    $result = mysql_query($sql);
    $i=0;
    $showcenterlist=array(); 
    while($row = mysql_fetch_assoc($result)){
$sql1 = "select ad.streetAddress as streetaddress, ci.cityName as city, ci.country, ad.latitute as latitude, ad.longitute as longitude  from address ad,city ci where ad.IDAddress='$row[IDAddress]' and ad.IDCity=ci.IDCity";
$exe1=mysql_query($sql1);
$fet1=mysql_fetch_assoc($exe1);	
$row['address']=$fet1;	

echo $sql3="select IDMaterial as materialid, Name as name, information from material where IDGroupCenter='$row[IDGroupCenter]'";
$exe3=mysql_query($sql3);
$j=0;
while($fet3=mysql_fetch_assoc($exe3)){
$row['materials'][] =$fet3;
$j++;
}

$row['imgurl']=$full_path ."/antigua/smartrecycler/homePage/imageapp/scaled_".$row['imgpath'];




 
unset($row['imgpath']); 
unset($row['IDAddress']); 
$showcenterlist['centersList'][$i]=$row;



$i++;
}  
}else{
 $sql = "select * from exchangecenter where IDCenter='$param[centerid]'";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
 
		$sql2="select IDExchanges as exchangeid, ObjectName as name, WebSite as weburl, InicDate as startdate, EndDate as enddate, IDMaterial from exchanges where IDExchanges='$row[IDExchange]'";
		$exe2=mysql_query($sql2);
		$fet2=mysql_fetch_assoc($exe2);
 
    	     /* $sql3="select IDMaterial as materialid, Name as name, information from material where IDMaterial='$fet2[IDMaterial]'";
		$exe3=mysql_query($sql3);
		$fet3=mysql_fetch_assoc($exe3);*/
			
		unset($fet2['IDMaterial']);
		unset($row['IDExchange']);
		unset($row['IDCenter']);
		
		//$row['materials'][]=$fet3;
		$row['exchanges'][]=$fet2;
		
		$showcenterlist=array();
            $showcenterlist=$row;

}		
        return $showcenterlist;
}
if($_POST['requestbody']){
        $x=centerlist_service_get($_POST['requestbody']);
}else{
        $x['status'] = "201";
}
echo json_encode($x);
?>
