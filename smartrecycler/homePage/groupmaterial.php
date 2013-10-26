<?php session_start();
//$username=$_SESSION['username'];

$gpid=$_GET['gpid'];
if(isset($_SESSION['username'])){
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
<title>Group Material</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
function validateForm()
{
var n=document.forms["groupmaterial"]["name"].value;

if (n==null || n=="") {
    alert("name must be filled out");
    document.groupmaterial.name.focus();
    return false;
  }

}
</script>


<script type="text/javascript">
function add_groupCenter() {
	var locate=document.forms["groupmaterial"]["location"].value;
	var type=document.forms["groupmaterial"]["type"].value;
	var editid=document.forms["groupmaterial"]["editid"].value;
var str=document.forms["groupmaterial"]["str"].value;
	var id=document.forms["groupmaterial"]["eid"].value;
if(type!='' && locate == 'bins_page'){
window.location ="groupcenter.php?location=bins_page&type="+type+"&editid="+editid;
}
else if(str!='' && locate == 'exchanges_page'){
window.location ="groupcenter.php?location=exchanges_page&str="+str+"&id="+id;
}
else if(type!='' && locate == 'material_page'){
window.location ="groupcenter.php?location=material_page&type="+type+"&editid="+editid;
}
else if (locate == 'bins_page'){
  window.location ="groupcenter.php?location=bins_page";
	}
else if (locate == 'exchanges_page'){
  window.location ="groupcenter.php?location=exchanges_page";
	}
else if (locate == 'material_page'){
  window.location ="groupcenter.php?location=material_page";
	}
	else{
  window.location ="groupcenter.php?location=groupmaterial_page";
	}
}
</script>

<?php 
   	 include("serverconfig.php");
   	$loaction=$_REQUEST['location'];
     	$selgroupCenter="select * from groupcenter";
     	$exeg = mysql_query($selgroupCenter);
    ?>
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
	
	if($_REQUEST['submit']=='Submit'){
    		$ins ="INSERT INTO groupmaterial (IDGroupCenter,name,validate)values('$_REQUEST[IDGroupCenter]','$_REQUEST[name]','$_REQUEST[validate]')";
	 	 mysql_query($ins); 
			$insert_id=mysql_insert_id();
		if(isset($_REQUEST['type']) && $_REQUEST['location']=='bins_page'){
		
		  echo('<script language="javascript">');
  		  echo("window.location ='bins.php?type=$_REQUEST[type]&editid=$_REQUEST[editid]'");
  		  echo('</script>');
		}

		else if(isset($_REQUEST['type']) && $_REQUEST['location']=='material_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='material.php?type=$_REQUEST[type]&editid=$_REQUEST[editid]&mg=$insert_id&cg=$_REQUEST[IDGroupCenter]'");
  		  echo('</script>');
		}

              else if(isset($_REQUEST['str']) && $_REQUEST['location']=='exchanges_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='exchanges.php?str=$_REQUEST[str]&id=$_REQUEST[eid]'");
  		  echo('</script>');
		}

		 else if($_REQUEST['type']=='' && $_REQUEST['location']=='material_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='material.php'");
  		  echo('</script>');
		}

		else if($_REQUEST['location']=='bins_page' && $_REQUEST['type']==''){
		
		  echo('<script language="javascript">');
  		  echo("window.location ='bins.php'");
  		  echo('</script>');
		}
		else if($_REQUEST['location']=='material_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='material.php'");
  		  echo('</script>');
		}
		else if($_REQUEST['location']=='groupmaterial_page'){
		  echo('<script language="javascript">');
  		  echo("window.location ='material.php'");
  		  echo('</script>');
		}
		else {
		  echo('<script language="javascript">');
  		  echo("window.location ='exchanges.php'");
  		  echo('</script>');
		}
   	   }
		?>
		<form id="form_319564" name="groupmaterial" class="appnitro"  method="post" onsubmit="return validateForm()" action="groupmaterial.php">
		<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In GroupMaterials</p>
		</div>	
					
			<ul >
			
			<li id="li_1" >
		<label class="description" for="element_1">IDGroupCenter </label>
		<div>
		<SELECT STYLE="width:185px" name ="IDGroupCenter">
	  	<?php
		 while($row=mysql_fetch_array($exeg)) {

			if($row['IDGroupCenter']==$gpid)
				{
					$varsel="selected";
				}
			else
				{
					$varsel="";
				}

	     echo "<option value='$row[IDGroupCenter]' $varsel>$row[name]</option>";
	     }
	    ?>
	  </SELECT>
<?php
if($location!='exchanges_page')
{
?>
		 	<input type="button" onclick="return add_groupCenter();" value="Add New GroupCenter" />
<?php
}
?>
		</div> 
	
	<li id="li_2" >
		<label class="description" for="element_2">Name </label>
		<div>
			<input id="element_2" name="name" class="element text medium" type="text" maxlength="255" value=""/> 
		</div> 
	</li>	
	 <li id="li_3" >
		<label class="description" for="element_3">Validate </label>
		<div>
			<input type="radio" name="validate" value="1"  /> Yes<br />
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