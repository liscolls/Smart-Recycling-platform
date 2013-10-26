<?php
include("database.php");

$sql="Select * from status";
$res=mysql_query($sql);
$id=1;
$statuses=array();

 
while($row=mysql_fetch_array($res)) {


		$statuses[$id]=$row['status'];

$id++;
}


echo json_encode($statuses);

?>