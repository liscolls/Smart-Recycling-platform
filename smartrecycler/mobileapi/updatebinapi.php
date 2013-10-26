<?php
include("database.php");

$stringjson[]=json_decode(stripslashes($_POST['params']));

$binid=$stringjson[0]->bid;
$status=$stringjson[0]->status;

$x=array();

if(isset($binid) && isset($status))
{
	 $sql="update bins set status='".$status."' where IDBin='".$binid."'";
	$res=mysql_query($sql);
	 

	 if($res)
	{
		$x['success'] = 1;
	}
	else
	{
		$x['success'] = "Fail";
	}
} 
else
{
	$x['success'] = "Mising parameter";
}

echo json_encode($x);

?>