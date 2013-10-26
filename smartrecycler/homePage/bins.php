<?php session_start();
//$username=$_SESSION['username'];
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
<title>Add Bins</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
function validateForm()
{
var selectedCombobox=(bins.IDAddress.value);
var selectedCombobox1=(bins.IDGroupMaterial.value);
var n=document.forms["bins"]["name"].value;
var s=document.forms["bins"]["status"].value;

if (selectedCombobox=="") {
  alert("Please Select Address");
  document.bins.IDAddress.focus();
  return false;
  }
  else if (selectedCombobox1=="") {
  alert("Please Select group material");
  document.bins.IDGroupMaterial.focus();
  return false;
  }
  else if (n==null || n=="") {
    alert("name must be filled out");
    document.bins.name.focus();
    return false;
  }
  else if (s==null || s=="") {
    alert("status must be filled out");
    document.bins.status.focus();
    return false;
  }
}
</script>

<script type="text/javascript">
function add_address(x) {
var loc=window.location.href;
var ty=loc.split("?");
if(x==1){
window.location="address.php?location=bins_page&"+ty[1];
}else{
  window.location ="address.php?location=bins_page";}
}
</script>

<script type="text/javascript">
function add_groupMaterial(x) {
var loc=window.location.href;
var ty=loc.split("?");
if(x==1){
window.location="groupmaterial.php?location=bins_page&"+ty[1];
}else{
 window.location ="groupmaterial.php?location=bins_page";
}
}
</script>

<?php 
   	 include("serverconfig.php");
   	$type=$_REQUEST['type'];
	$editid=$_REQUEST['editid'];
     
      if($type=='edit'){
	$newvar=1;
	$selbin1="select * from bins where IDBin='$editid'";
	$exebin1=mysql_query($selbin1);
	$selfet1=mysql_fetch_assoc($exebin1);
	
	$seladdress="SELECT * FROM  address WHERE IDAddress ='$selfet1[IDAddress]'";
     	$exea = mysql_query($seladdress);
	$fetadd=mysql_fetch_assoc($exea);

      $selcity="SELECT * FROM  city WHERE IDCity ='$fetadd[IDCity]'";
     	$execity = mysql_query($selcity);
	$fetcity=mysql_fetch_assoc($execity );

  
     	$selgm1="SELECT * FROM  groupmaterial WHERE IDGroupMaterial = '$selfet1[IDGroupMaterial]'";
     	$exegm1 = mysql_query($selgm1);
	$fetgm1=mysql_fetch_assoc($exegm1);
		
	}
    
     	$seladdress="select * from address";
     	$exea = mysql_query($seladdress);
     	
     	$selgm="select * from groupmaterial";
     	$exegm = mysql_query($selgm);
	
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
		
			<form name="bins" id="form_319564" class="appnitro"  method="post" onsubmit="return validateForm()" action="apibins.php" enctype="multipart/form-data">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Database</p>
		</div>	
					
			<ul >
			
							<li id="li_1" >
		<label class="description" for="element_1">Center Address</label>
		<div>
		  <SELECT STYLE="width:185px" name ="IDAddress">
		  <option value="" selected="selected">Select</option>
	       <?php
		    while($row=mysql_fetch_array($exea)) {
			
			$selcity="select * from city where IDCity='$row[IDCity]'";
     	            $execity= mysql_query($selcity);
                  $fetcity= mysql_fetch_array($execity);
  
			   if($fetadd['IDAddress']==$row['IDAddress']){
						   echo "<option value='$row[IDAddress]' selected='selected'>$row[streetAddress],$fetcity[cityName],$fetcity[country]</option>";
					   }else{
	        echo "<option value='$row[IDAddress]'>$row[streetAddress],$fetcity[cityName],$fetcity[country]</option>";
		  }
	        }

	     echo "</select>";
			echo "<input type='button' onclick='return add_address($newvar);' value='Add New' />";
	       ?>
		</div> </li>		
		
		<li id="li_2" >
		<label class="description" for="element_2">Recycling Bin Group</label>
		<div>
		<SELECT STYLE="width:185px" name ="IDGroupMaterial">
		<option value="" selected="selected">Select</option>
	       <?php
		    while($row=mysql_fetch_array($exegm)) {
			if($fetgm1['IDGroupMaterial']==$row['IDGroupMaterial']){
			echo "<option value='$row[IDGroupMaterial]' selected='selected'>$row[name]</option>";
			}else{
	            echo "<option value='$row[IDGroupMaterial]'>$row[name]</option>";}
	        }
	     echo "</SELECT>";

			echo "<input type='button' onclick='add_groupMaterial($newvar);' value='Add New' />";
	       ?>


		</div>  </li>		
		
		<li id="li_3" >
		<label class="description" for="element_3">Bin Name</label>
		<div>
			<input id="element_3" name="name" class="element text medium" type="text" maxlength="255" value="<?php if(isset($type)){echo $selfet1['name'];} else {"";}?>"/> 
		</div> </li>

		<li id="li_7" >
		<label class="description" for="element_7">Hash Tag</label>
		<div>
			<input id="element_7" name="bintype" class="element text medium" type="text" maxlength="255" value="<?php if(isset($type)){echo $selfet1['hashtag'];} else {"";}?>"/> 
		</div> </li>

		
		<li id="li_4" >
		 <label class="description" for="element_4">Status </label>
		<div>
		<SELECT STYLE="width:185px" name ="status">
		<?php
		if(isset($type)){
		echo "<option value='$selfet1[status]' selected='selected'>$selfet1[status]</option>";
			echo "<option value='Bien'>Bien</option>";
			echo "<option value='Lleno'>Lleno</option>"; 
			echo "<option value='Desaparecido'>Desaparecido</option>"; 
			echo "<option value='Dañado'>Dañado</option>"; 

		}else{		
		?>
			<option value="" selected="selected">Select</option> 
			<option value="Bien">Bien</option> 
			<option value="Lleno">Lleno</option> 
			<option value="Desaparecido">Desaparecido</option> 
			<option value="Dañado">Dañado</option> 

		<?php
		}
		?>
</select>
		</div>
		</li> 

<?php
	if($selfet1[imageName]!='')
	{
		$varimg="<img src='imageapp/scaled_".$selfet1[imageName]."'>";

?>
<li id="li_104" ><?php echo $varimg;?></li>

<?php
	}
	if($selfet1[imageName]=='')	
	{
		 
	}
?>


		<li id="li_7" >
		<label class="description" for="element_3">Image Upload</label>
		<div>
			<input id="element_image" name="imageupload" class="element text medium" type="file"/> 
		</div> </li>
 
			<li id="li_5" >
		<label class="description" for="element_5">Validate </label>
		<div>
		<?php
		if(isset($type)){
		if ($selfet1['validate']=='1')
		{
		?>
		<input type="radio" name="validate" value="1" checked="checked" /> Yes<br />
		<input type="radio" name="validate" value="0" /> No
		<?php
		}else if($selfet1['validate']=='0')
		{
		?>
		<input type="radio" name="validate" value="1" /> Yes<br />
		<input type="radio" name="validate" value="0" checked="checked"/> No
		<?php
		}
		}
		?>
             <?php 
if($type==''){
?>
			<input type="radio" name="validate" value="1" /> Yes<br />
			<input type="radio" name="validate" value="0" checked="checked"/> No
<?php
}
?>
			
        <input type="hidden" name="type" value="<?php echo $type;?>" />
	   <input type="hidden" name="editid" value="<?php echo $editid;?>" />
		</div>  </li>
			<li class="buttons">
			    <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
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