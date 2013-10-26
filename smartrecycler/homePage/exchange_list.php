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
<title>Exchange_list</title>
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
		
		<form id="form_319564" class="appnitro"  method="post" action="exchanges.php">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Database</p>
<div align="right">
<table><tr><td><input type="submit" name="sub" value="Add Trade in"></td></tr></table></div>
		</div>	
					
			<ul >
			
			<p style="font-family:verdana,arial,sans-serif;font-size:20px;">Trade in</p>

<table width="100%" border="2" bordercolor="#660033" style="background-color:#FFFFFF" width="450" cellpadding="3" cellspacing="3">
<tr align="center">
		<!--<td>WebSite</td>-->
		<td><b>Object</b></td>
		<td><b>Image</b></td>
		<td><b>Material</b></td>
		<!--<td>Description</td>-->
		<td><b>From Date</b></td>
		<td><b>To Date</b></td>
		<td><b>Edit</b></td>
		<td><b>Delete</b></td>
		</tr>
	
<?php
include("serverconfig.php");
if($_REQUEST['did']){
//$sql = "delete from exchanges where IDExchanges='$_REQUEST[did]'";
mysql_query("delete from exchanges where IDExchanges='$_REQUEST[did]'");
}

$fetch = "select * from exchanges order by ObjectName asc";
$exe =mysql_query($fetch);
$i=1;
while($row = mysql_fetch_array($exe))
{


$parts = Explode('/', $row['EndDate']);
$newdate=$parts[0]."-".$parts[1]."-".$parts[2];

$newdate = strtotime($newdate);

$cdate=date("m-d-y");


$parts2= Explode('-', $cdate);

$newdate2=$parts2[1]."-".$parts2[0]."-20".$parts2[2];


$newdate2 = strtotime($newdate2);

 
if($newdate2 > $newdate)
	{

$fetch1 = "select Name from material where IDMaterial='$row[IDMaterial]'";
$exe1 =mysql_query($fetch1);
$row1 = mysql_fetch_array($exe1);

if($row[imageName]!='')
	{
		$varimg="<img src='imageapp/scaled_$row[imageName]'>";
	}
if($row[imageName]=='')	
	{
		$varimg="N/A";
	}




$partsA = Explode('/', $row['EndDate']);
$dateA=$partsA[1]."-".$partsA[0]."-".$partsA[2];

$partsB = Explode('/', $row['InicDate']);
$dateB=$partsB[1]."-".$partsB[0]."-".$partsB[2];




echo "<tr> 
		<td>$row[ObjectName]</td>
		<td>$varimg</td>
		<td>$row1[Name]</td>
		<td>$dateB</td>
		<td>$dateA</td>
		<td align='center'><a href='exchanges.php?str=view&id=$row[IDExchanges]'><img src='b_edit.png'></a></td>
		<td><a href='exchange_list.php?did=$row[IDExchanges]'><img src='b_drop.png'></td>
		</tr>";
		$i++;

	}
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
if($_REQUEST['did']){
echo('<script language="javascript">');
   echo("alert('Record deleted');");
   echo('</script>');
}

?>