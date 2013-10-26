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
<title>Add Exchanges</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script>
function check_it() {
     var theurl=document.myForm.t1.value;
     var tomatch= /http:\/\/[A-Za-z0-9\.-]{3,}\.[A-Za-z]{3}/
     if (tomatch.test(theurl))
     {
         window.alert("URL OK.");
         return true;
     }
     else
     {
         window.alert("URL invalid. Try again.");
         return false; 
     }
}
</script>

<script type="text/javascript">
function validateForm()
{
var selectedCombobox=(exchanges.IDMaterial.value);
var selectedCombobox1=(exchanges.IDGroupMaterial.value);
var selectedCombobox2=(exchanges.IDSetoff.value);
var name=document.exchanges.ObjectName.value;
var des=document.exchanges.Description.value;
var web=document.exchanges.WebSite.value;

if (selectedCombobox=="") {
  alert("Please Select ID material");
  document.exchanges.IDMaterial.focus();
  return false;
  }
  else if (selectedCombobox1=="") {
  alert("Please Select Group material");
  document.exchanges.IDGroupMaterial.focus();
  return false;
}
 else if (selectedCombobox2=="") {
  alert("Please Select setoff");
  document.exchanges.IDSetoff.focus();
  return false;
}
else if(name==''){
alert('Please fill object name');
 document.exchanges.ObjectName.focus();
  return false;
} else if(des==''){
alert('Please select fill description');
 document.exchanges.Description.focus();
  return false;
} else if(web==''){
alert('Please fill website');
 document.exchanges.Description.focus();
  return false;
}
}
</script>

<script type="text/javascript">
function add_setoff() {
  var name=prompt("Enter SetoffName","Write Here");
var str=document.exchanges.str.value;
var id=document.exchanges.eid.value;
if(str!=''){
  window.location ="exchanges.php?str="+str+"&id="+id+"&name="+name;
}
else{
  if (name!=null && name!="") {
    window.location ="exchanges.php?name="+name;
  }
}
}
</script>

<script type="text/javascript">
function add_groupMaterial() {
var str=document.exchanges.str.value;
var id=document.exchanges.eid.value;
if(str!=''){
  window.location ="groupmaterial.php?location=exchanges_page&str="+str+"&id="+id;
}
else{
 window.location ="groupmaterial.php?location=exchanges_page";}
}
</script>

<script type="text/javascript">
function add_material() {
var str=document.exchanges.str.value;
var id=document.exchanges.eid.value;
if(str!=''){
  window.location ="material.php?location=exchanges_page&str="+str+"&id="+id;
}
else{
 window.location ="material.php?location=exchanges_page";}
}
</script>

<script type="text/javascript">
function show_data() {
// window.location ="exchange_list.php"
}
</script>

<?php
include("serverconfig.php");

if ($_REQUEST['name']){
$sel ="select * from setoff where SetoffName ='$_REQUEST[name]'";
$responce =mysql_query($sel);
if(mysql_num_rows($responce)>0){
	
   echo('<script language="javascript">');
   echo("alert('already exist');");
   echo('</script>');
   
}
else {
	$ins ="INSERT INTO setoff (SetoffName) values ('$_REQUEST[name]')";
	if(mysql_query($ins)){
	
		 echo('<script language="javascript">');
  		  echo("alert('successfully updated');");
  		 echo('</script>');
   }
 }
}
if($_REQUEST['id']){
	$sql="select * from exchanges where IDExchanges='$_REQUEST[id]'";
	$res=mysql_query($sql);
	$erow=mysql_fetch_assoc($res);
	
	$sql1="select * from exchangecenter where IDExchange='$_REQUEST[id]'";
	$res1=mysql_query($sql1);
	$i=0;
	$exchangecenter=array();
	while($erow1=mysql_fetch_assoc($res1)){
	$exchangecenter[$i]=$erow1['IDCenter'];
	$i++;
}
}
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
   	
     	$selsetoff="select * from setoff";
     	$exes = mysql_query($selsetoff);
     	
     	$selgroupMaterial="select * from groupmaterial";
     	$exeg = mysql_query($selgroupMaterial);
     	
     	$selmaterial="select * from material";
     	$exem = mysql_query($selmaterial);
     	
     	$selectcenters="select * from centers";
     	$exec=mysql_query($selectcenters);
     	
   	?>
   	 
	<form name="exchanges" id="form_319564" class="appnitro"  method="post" onsubmit="return validateForm();" action="apiexchanges.php" enctype="multipart/form-data">
	<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In Trade In</p>
			
			<div align="right"><a href='exchange_list.php'><input type="button" name="buton" value="Show Data"></a></div>
		
		</div>	
		<ul >
			
		<li id="li_1" >
		<label class="description" for="element_1">Material Type</label>
		<div>
		<SELECT STYLE="width:185px" name ="IDMaterial">
		<option value="" selected="selected">Select</option>
			<?php
				while($row=mysql_fetch_array($exem)) {
				if($erow['IDMaterial']==$row['IDMaterial'])
				{
					echo "<option value='$row[IDMaterial]' selected='selected'>$row[Name]</option>";
				}else{
		    		echo "<option value='$row[IDMaterial]'>$row[Name]</option>";
		    	}
		  }
		 ?>
	 </SELECT>
		  <input type="button" onclick="add_material()" value="Add New" />
		</div>  </li>	
		
		<li id="li_2" >
		<label class="description" for="element_2">Recycling Exchange Group</label>
		<div>
		 <SELECT STYLE="width:185px" name ="IDGroupMaterial">
		<option value="" selected="selected">Select</option>
	  	<?php
		  	while($row=mysql_fetch_array($exeg)) {
		  	if($erow['IDGroupMaterial']==$row['IDGroupMaterial']){
		  		echo "<option value='$row[IDGroupMaterial]' selected='selected'>$row[name]</option>";
		  	}else{
	     		echo "<option value='$row[IDGroupMaterial]'>$row[name]</option>";
	     	}
	    }
	   ?>
	  </SELECT>
	 <input type="button" onclick="add_groupMaterial()" value="Add New" />
		</div> </li>
		
		<li id="li_3" >
		<label class="description" for="element_3">Type Set off exchange</label>
		
		<div>
		 <SELECT STYLE="width:185px" name ="IDSetoff">
		<option value="" selected="selected">Select</option>
		  <?php
			   while($row=mysql_fetch_array($exes)) {
			   if($erow['IDSetoff']==$row['IdSetoff']){
			   	echo "<option value='$row[IdSetoff]' selected='selected'>$row[SetoffName]</option>>";
			   }else{
	      		echo "<option value='$row[IdSetoff]'>$row[SetoffName]</option>>";
	      		}
	    	}
	    ?>
	  </SELECT>
	 	<input type="button" onclick="add_setoff()" value="Add New" />
	</div> </li>
		
		<li id="li_4" >
		 <label class="description" for="element_4">Exchange Object Name</label>
		<div>
		 <input id="element_4" name="ObjectName" class="element text medium" type="text" maxlength="255" value="<?php echo $erow['ObjectName']; ?>"/> 
  </div> </li>
		
		<li id="li_5" >
		 <label class="description" for="element_5">Description</label>
		<div>
		 	<textarea id="element_5" name="Description" class="element text medium"><?php echo $erow['Description']; ?></textarea>
		</div> </li>
		
		<li id="li_6" >
		 <label class="description" for="element_6">Website </label>
		<div>
			<input id="element_6" name="WebSite" class="element text medium" type="text" maxlength="255" value="<?php echo $erow['WebSite']; ?>" onchange="return check_it();"/> 
		</div> </li>
		
		<li id="li_8" >
	 	<label class="description" for="element_8">From Date</label>
		<span>
			<input id="element_8_1" name="InicDatemm" class="element text" size="2" maxlength="2" value="<?php echo substr($erow['InicDate'],0,2); ?>" type="text" readonly="readonly"> /
			<label for="element_8_1">MM</label>
		</span>
		<span>
			<input id="element_8_2" name="InicDatedd" class="element text" size="2" maxlength="2" value="<?php echo substr($erow['InicDate'],3,2); ?>" type="text" readonly="readonly"> /
			<label for="element_8_2">DD</label>
		</span>
		<span>
	 		<input id="element_8_3" name="InicDateyy" class="element text" size="4" maxlength="4" value="<?php echo substr($erow['InicDate'],6,4); ?>" type="text" readonly="readonly">
			<label for="element_8_3">YYYY</label>
		</span>
	
		<span id="calendar_8">
			<img id="cal_img_8" class="datepicker" src="calendar.gif" alt="Pick a date.">	
		</span>
		<script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_8_3",
			baseField    : "element_8",
			displayArea  : "calendar_8",
			button		 : "cal_img_8",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script></li>	
		  		
		  			<li id="li_9" >
		<label class="description" for="element_9">To Date</label>
		<span>
			<input id="element_9_1" name="EndDatemm" class="element text" size="2" maxlength="2" value="<?php echo substr($erow['EndDate'],0,2); ?>" type="text" readonly="readonly"> /
			<label for="element_9_1">MM</label>
		</span>
		<span>
			<input id="element_9_2" name="EndDatedd" class="element text" size="2" maxlength="2" value="<?php echo substr($erow['EndDate'],3,2); ?>" type="text" readonly="readonly"> /
			<label for="element_9_2">DD</label>
		</span>
		<span>
	 		<input id="element_9_3" name="EndDateyy" class="element text" size="4" maxlength="4" value="<?php echo substr($erow['EndDate'],6,4); ?>" type="text" readonly="readonly">
			<label for="element_9_3">YYYY</label>
		</span>
	
		<span id="calendar_9">
			<img id="cal_img_9" class="datepicker" src="calendar.gif" alt="Pick a date.">	
		</span>
		<script type="text/javascript">
			Calendar.setup({
			inputField	 : "element_9_3",
			baseField    : "element_9",
			displayArea  : "calendar_9",
			button		 : "cal_img_9",
			ifFormat	 : "%B %e, %Y",
			onSelect	 : selectDate
			});
		</script></li>	
		
		<li id="li_10" >
		<label class="description" for="element_10">Select Centers for this Exchange</label>
		<div>
		  <select multiple="multiple" name="IDCenter[]" style="width:185px;">

           <?php
			while($row=mysql_fetch_array($exec)) {
			if(in_array($row['IDCenters'],$exchangecenter)){
			echo "<option value='$row[IDCenters]' selected='selected'>$row[name]</option>";
			}else{
	         echo "<option value='$row[IDCenters]'>$row[name]</option>";}
	    	}
	       ?>
          </select>        
		</div>  </li>


<?php
	if($erow[imageName]!='')
	{
		$varimg="<img src='imageapp/scaled_".$erow[imageName]."'>";

?>
<li id="li_104" ><?php echo $varimg;?></li>

<?php
	}
	if($erow[imageName]=='')	
	{
		 
	}
?>






<li id="li_15" >
		<label class="description" for="element_3">Image Upload</label>
		<div>
			<input id="element_image" name="imageupload" class="element text medium" type="file"/> 
		</div> </li>








		
		<input type="hidden" name="eid" id="eid" value="<?php echo $_REQUEST['id'];?>">
			<input type="hidden" name="str" value="<?php echo $_REQUEST['str'];?>">
		<li id="li_11" >
		<label class="description" for="element_11">Validate </label>
		<div>
		<?php
		if($erow['validate']=="1"){
			echo '<input type="radio" name="validate" value="1" checked="checked"/> Yes<br />';
			echo '<input type="radio" name="validate" value="0" /> No';
		}else{
			echo '<input type="radio" name="validate" value="1" /> Yes<br />';
			echo '<input type="radio" name="validate" value="0" checked="checked"/> No';
		}
		if($_REQUEST['id']){
			echo "<input type='hidden' name='action' value='update'>";
			echo "<input type='hidden' name='id' value='$_REQUEST[id]'>";
		}else{
			echo "<input type='hidden' name='action' value='add'>";
		}
		?>
			
        
		</div>  </li>
		<li class="buttons">
		<input id="saveForm" class="button_text" type="submit"  onsubmit="validateForm();" name="submit" value="Submit" />
		</li>
		
		</ul>
		</form>	
	 </div>
 	<img id="bottom" src="bottom.png" alt="">
	<!-- end #page -->

<div id="footer">
	<p><a href="www.tanzaniteinfotech.com">Design By </a></p>
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
if($_REQUEST['msg']=='exist'){
	echo('<script language="javascript">');
   echo("alert('Object name already exists');");
   echo('</script>');
}
?>