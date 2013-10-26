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
<title>Add Centers</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script language = "Javascript">
/**
 * DHTML phone number validation script. Courtesy of SmartWebby.com (http://www.smartwebby.com/dhtml/)
 */

// Declaring required variables
var digits = "0123456789";
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";
// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";
// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;

function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}
function trim(s)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not a whitespace, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (c != " ") returnString += c;
    }
    return returnString;
}
function stripCharsInBag(s, bag)
{   var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
var bracket=3
strPhone=trim(strPhone)
if(strPhone.indexOf("+")>1) return false
if(strPhone.indexOf("-")!=-1)bracket=bracket+1
if(strPhone.indexOf("(")!=-1 && strPhone.indexOf("(")>bracket)return false
var brchr=strPhone.indexOf("(")
if(strPhone.indexOf("(")!=-1 && strPhone.charAt(brchr+2)!=")")return false
if(strPhone.indexOf("(")==-1 && strPhone.indexOf(")")!=-1)return false
s=stripCharsInBag(strPhone,validWorldPhoneChars);
return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}
</script>


<script type="text/javascript">
function validateForm()
{
var selectedCombobox=(document.centers.IDGroupCenter.value);
var selectedCombobox1=(document.centers.IDAddress.value);
var n=document.forms["centers"]["name"].value;
var tn=document.forms["centers"]["telephone"].value;
var w=document.forms["centers"]["webSite"].value;
var des=document.forms["centers"]["description"].value;

if (selectedCombobox=="") {
  alert("Please Select IDGroupcenter");
  document.centers.IDGroupCenter.focus();
  return false;
  }
  else if (selectedCombobox1=="") {
  alert("Please Select IDAddress");
  document.centers.IDAddress.focus();
  return false;
  }
if (n==null || n=="") {
    alert("name must be filled out");
    document.centers.name.focus();
    return false;
  }
  
  else if (w==null || w=="") {
//    alert("webSite must be filled out");
//    document.centers.webSite.focus();
//    return false;
  }
  else if (tn==null || tn==""){
 // alert("Please Enter Phone Number");
 // document.centers.telephone.focus();
//  return false;
  }

  else if (checkInternationalPhone(tn)==false){
	//alert("Please Enter a Valid Phone Number");
//	document.centers.telephone.value="";
//	document.centers.telephone.focus();
//	return false;
	}
 }
</script>
<script>
function checkNum(){
var carCode = event.keyCode;
if ((carCode < 48) || (carCode > 57)){
alert('Please enter only numbers.');
event.cancelBubble = true
event.returnValue = false;
}
}
</script>

<script type="text/javascript">
function add_groupCenter() {
var type=document.centers.type.value;
var editid=document.centers.editid.value;
if(type!=''){
  window.location ="groupcenter.php?location=centers_page&type="+type+"&editid="+editid;
}
else{
  window.location ="groupcenter.php?location=centers_page";}
}
</script>

<script type="text/javascript">
function add_address() {
var type=document.centers.type.value;
var editid=document.centers.editid.value;
if(type!=''){
  window.location ="address.php?location=centers_page&type="+type+"&editid="+editid;
}
else{
  window.location ="address.php?location=centers_page";}
}
</script>

 <?php 
   	 include("serverconfig.php");
   	
	$type=$_REQUEST['type'];
	$editid=$_REQUEST['editid'];
	
	if($type=='edit'){
	
	$selecenter="select * from centers where IDCenters='$editid'";
     	$execenter = mysql_query($selecenter);
	$fetcenter = mysql_fetch_assoc($execenter);
	
	$selgroupCenter="select * from groupcenter where IDGroupCenter='$fetcenter[IDGroupCenter]'";
     	$exegc = mysql_query($selgroupCenter);
	$fetgc = mysql_fetch_assoc($exegc);
     	
     	$seladdress="select * from address where IDAddress='$fetcenter[IDAddress]'";
     	$exegaa = mysql_query($seladdress);
	$fetgcc = mysql_fetch_assoc($exegaa);
      
	$selcity1="select * from city where IDCity='$fetgcc[IDCity]'";
     	$execity1 = mysql_query($selcity1);
	$fetcity1 = mysql_fetch_assoc($execity1);
     	
     	$selectexchanges ="select * from exchangecenter where IDCenter='$editid'";
     	$exeex=mysql_query($selectexchanges);
      $exchangesarray=array();
	$i=0;
      while($fetexchange=mysql_fetch_assoc($exeex)){
    	$exchangesarray[$i]=$fetexchange['IDExchange'];
	$i++;
	}
     	$selectmaterial="select * from centermaterial where IDCenter='$editid'";
     	$exematerial=mysql_query($selectmaterial);
	$centermaterial=array();
	$i=0;
      while($fetmaterial=mysql_fetch_assoc($exematerial)){
    	$centermaterial[$i]=$fetmaterial[IDMaterial];
	$i++;
	}
	//print_r($centermaterial);	
	}
	
	$selgroupCenter="select * from groupcenter";
     	$exegc = mysql_query($selgroupCenter);
     	
     	$seladdress="select * from address";
     	$exega = mysql_query($seladdress);
     	
     	$selectexchanges ="select IDExchanges,ObjectName from exchanges";
     	$exeex=mysql_query($selectexchanges);
     	
     	$selectmaterial="select IDMaterial,Name from material";
     	$exem=mysql_query($selectmaterial);
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
		
		<form name="centers" id="form_319564" class="appnitro"  method="post" onsubmit="return validateForm()" action="apicenters.php" enctype="multipart/form-data">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In centers</p>
<div align="right"><a href='centers_list.php'><input type="button" name="data" value="Show Data"></a></div>
		</div>	
					
			<ul >
			
		<li id="li_1" >
		<label class="description" for="element_1">Recycling Center Group</label>
		<div>
		<SELECT STYLE="width:185px" name ="IDGroupCenter">
		<option value="" selected="selected">Select</option>


			
	       <?php
if($fetgc['IDGroupCenter']=="")
	{
				
?>
<option value="2" selected="selected">Centros</option>
<?
	}



		    while($row=mysql_fetch_array($exegc)) {
			     if($fetgc['IDGroupCenter']==$row['IDGroupCenter']){
						   echo "<option value='$fetgc[IDGroupCenter]' selected='selected'>$fetgc[name]</option>";
					   }else{

					 
				       
if($fetgc['IDGroupCenter']=="" && $row[name]!="centros")
	{
				
 
	        echo "<option value='$row[IDGroupCenter]'>$row[name]</option>";
	}
if($fetgc['IDGroupCenter']!="")

						   {
								 echo "<option value='$row[IDGroupCenter]'>$row[name]</option>";
						   }
			
			
			}
	        }
	       ?>
	     </select>

			<input type="button" onclick="add_groupCenter()" value="Add New" />

		</div>   </li>	
		
			<li id="li_2" >
		<label class="description" for="element_2">Center Address</label>
		<div>
		 <SELECT STYLE="width:185px" name ="IDAddress">
		 <option value="" selected="selected">Select</option>
	       <?php
		    while($row=mysql_fetch_array($exega)) {
                
			$selcity="select * from city where IDCity='$row[IDCity]'";
		     	$execity = mysql_query($selcity);
			$fetcity = mysql_fetch_assoc($execity);

			     if($fetgcc['IDAddress']==$row['IDAddress']){
						   echo "<option value='$fetgcc[IDAddress]' selected='selected'>$fetgcc[streetAddress],$fetcity1[cityName],$fetcity1[country]</option>";
					   }else{
	        echo "<option value='$row[IDAddress]'>$row[streetAddress],$fetcity[cityName],$fetcity[country]</option>";}
	        }
	       ?>
	     </select>

			<input type="button" onclick="add_address()" value="Add New"/>
	</div>   </li>
		
			<li id="li_3" >
		<label class="description" for="element_3">Center Name </label>
		<div>
		<input id="element_3" name="name" class="element text medium" type="text" maxlength="255" value="<?php if(isset($type)){echo $fetcenter['name'];} else {"";}?>"/> 
		</div>   </li>	
		
		 <li id="li_4" >
		<label class="description" for="element_4">Telephone </label>
		<div> 
		<input id="element_4" name="telephone" class="element text medium" onkeypress="checkNum();" type="tel" maxlength="255" value="<?php if(isset($type)){echo $fetcenter['telephone'];} else {"";}?>"/> 
		</div>   </li> 
		
			<li id="li_5" >
		<label class="description" for="element_5">Website</label>
		<div>
			<input id="element_5" name="webSite" class="element text medium" type="text" maxlength="255" value="<?php if(isset($type)){echo $fetcenter['webSite'];} else {"";}?>"/> 
		</div>  </li> 

		<li id="li_7" >
		<label class="description" for="element_7">Description</label>
		<div>
			<textarea name="description" class="element text medium"><?php if(isset($type)){echo $fetcenter['description'];} else {"";}?></textarea> 
		</div>  </li> 
		
		<li id="li_6" >
		<label class="description" for="element_6">Exchanges Accepted</label>
		<div>
		  <select multiple="multiple" name="IDExchange[]" style="width:185px;">
           <?php
			while($row=mysql_fetch_array($exeex)) {
			if(in_array($row['IDExchanges'],$exchangesarray)){
			echo "<option value='$row[IDExchanges]' selected='selected'>$row[ObjectName]</option>";
			}else{
	         	echo "<option value='$row[IDExchanges]'>$row[ObjectName]</option>";
			}
	    	}
	       ?>
          </select>        
		</div>  </li>
		
		<li id="li_7" >
		<label class="description" for="element_7">Materials Accepted</label>
		<div>
		  <select multiple="multiple" name="IDMaterial[]" style="width:185px;">
           <?php
			while($row=mysql_fetch_array($exem)) {
		   if(in_array($row['IDMaterial'],$centermaterial)){
			echo "<option value='$row[IDMaterial]' selected='selected'>$row[Name]</option>";
			}else{
	         echo "<option value='$row[IDMaterial]'>$row[Name]</option>";}
	    	}
	       ?>
          </select>        
		</div>  </li>
<?php
	if($fetcenter[imageName]!='')
	{
		$varimg="<img src='imageapp/scaled_".$fetcenter[imageName]."'>";

?>
<li id="li_104" ><?php echo $varimg;?></li>

<?php
	}
	if($fetcenter[imageName]=='')	
	{
		 
	}
?>

 





		<li id="li_15" >
		<label class="description" for="element_3">Image Upload</label>
		<div>
			<input id="element_image" name="imageupload" class="element text medium" type="file"/> 
		</div> </li>




			<li id="li_8" >
		<label class="description" for="element_8">Validate </label>
		<div>
			<?php
		if(isset($type)){
		if ($fetcenter['validate']=='1')
		{
		?>
		<input type="radio" name="validate" value="1" checked="checked" /> Yes<br />
		<input type="radio" name="validate" value="0" /> No
		<?php
		}else if($fetcenter['validate']=='0')
		{
		?>
		<input type="radio" name="validate" value="1" /> Yes<br />
		<input type="radio" name="validate" value="0" checked="checked"/> No
		<?php
		}
		}else{
		?>
			<input type="radio" name="validate" value="1" /> Yes<br />
			<input type="radio" name="validate" value="0" checked="checked"/> No
			<?php
		}?>
		<input type="hidden" name="type" value="<?php echo $type; ?>" />
		<input type="hidden" name="editid" value="<?php echo $editid; ?>" />
        
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
if(isset($_REQUEST['msg']))
{
echo '<script>';
echo 'alert("This center is already existed")';
echo '</script>';
}
?>