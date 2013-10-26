<?php
include("serverconfig.php");
$type=$_REQUEST['type'];
$editid=$_REQUEST['editid'];
$IDTypeNews =$_REQUEST['IDTypeNews'];
$IDCiuded =$_REQUEST['IDCiuded'];
$title =$_REQUEST['title'];
$descriptionNews =$_REQUEST['descriptionNews'];
$rssUrl =$_REQUEST['rssUrl'];

if($type=='edit'){
$update ="UPDATE news SET IDTypeNews='$IDTypeNews',IDCiuded='$IDCiuded',title='$title',descriptionNews='$descriptionNews',rssUrl='$rssUrl' WHERE IDNews ='$editid'";
mysql_query($update);
header('Location:news_list.php?msg=updated');
}
else
{
$insert ="INSERT INTO news (IDTypeNews,IDCiuded,title,descriptionNews,rssUrl) values ('$IDTypeNews','$IDCiuded','$title','$descriptionNews','$rssUrl')";
mysql_query($insert);
header('Location:news_list.php?msg=add');
}
?>