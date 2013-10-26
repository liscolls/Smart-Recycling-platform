<?php
include("database.php");
function exchangelist_service_get($searchterm) {
  $exchangelist = exchangelist_load($searchterm);
  if (empty($exchangelist)) {
        $exchangelist['status']="200";
	  $exchangelist['centers']=array();
}else{
        $exchangelist['status']="200";
}
  // Everything went right.
  return $exchangelist;
}

function exchangelist_load($searchterm) 
{
$full_path = $_SERVER['SERVER_NAME'];
$v=$searchterm;
$x = str_replace(chr(226),'"',$v);
$x = str_replace(chr(128),'',$x);
$x = str_replace(chr(156),'',$x);
$x = str_replace(chr(157),'',$x);
$x = str_replace("\\",'',$x);
$param=json_decode($x,true);
if($param['type']=='materialList'){
    $sql = "select IDMaterial as materialid, Name as name,  imageName as imgpath,  information from material order by IDMaterial desc";
        $result = mysql_query($sql);
        $i=0;
        $showexchangelist=array(); 
        while($row = mysql_fetch_assoc($result))
        {
			if($row['imgpath']!="")
			{
			$row['imgurl']=$full_path ."/antigua/smartrecycler/homePage/imageapp/scaled_".$row['imgpath'];
			}


			unset($row['imgpath']); 
			$showexchangelist['materialList'][$i]=$row;
			
			
			$i++;
        }  
}
else if($param['type']=='materialDetail'){
	$sql1="select gm.name as groupmaterial, gc.IDGroupCenter, gc.name as groupcenter from material m, groupmaterial gm, groupcenter gc where m.IDMaterial='$param[materialid]' and m.IDGroupMaterial=gm.IDGroupMaterial and m.IDGroupCenter=gc.IDGroupCenter";
	$exe1=mysql_query($sql1);
	$row=mysql_fetch_assoc($exe1);
	
	 $sql5="select cen.IDCenters as centerid, cen.name, cen.telephone, cen.webSite as weburl, cen.IDAddress, cen.IDGroupCenter from centers cen, centermaterial cm, material m where m.IDMaterial='$param[materialid]' and  cm.IDMaterial=m.IDMaterial and cm.IDCenter=cen.IDcenters";
	$exe5=mysql_query($sql5);
	//$fet5=mysql_fetch_assoc($exe5);
	
	/*
	if(mysql_num_rows($exe5)){	
	$sql6="select ad.streetAddress as streetaddress, ci.cityName as city, ci.country, ad.latitute as latitude, ad.longitute as longitude from address ad, city ci where IDAddress='$fet5[IDAddress]'";
	$exe6=mysql_query($sql6);
	$fet6=mysql_fetch_assoc($exe6);
	$fet5['address']=$fet6;
      $fet5['groupcenter']=$row['groupcenter'];
      }	
*/
if($row['imgpath']!="")
	{
		$row['imgurl']=$full_path ."/antigua/smartrecycler/homePage/imageapp/scaled_".$row['imgpath'];
		unset($row['imgpath']);
		unset($row['IDGroupCenter']);
	}
	while($rowcen = mysql_fetch_assoc($exe5))
        {
			$centerId=$rowcen['IDAddress'];

			 $sql6="select ad.streetAddress as streetaddress, ci.cityName as city, ci.country, ad.latitute as latitude, ad.longitute as longitude from address ad, city ci where ad.IDAddress='$centerId' and ad.IDCity=ci.IDCity";
			$exe6=mysql_query($sql6);
			$fet6=mysql_fetch_assoc($exe6);

			

	 
            $rowcen['address']=$fet6;

			 unset($rowcen['IDGroupCenter']);
			unset($rowcen['IDAddress']);


			$row['centers'][]=$rowcen;
		}


		$showexchangelist=array();
	    $showexchangelist=$row;
	}     







        return $showexchangelist;
}
if($_POST['requestbody']){
        $x=exchangelist_service_get($_POST['requestbody']);
}else{
        $x['status'] = "201";
}
echo json_encode($x);
?>