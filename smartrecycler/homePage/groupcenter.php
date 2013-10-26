<?php session_start();
//$username=$_SESSION['username'];
if(isset($_SESSION['username'])){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
edited by
-->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>GroupCenter</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
function validateForm()
{
var n=document.forms["groupcenter"]["name"].value;

if (n==null || n=="") {
    alert("name must be filled out");
    document.groupcenter.name.focus();
    return false;
  }

}
</script>


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
		
	<?php
	include("serverconfig.php");
	$location=$_REQUEST['location'];
	if($_REQUEST['submit']=='Submit'){
$selnew="select * from groupcenter where name='$_REQUEST[name]'";
      $selexe=mysql_query($selnew);
		if(mysql_num_rows($selexe)>0){
		echo '<script>';
		echo 'alert("This group center is already exist")';
		echo '</script>';
		}
		else{

    $ins ="INSERT INTO groupcenter (name,validate)values('$_REQUEST[name]','$_REQUEST[validate]')";
	  $exe =mysql_query($ins);
}
	
		if($_REQUEST['location']=='material_page' && $_REQUEST['type']==''){
		
		  echo('<script language="javascript">');
  		  echo("window.location ='material.php'");
  		  echo('</script>');
		}
		else if($_REQUEST['location']=='centers_page' && $_REQUEST['type']==''){
		  echo('<script language="javascript">');
  		  echo("window.location ='centers.php'");
  		  echo('</script>');
		}
		else if(isset($_REQUEST['type']) && $_REQUEST['location']=='bins_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='groupmaterial.php?location=$location&type=$_REQUEST[type]&editid=$_REQUEST[editid]'");
  		  echo('</script>');
		}
		
		else if(isset($_REQUEST['type']) && $_REQUEST['location']=='material_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='groupmaterial.php?location=$location&type=$_REQUEST[type]&editid=$_REQUEST[editid]'");
  		  echo('</script>');
		}
		else if(isset($_REQUEST['str']) && $_REQUEST['location']=='exchanges_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='groupmaterial.php?location=$location&str=$_REQUEST[str]&id=$_REQUEST[eid]'");
  		  echo('</script>');
		}

		else if(isset($_REQUEST['type']) && $_REQUEST['location']=='centers_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='centers.php?location=$location&type=$_REQUEST[type]&editid=$_REQUEST[editid]'");
  		  echo('</script>');
		}


	      else {
		  echo('<script language="javascript">');
  		  echo("window.location ='groupmaterial.php?location=$location'");
  		  echo('</script>');
		}

	  }
		?>
		
		<form id="form_319564" name="groupcenter" class="appnitro"  method="post" onsubmit="return validateForm()" action="groupcenter.php">
		<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In GroupCenter</p>
		</div>	
					
			<ul >
			
		<li id="li_1" >
		<label class="description" for="element_1">Name </label>
		<div>
			<input id="element_2" name="name" class="element text medium" type="text" maxlength="255" value=""/> 
		</div>  </li>
	 
	 <li id="li_2" >
		<label class="description" for="element_2">Validate </label>
		<div>
			<input type="radio" name="validate" value="1" /> Yes<br />
			<input type="radio" name="validate" value="0" checked="checked"/> No
        
		</div>  </li>		
	
	<li class="buttons">
			 <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
			 <input type="hidden" name="location" value="<?php echo $_REQUEST['location']; ?>">
			<input type="hidden" name="type" value="<?php echo $_REQUEST['type']; ?>">
			<input type="hidden" name="editid" value="<?php echo $_REQUEST['editid']; ?>">
<input type="hidden" name="str" value="<?php echo $_REQUEST['str']; ?>">
			<input type="hidden" name="eid" value="<?php echo $_REQUEST['id']; ?>">


	</li>
			
	</ul>
	</form>
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
?>