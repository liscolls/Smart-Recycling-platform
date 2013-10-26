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
<title>Add Material</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
function showCustomer(str)
{
var xmlhttp;    
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","checkdata.php?q="+str,true);
xmlhttp.send();
}
</script>

<script type="text/javascript">
function validateForm()
{
var selectedCombobox=(material.IDGroupMaterial.value);
var selectedCombobox1=(material.IDGroupCenter.value);
var n=document.forms["material"]["Name"].value;
var i=document.forms["material"]["information"].value;
if (selectedCombobox=="") {
  alert("Please Select Group material");
  document.material.IDGroupMaterial.focus();
  return false;
  }
  else if (selectedCombobox1=="") {
  alert("Please Select Group center");
  document.material.IDGroupCenter.focus();
  return false;
  }
else if (n==null || n=="") {
    alert("Name must be filled out");
    document.material.Name.focus();
    return false;
  }
  else if (i==null || i=="") {
    alert("Information must be filled out");
    document.material.information.focus();
    return false;
  }
}
</script>


<script type="text/javascript">
function add_groupCenter() {
 window.location ="groupcenter.php?location=material_page"
}
</script>

<script type="text/javascript">
function add_groupMaterial() {
	 
gpid=document.getElementById('IDGroupCenter').selectedIndex;

// alert(gpid);

var loc=document.material.location.value;
var type=document.material.type.value;
var editid=document.material.editid.value;
var str=document.material.str.value;
var id=document.material.eid.value;
if(type!=''){
  window.location ="groupmaterial.php?location=material_page&type="+type+"&editid="+editid;
}
else if(str!=''){
  window.location ="groupmaterial.php?location=exchanges_page&str="+str+"&id="+id;
}
else if(str=='' && type=='' && loc=='exchanges_page'){
 window.location ="groupmaterial.php?location=exchanges_page";
}
else {
 window.location ="groupmaterial.php?location=material_page&gpid="+gpid;
}
}
</script>
    <?php 
   	 include("serverconfig.php");
	  
	 $type=$_REQUEST['type'];
	 $editid=$_REQUEST['editid'];
	 $mg=$_REQUEST['mg'];
     $cg=$_REQUEST['cg'];


	 if($type=='edit'){
		 
      $material1="select * from material where IDMaterial='$editid' ";
      $materialexe = mysql_query($material1);
	  $materialfet= mysql_fetch_assoc($materialexe);
	
      $selgroupMaterial1="select * from groupmaterial where IDGroupMaterial='$materialfet[IDGroupMaterial]'";
     	$exegm1 = mysql_query($selgroupMaterial1);
	$gpmaterialfet= mysql_fetch_assoc($exegm1);
     	
      $selgroupCenter1="select * from groupcenter where IDGroupCenter='$materialfet[IDGroupCenter]'";
     	$exegc1 = mysql_query($selgroupCenter1);
	$gcmaterialfet= mysql_fetch_assoc($exegc1);

	$selectcent ="select * from centermaterial where IDMaterial='$editid'";
      $execent=mysql_query($selectcent);
	$i=0;
	$centematerial=array();
	while($fetcent= mysql_fetch_assoc($execent)){
	$centematerial[$i]=$fetcent['IDCenter'];
	$i++;
      }

     	$selectcenters1 ="select * from centers where IDGroupCenter='$materialfet[IDGroupCenter]'";
     	$execen1=mysql_query($selectcenters1);
	$cmaterialfet= mysql_fetch_assoc($execen1);
	 }
   

	 
	 


	










     	$selgroupMaterial="select * from groupmaterial";
     	$exegm = mysql_query($selgroupMaterial);
     	
     	$selgroupCenter="select * from groupcenter";
     	$exegc = mysql_query($selgroupCenter);
     	
     	$selectcenters ="select IDCenters,name from centers";
     	$exec=mysql_query($selectcenters);
     	
     	 
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
		
		<form name="material" id="form_319564" class="appnitro"  method="post" onsubmit="return validateForm()" action="materialapi.php" enctype="multipart/form-data">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Material</p>
<div align="right"><a href='material_list.php'><input type="button" name="data" value="Show Data"></a></div>
		</div>	
	
			<li id="li_2" >
	  	<label class="description" for="element_2">Recycling Center Group</label>
		 <div>
		 
	
	    <SELECT STYLE="width:183px" name ="IDGroupCenter" id="IDGroupCenter" onchange="showCustomer(this.value)">
	    <option value="" selected="selected">Select</option>
	    <?php
$compareid="";
		   while($row=mysql_fetch_array($exegc)) {
			
				 
				if($_GET['cg']!="")
				{
					 
						$compareid=$_GET['cg'];
						 
				}

			


			    if(($gcmaterialfet['IDGroupCenter']==$row['IDGroupCenter']) || ($compareid==$row['IDGroupCenter'])){
			echo "<option value='$row[IDGroupCenter]' selected='selected'>$row[name]</option>";
			}else{
	       echo "<option value='$row[IDGroupCenter]'>$row[name]</option>";}
	       }
	    ?>
	    </SELECT>
<?php
if($location!='exchanges_page')
{
?>
			  <input type="button" onclick="add_groupCenter()" value="Add New"  />
<?php
}
?>
		 </div>  </li>						
			<ul >
			
		 <li id="li_1" >
		  <label class="description" for="element_1">Type of Material Group</label>
	       <div id="txtHint">
		  <SELECT STYLE="width:185px" name ="IDGroupMaterial" >
		  <option value="" selected="selected">Select</option>
	       <?php
		    while($row=mysql_fetch_array($exegm)) {
			 
			if($_GET['mg']!="")
				{
					 
						$compareid2=$_GET['mg'];
						 
				}





			 if(( $gpmaterialfet['IDGroupMaterial']==$row['IDGroupMaterial']) || ($compareid2==$row['IDGroupMaterial'])){
			echo "<option value='$row[IDGroupMaterial]' selected='selected'>$row[name]</option>";
			}else{
	        echo "<option value='$row[IDGroupMaterial]'>$row[name]</option>";}
	        }
	       ?>
	      </SELECT>
		<?php
		if($location!='exchanges_page')
		{
		?>
	     <input type="button" onclick="add_groupMaterial()" value="Add New" />
		<?php
		}
		?>
		 </div> 
		 </li>	
		
		 
		 <li id="li_4" >
		  <label class="description" for="element_4">Name </label>
		 <div>
			 <input id="element_4" name="Name" class="element text medium" type="text" maxlength="255" value="<?php if(isset($type)){echo $materialfet['Name'];} else {"";}?>"/> 
			</div> 	</li>	
		
			<li id="li_5" >
		  <label class="description" for="element_5">Information </label>
	 	<div>
	 	 	<textarea id="element_5" name="information" class="element text medium"><?php if(isset($type)){echo $materialfet['information'];} else {"";}?></textarea> 
			</div>  </li>
			
			<li id="li_6" >
		<label class="description" for="element_6">Centers that process this material</label>
		<div>
		  <select multiple="multiple" name="IDCenter[]" style="width:185px;">
           <?php 
			while($row=mysql_fetch_array($exec)) {
				if(in_array($row['IDCenters'],$centematerial)){
			echo "<option value='$row[IDCenters]' selected='selected'>$row[name]</option>";
			}else{
	         echo "<option value='$row[IDCenters]'>$row[name]</option>";}
	    	}
	       ?>
          </select>        
		</div>  </li>
<?php
	if($materialfet[imageName]!='')
	{
		$varimg="<img src='imageapp/scaled_".$materialfet[imageName]."'>";

?>
<li id="li_104" ><?php echo $varimg;?></li>

<?php
	}
	if($selfet1[imageName]=='')	
	{
		 
	}
?>



<li id="li_15" >
		<label class="description" for="element_3">Image Upload</label>
		<div>
			<input id="element_image" name="imageupload" class="element text medium" type="file"/> 
		</div> </li>

			
			<li class="buttons">
			  <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
			   <input type="hidden" name="location" value="<?php echo $_REQUEST['location']; ?>">
				<input type="hidden" name="type" value="<?php echo $type; ?>">
				<input type="hidden" name="editid" value="<?php echo $editid; ?>">
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
if(isset($_REQUEST['msg']))
{
echo '<script>';
echo 'alert("This center is already existed")';
echo '</script>';
}
?>