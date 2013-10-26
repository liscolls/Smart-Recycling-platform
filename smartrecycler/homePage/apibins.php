<?php session_start();
if(isset($_SESSION['username'])){
ob_start();
include("serverconfig.php");
$type=$_REQUEST['type'];
$editid=$_REQUEST['editid'];
$IDAddress = $_REQUEST['IDAddress'];
$IDGroupMaterial = $_REQUEST['IDGroupMaterial'];
$name = $_REQUEST['name'];
$bintype = $_REQUEST['bintype'];
$status = $_REQUEST['status'];
$validate = $_REQUEST['validate'];
 



	
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

if($type=='edit')
{



if($img_name!="")
		{


			$update ="update bins set IDAddress='$IDAddress',IDGroupMaterial='$IDGroupMaterial',name='$name',hashtag='$bintype',status='$status',validate='$validate',imageName='$img_name' where IDBin='$editid'";
		}
		else
		{
			$update ="update bins set IDAddress='$IDAddress',IDGroupMaterial='$IDGroupMaterial',name='$name',hashtag='$bintype',status='$status',validate='$validate' where IDBin='$editid'";
		}



			mysql_query($update);
			header('Location:bins_list.php?msg=updated');
}
else{
			$check = "SELECT IDBin FROM bins WHERE name='$name'";
			$exe =mysql_query($check);
			$updateid =mysql_fetch_assoc($exe);
					if(mysql_num_rows($exe)>0) {
								 header('Location:bins_list.php?msg1=exist');
					}
					else {
								$insert ="INSERT INTO bins (IDAddress,IDGroupMaterial,name,hashtag,status,validate,imageName) values ('$IDAddress','$IDGroupMaterial','$name','$bintype','$status','$validate','$img_name')";
								mysql_query($insert);
								header('Location:bins_list.php?msg=add');
					}

	}

}
?>