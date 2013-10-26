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
<title>Material_list</title>
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
		
		<form id="form_319564" class="appnitro"  method="post" action="material.php">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Database</p>
<div align="right"><a href='material.php'><input type="button" name="data" value="Add Material"></a></div>

		</div>	
					
			<ul >
			
			<p style="font-family:verdana,arial,sans-serif;font-size:20px;">All Material</p>
<table width="100%" border="2" bordercolor="#660033" style="background-color:#FFFFFF" width="450" cellpadding="3" cellspacing="3">
	<tr align="center">
		<td><b>Name</b></td>
		<td><b>Image</b></td>
		<td><b>Center Group</b></td>
		<td><b>Material Group</b></td>
		<td><b>Edit</b></td>
		<td><b>Delete</b></td>
	</tr>
	
<?php
include("serverconfig.php");
	  $type=$_REQUEST['type'];
	  $deleteid=$_REQUEST['deleteid'];
	 if($type=='delete'){
	 $del="delete from material where IDMaterial='$deleteid'";
	 mysql_query($del);
	 }

$fetch = "select * from material order by name asc";
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
 $fetch1 = "select * from groupmaterial where IDGroupMaterial='$row[IDGroupMaterial]'";
 $exe1 =mysql_query($fetch1);
 $row1 = mysql_fetch_array($exe1);
 $fetch2 = "select * from groupcenter where IDGroupCenter='$row[IDGroupCenter]'";
 $exe2 =mysql_query($fetch2);
 $row2 = mysql_fetch_array($exe2);
 
echo "<tr>
		<td>$row[Name]</td>
		<td>$varimg</td>
		<td>$row2[name]</td>
		<td>$row1[name]</td>
		<td><a href='material.php?type=edit&editid=$row[IDMaterial]'><img src='b_edit.png'></a></td>
		<td><a href='material_list.php?type=delete&deleteid=$row[IDMaterial]'><img src='b_drop.png'></a></td>
	</tr>";
	$i++;
}
?>
</table>
</ul></form>
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
if($_REQUEST['type']=='delete'){
echo('<script language="javascript">');
   echo("alert('Record deleted');");
   echo('</script>');
}
?>