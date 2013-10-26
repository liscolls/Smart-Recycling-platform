<?php session_start();
//echo $_POST['requestbody'];

include("database.php");
function exchangelist_service_get($searchterm) {
  $exchangelist = exchangelist_load($searchterm);
  if (empty($exchangelist)) {
        $exchangelist['status']="200";
	$exchangelist['exchangeList']=array();
}else{
        $exchangelist['status']="200";
}
  // Everything went right.
  return $exchangelist;
}

function exchangelist_load($searchterm) 
{
$full_path = $_SERVER['SERVER_NAME'];
$v=$_POST['requestbody'];
$x = str_replace(chr(226),'"',$v);
$x = str_replace(chr(128),'',$x);
$x = str_replace(chr(156),'',$x);
$x = str_replace(chr(157),'',$x);
$x = str_replace("\\",'',$x);
$param=json_decode($x,true);

if($param['type']=='exchangeList'){
   $sql = "select IDExchanges as exchangeid, ObjectName as name, Description as description, WebSite as weburl, InicDate as startdate, EndDate as enddate, imageName as imgpath from exchanges order by IDExchanges desc";
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

$showexchangelist['exchangeList'][$i]=$row;


			$i++;
        }  
}else if($param['type']=='exchangeDetail'){
		
		$sql = "select ex.IDMaterial, gm.name as groupmaterial, st.SetoffName as setoff from exchanges ex, groupmaterial gm, setoff st where IDExchanges='$param[exchangeid]' and ex.IDGroupMaterial=gm.IDGroupMaterial and ex.IdSetoff=st.IdSetoff";
        $result = mysql_query($sql);
        $row = mysql_fetch_assoc($result);
 
		$sql1="select IDMaterial as materialid, Name as name, information from material where IDMaterial='$row[IDMaterial]'";
		$exe1=mysql_query($sql1);
		$fet1=mysql_fetch_assoc($exe1);
		
		$sql4="select IDCenter from exchangecenter where IdExchange='$param[exchangeid]'";
		$exe4=mysql_query($sql4);
		$i=0;
			$cente=array();
		while ($fet4=mysql_fetch_assoc($exe4))
	{
		
		$sql5="select cen.IDCenters as centerid, cen.name, telephone, cen.webSite as weburl, cen.IDAddress, gc.name as groupcenter from centers cen, groupcenter gc where cen.IDCenters='$fet4[IDCenter]' and cen.IDGroupCenter=gc.IDGroupCenter";
		$exe5=mysql_query($sql5);
	
		
		$fet5=mysql_fetch_assoc($exe5);


		$sql6="select ad.streetAddress as streetaddress, ci.cityName as city, ci.country, ad.latitute as latitude, ad.longitute as longitude from address ad, city ci where ad.IDAddress='$fet5[IDAddress]' and ad.IDCity=ci.IDCity";
		$exe6=mysql_query($sql6);
		$fet6=mysql_fetch_assoc($exe6);
		
		
		 $fet5['address']=$fet6;

		 

		unset($fet5['IDAddress']);
		unset($row['IDMaterial']);










		$cente[$i]=$fet5;
		
		$i++;
	}
		
		

	if(count($fet6) > 0)
	{
		$fet5['address']=$fet6;
	}
	if(count($fet1) > 0)
	{
		$row['material']=$fet1;
	}
	if(count($cente) > 0)
	{
		$row['centers']=$cente;
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
