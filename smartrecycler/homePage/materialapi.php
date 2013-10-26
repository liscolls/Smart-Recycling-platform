<?php
include("serverconfig.php");
$type=$_REQUEST['type'];
$editid=$_REQUEST['editid'];
$name=$_REQUEST['Name'];
$IDGroupMaterial=$_REQUEST['IDGroupMaterial'];
$IDGroupCenter=$_REQUEST['IDGroupCenter'];
$information=$_REQUEST['information'];
$IDCenter=$_REQUEST['IDCenter'];

$c=count($IDCenter);






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
			 $ins ="update material set  IDGroupMaterial='$_REQUEST[IDGroupMaterial]' ,IDGroupCenter='$_REQUEST[IDGroupCenter]' ,Name='$_REQUEST[Name]' ,information ='$_REQUEST[information]' ,imageName ='$img_name' where IDMaterial='$editid'";
		}
		else
		{
			 $ins ="update material set  IDGroupMaterial='$_REQUEST[IDGroupMaterial]' ,IDGroupCenter='$_REQUEST[IDGroupCenter]' ,Name='$_REQUEST[Name]' ,information ='$_REQUEST[information]' where IDMaterial='$editid'";
		}
        if(mysql_query($ins)) {
		 
              $delt="delete from centermaterial where IDMaterial='$editid'";
              mysql_query($delt);
			
               for($i=0; $i<$c; $i++){
		  $insertceme="INSERT INTO centermaterial (IDMaterial,IDCenter)values('$editid','$IDCenter[$i]')";
		  $execeme=mysql_query($insertceme);
      }
	}


header('Location:material_list.php?msg=updated');
		     }
        
else{
$check = "SELECT * FROM material WHERE Name='$name'";
$exe =mysql_query($check);
$updateid =mysql_fetch_assoc($exe);
if(mysql_num_rows($exe)>0) {
header('Location:material.php?msg=exist');
} 
else{
$c=count($IDCenter);
$ins ="INSERT INTO material (IDGroupMaterial,IDGroupCenter,Name,information,imageName)values('$_REQUEST[IDGroupMaterial]','$_REQUEST[IDGroupCenter]','$_REQUEST[Name]','$_REQUEST[information]','$img_name')";
        if(mysql_query($ins)) 
	  {
	        $sellatest="select max(IDMaterial) as exeid from material";
		  $fetchlatest= mysql_query($sellatest);
		  $getid =mysql_fetch_assoc($fetchlatest);
	
      for($i=0; $i<$c; $i++)
        {
		 $insertceme="INSERT INTO centermaterial (IDMaterial,IDCenter)values('$getid[exeid]','$IDCenter[$i]')";
		  $execeme=mysql_query($insertceme);
        }
	 }

if($_REQUEST['location']=='exchanges_page'){
		
		  echo('<script language="javascript">');
  		  echo("window.location ='exchanges.php'");
  		  echo('</script>');
		}
	else{
header('Location:material_list.php?msg=add');
}
}
}	 
?>