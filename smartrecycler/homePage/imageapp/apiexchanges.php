<?php 
include("serverconfig.php");
ob_start();
$IDMaterial = $_REQUEST['IDMaterial'];
$IDGroupMaterial = $_REQUEST['IDGroupMaterial'];
$IDSetoff = $_REQUEST['IDSetoff'];
$ObjectName = $_REQUEST['ObjectName'];
$Description = $_REQUEST['Description'];
$WebSite = $_REQUEST['WebSite'];
$validate = $_REQUEST['validate'];
$InicDatemm = $_REQUEST['InicDatemm'];
$InicDatedd = $_REQUEST['InicDatedd'];
$InicDateyy = $_REQUEST['InicDateyy'];

if(strlen($InicDatedd)<2)
{
$d='0'.$InicDatedd;
}else{
$d=$InicDatedd;
}
$InicDate = $d.'/'.$InicDatemm.'/'.$InicDateyy;

$EndDatemm = $_REQUEST['EndDatemm'];
$EndDatedd = $_REQUEST['EndDatedd'];
$EndDateyy = $_REQUEST['EndDateyy'];

if(strlen($EndDatedd)<2)
{
$d='0'.$EndDatedd;
}else{
$d=$EndDatedd;
}
$EndDate = $d.'/'.$EndDatemm.'/'.$EndDateyy;
$IDCenter=$_REQUEST['IDCenter'];
$c=count($IDCenter);

$id = $_REQUEST['id'];
$action=$_REQUEST['action'];
 



 
$t=time();
move_uploaded_file($_FILES["imageupload"]["tmp_name"],"imageapp/".$t."_". $_FILES["imageupload"]["name"]);
copy("imageapp/".$t."_". $_FILES["imageupload"]["name"], "imageapp/scaled_".$t."_". $_FILES["imageupload"]["name"]);
 // echo "Stored in: " . "imageapp/" . $_FILES["imageupload"]["name"];
list($image_width, $image_height) = getimagesize("imageapp/scaled_".$t."_". $_FILES["imageupload"]["name"]);
$remote_file = "imageapp/scaled_".$t."_". $_FILES["imageupload"]["name"];
$new_image = imagecreatetruecolor(60 , 60);
$image_source = imagecreatefromjpeg("imageapp/scaled_".$t."_". $_FILES["imageupload"]["name"]);
imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, 60, 60, $image_width, $image_height);
imagejpeg($new_image,$remote_file,100);
//imagedestroy($new_image);
 
$img_name=$t."_". $_FILES["imageupload"]["name"];
 









$parts = Explode('/', $EndDate);
 $newdate=$parts[1]."-".$parts[0]."-".$parts[2];

$newdate = strtotime($newdate);

$cdate=date("m-d-y");

$parts2= Explode('-', $cdate);

 $newdate2=$parts2[0]."-".$parts2[1]."-20".$parts2[2];


$newdate2 = strtotime($newdate2);

if($newdate2 < $newdate)
{
	header('Location:exchange_list.php?msg=addnot');
	exit();
}


if($action == "add"){

$check = "SELECT * FROM exchanges WHERE ObjectName='$ObjectName'";
$exe =mysql_query($check);
$updateid =mysql_fetch_assoc($exe);
	if($updateid['ObjectName']==$ObjectName) {
	header('Location:exchanges.php?msg=exist');
	}
	else {
 	$insertexchange ="INSERT INTO exchanges (IDMaterial,IDGroupMaterial,IDSetoff,ObjectName,Description,WebSite,InicDate,EndDate,validate,imageName) values ('$IDMaterial','$IDGroupMaterial','$IDSetoff','$ObjectName','$Description','$WebSite','$InicDate','$EndDate','$validate','$img_name')";
 	if(mysql_query($insertexchange)){
 	$sellatest="select max(IDExchanges) as exeid from exchanges";
 	$fetchlatest= mysql_query($sellatest);
 	$getid =mysql_fetch_assoc($fetchlatest);
    //$deleteid ="delete from exchangeCenter WHERE IDExchange='$getid[exeid]'";
    //mysql_query($deleteid);

 	for($i=0; $i<$c; $i++){
	$insertexce="INSERT INTO exchangecenter (IDExchange,IDCenter)values('$getid[exeid]','$IDCenter[$i]')";
 	$exeexce=mysql_query($insertexce);
 	}
	header('Location:exchange_list.php?msg=add');
	}
  }
  
  
}else{

$check = "SELECT * FROM exchanges WHERE ObjectName='$ObjectName' and IDExchanges <> '$id'";
$exe =mysql_query($check);
$updateid =mysql_fetch_assoc($exe);
	if($updateid['ObjectName']==$ObjectName) {
	header("Location:exchanges.php?msg=exist&id=$id");
	}
	else {
 	$insertexchange ="update exchanges set IDMaterial='$IDMaterial',IDGroupMaterial='$IDGroupMaterial',IDSetoff='$IDSetoff',ObjectName='$ObjectName',Description='$Description',WebSite='$WebSite',InicDate='$InicDate',EndDate='$EndDate',validate='$validate',imageName='$img_name' where IDExchanges='$id'";
 	if(mysql_query($insertexchange)){
 	/*
      $sellatest="select max(IDExchanges) as exeid from exchanges";
 	$fetchlatest= mysql_query($sellatest);
 	$getid =mysql_fetch_assoc($fetchlatest);
*/
      $deleteid ="delete from exchangecenter WHERE IDExchange='$id'";
      mysql_query($deleteid);

 	for($i=0; $i<$c; $i++){
	$insertexce="INSERT INTO exchangecenter (IDExchange,IDCenter)values('$id','$IDCenter[$i]')";
 	$exeexce=mysql_query($insertexce);
 	}
	header('Location:exchange_list.php?msg=updated');
	}
  }



}
?>