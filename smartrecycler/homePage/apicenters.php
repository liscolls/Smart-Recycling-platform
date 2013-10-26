<?php
ob_start();
include("serverconfig.php");
echo $type=$_REQUEST['type'];
echo $editid=$_REQUEST['editid'];
$IDGroupCenter = $_REQUEST['IDGroupCenter'];
$IDAddress = $_REQUEST['IDAddress'];
$name = $_REQUEST['name'];
$telephone = $_REQUEST['telephone'];
$webSite = $_REQUEST['webSite'];
$description = $_REQUEST['description'];
$validate = $_REQUEST['validate'];
$IDExchange=$_REQUEST['IDExchange'];
$c=count($IDExchange);
$IDMaterial=$_REQUEST['IDMaterial'];
$m=count($IDMaterial);


if(isset($_FILES["imageupload"]["name"]) && $_FILES["imageupload"]["name"]!="")
{ 

$t=time();
$im_name_new=str_replace(" ", "-", $_FILES["imageupload"]["name"]);
move_uploaded_file($_FILES["imageupload"]["tmp_name"],"imageapp/".$t."_". $im_name_new);
copy("imageapp/".$t."_". $im_name_new, "imageapp/scaled_".$t."_". $im_name_new);
 // echo "Stored in: " . "imageapp/" . $_FILES["imageupload"]["name"];
list($image_width, $image_height) = getimagesize("imageapp/scaled_".$t."_". $im_name_new);
$remote_file = "imageapp/scaled_".$t."_". $im_name_new;
$new_image = imagecreatetruecolor(60 , 60);
$image_source = imagecreatefromjpeg("imageapp/scaled_".$t."_". $im_name_new);
imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, 60, 60, $image_width, $image_height);
imagejpeg($new_image,$remote_file,100);
//imagedestroy($new_image);
$img_name=$t."_". $im_name_new;

}
else
{
$img_name="";
}





if($type=='edit'){


if($img_name!="")
{
 $insert ="update centers set IDGroupCenter='$IDGroupCenter',IDAddress='$IDAddress',name='$name',telephone='$telephone',webSite='$webSite',description='$description',validate='$validate',imageName='$img_name' where IDCenters='$editid'";
}
else
{
 $insert ="update centers set IDGroupCenter='$IDGroupCenter',IDAddress='$IDAddress',name='$name',telephone='$telephone',webSite='$webSite',description='$description',validate='$validate' where IDCenters='$editid'";
}


mysql_query($insert);

$sellatest="select IDCenters as exeid from centers where IDCenters='$editid'";
$fetchlatest= mysql_query($sellatest);
$getid =mysql_fetch_assoc($fetchlatest); 
$delt="delete from exchangecenter where IDCenter='$editid'";
mysql_query($delt);
$delt1="delete from centermaterial where IDCenter='$editid'";
mysql_query($delt1);
for($i=0; $i<$c; $i++){
	  
  $insertexce="INSERT INTO exchangecenter (IDExchange,IDCenter)values('$IDExchange[$i]','$getid[exeid]')";
  $exeexce=mysql_query($insertexce);
  }
  for($j=0; $j<$m; $j++){
  $insertceme="INSERT INTO centermaterial (IDCenter,IDMaterial)values('$getid[exeid]','$IDMaterial[$j]')";
  $execeme=mysql_query($insertceme);
  }
header('Location:centers_list.php?msg=updated');
}
else{
$check = "SELECT IDCenters FROM centers WHERE name='$name'";
$exe11 =mysql_query($check);
$fetch =mysql_fetch_assoc($exe11);

if(mysql_num_rows($exe11)>0) {
 header('Location:centers.php?msg=exist');
}

else {

 $insert ="INSERT INTO centers (IDGroupCenter,IDAddress,name,telephone,webSite,description,validate,imageName) values ('$IDGroupCenter','$IDAddress','$name','$telephone','$webSite','$description','$validate','$img_name')";
 if(mysql_query($insert)){

 $sellatest="select max(IDCenters) as exeid from centers";
 $fetchlatest= mysql_query($sellatest);
 $getid =mysql_fetch_assoc($fetchlatest);
  
  for($i=0; $i<$c; $i++){
	  
  $insertexce="INSERT INTO exchangecenter (IDExchange,IDCenter)values('$IDExchange[$i]','$getid[exeid]')";
  $exeexce=mysql_query($insertexce);
  }
  for($j=0; $j<$m; $j++){
  $insertceme="INSERT INTO centermaterial (IDCenter,IDMaterial)values('$getid[exeid]','$IDMaterial[$j]')";
  $execeme=mysql_query($insertceme);
  }
header('Location:centers_list.php?msg=add');
}
}
}
?>