<?php session_start();
$username=$_SESSION['username'];
if(isset($username)){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
edited by chandan singh
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Bin_list</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header-wrapper">
		<div id="header">
			<div id="logo">
				<h1><a>SmartRecycling</a></h1>
				
			</div>
		</div>
	</div>
</div>
	<!-- end #header -->
	<?php include("menu.php");?>
	<!-- end #menu -->
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	<div id="mylogo">
		<h1><a>SmartRecycling</a></h1>
		</div>	
		
		<form id="form_319564" class="appnitro"  method="post" action="bins.php">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Database</p>

<div align="right"><a href='bins.php'><input type="button" name="data" value="Add Bins"></a></div>

</div>	
					
			<ul >
			
			<p style="font-family:verdana,arial,sans-serif;font-size:20px;">All Bins</p>
<table width="100%" border="2" bordercolor="#660033" style="background-color:#FFFFFF" width="450" cellpadding="3" cellspacing="3" />
	<tr align="center">
		<td><b>Name</b></td>
		<td><b>Image</b></td>
		<td><b>Bin Group</b></td>
		<td><b>Hash Tag</b></td>
		<td><b>City</b></td>
		<td><b>Country</b></td>
		<td><b>Status</b></td>
		<td><b>Edit</b></td>
		<td><b>Delete</b></td>
	</tr>
	
<?php
include("serverconfig.php");
	$type=$_REQUEST['type'];
	$deleteid=$_REQUEST['deleteid'];
if($type=='delete'){
$del ="DELETE FROM bins WHERE IDBin='$_REQUEST[deleteid]'";
mysql_query($del);
}

$fetch = "select bi.IDBin,bi.name,bi.hashtag,bi.status,bi.imageName,ci.cityName,ci.country,gm.name as gmname from bins bi,address ad,city ci,groupmaterial gm where bi.IDAddress=ad.IDAddress and ad.IDCity=ci.IDCity and bi.IDGroupMaterial=gm.IDGroupMaterial order by ci.country,ci.cityName asc";
$exe =mysql_query($fetch);
$i=1;
while($row = mysql_fetch_array($exe))
{ 
if($row[imageName]!='')
	{
		$varimg="<img src='imageapp/scaled_$row[imageName]'>";
	}
if($row[imageName]=='')	
	{
		$varimg="N/A";
	}

echo "<tr>
<td>$row[name]</td>
<td>$varimg</td>
<td>$row[gmname]</td>
<td>$row[hashtag]</td>
<td>$row[cityName]</td>
<td>$row[country]</td>
<td>$row[status]</td>
<td><a href='bins.php?type=edit&editid=$row[IDBin]'><img src='b_edit.png'></a></td>
<td><a href='bins_list.php?type=delete&deleteid=$row[IDBin]'><img src='b_drop.png'></a></td>
</tr>";
$i++;
}
?>
</table></ul></form>
</div> 
<img id="bottom" src="bottom.png" alt="">
<!-- end #page -->
<div id="footer">
<p>Design By </a></p>
</div>
<!-- end #footer -->
</body>
</html>
<?php
}
else{
 echo "your session expired";
 echo "<p><a href='http://appsmartrecycling.es/antigua/smartrecycler/login/login.php'>click to login</a></p>";
}
if(isset($_REQUEST['msg1'])=='exist')
{
echo '<script>';
echo 'alert("Bin is already existed")';
echo '</script>';
}
if($_REQUEST['type']=='delete'){
echo('<script language="javascript">');
   echo("alert('Record deleted');");
   echo('</script>');
}
if($_REQUEST['msg']=='updated'){
	echo('<script language="javascript">');
   echo("alert('Record updated');");
   echo('</script>');
}
if($_REQUEST['msg']=='add'){
	echo('<script language="javascript">');
   echo("alert('Record added');");
   echo('</script>');
}
?>