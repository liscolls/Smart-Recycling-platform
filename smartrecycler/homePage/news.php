<?php session_start();
ob_start();
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
<title>Add News</title>
<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>

<script type="text/javascript">
function validateForm()
{
var selectedCombobox=(news.IDTypeNews.value);
var selectedCombobox1=(news.IDCiuded.value);
var dn=document.forms["news"]["descriptionNews"].value;
var ru=document.forms["news"]["rssUrl"].value;


  if (selectedCombobox=="") {
  alert("Please Select News type");
  document.news.IDTypeNews.focus();
  return false;
  }
  else if (selectedCombobox1=="") {
  alert("Please Select News city");
  document.news.IDCiuded.focus();
  return false;
  }
  else if (dn==null || dn=="") {
    alert("descriptionNews must be filled out");
    document.news.descriptionNews.focus();
    return false;
  }
  else if (ru==null || ru=="") {
    alert("url must be filled out");
    document.news.rssUrl.focus();
    return false;
  }
}
</script>


<script type="text/javascript">
function add_TypeNews(x)
{
var name=prompt("Enter nameTypeNews","Write Here");
var loc=window.location.href;
if (name!=null && name!="")
  {
	if(x==1){
	window.location =loc+"&name="+name;
	}else{
	window.location ="news.php?name="+name;
	}

  
  }
}
</script>

<script type="text/javascript">
function add_City(x)
{
var loc=window.location.href;
if(x==1){
var ty=loc.split("?");
//alert(ty[1]);
window.location ="city.php?location=news_page&"+ty[1];
	}else{
window.location ="city.php?location=news_page";}
}
</script>

<?php
include("serverconfig.php");
    $type=$_REQUEST['type'];
    $editid=$_REQUEST['editid'];
    $selcity="select * from city";
    $exec= mysql_query($selcity);
   
    $seltnews ="select * from typenews";
    $exetn= mysql_query($seltnews);

      if(isset($type)){
$newvar=1;
	$select="select * from news where IDNews='$editid'";
	$exec1=mysql_query($select);
	$fetc=mysql_fetch_assoc($exec1);
	
    $eselcity="select * from city where IDCity='$fetc[IDCiuded]'";
    $eexec = mysql_query($eselcity);
    $efetc=mysql_fetch_assoc($eexec);
    
    $typenews ="select * from typenews where IDTypeNews='$fetc[IDTypeNews]'";
    $exetypenews = mysql_query($typenews);
    $fettypenews=mysql_fetch_assoc($exetypenews);
}
	if(isset($_REQUEST[name])){
	$selnew="select * from typenews where nameTypeNews='$_REQUEST[name]'";
      $selexe=mysql_query($selnew);
		if(mysql_num_rows($selexe)>0){
		echo '<script>';
		echo 'alert("New Type is already exist")';
		echo '</script>';
		}
		else{
	$ins ="INSERT INTO typenews (nameTypeNews) values ('$_REQUEST[name]')";
	mysql_query($ins);}
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
		
			<form id="form_319564" name="news" class="appnitro"  method="post" onsubmit="return validateForm()" action="apinews.php">
					<div class="form_description">
			<h2>SmartRecycling</h2>
			<p>Form To Enter Data In News</p>
	<div align="right"><a href='news_list.php'><input type="button" name="data" value="Show Data"></a></div>
		</div>	
					
			<ul >
			
							<li id="li_2" >
		<label class="description" for="element_2">IDTypeNews </label>
		<div>
			<SELECT STYLE="width:185px" name ="IDTypeNews">
			<option value="" selected="selected">Select</option>
		<?php
			while($row=mysql_fetch_array($exetn)) {
				 if($fettypenews['IDTypeNews']==$row['IDTypeNews']){
						   echo "<option value='$row[IDTypeNews]' selected='selected'>$row[nameTypeNews]</option>";
					   }else{
			                    echo "<option  value='$row[IDTypeNews]'>$row[nameTypeNews]</option>";
					   }
	        }
	      
	    
	   echo "</SELECT>";

			echo "<input type='button' onclick='add_TypeNews($newvar);' value='Add New TypeNews' />";
?>

		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="element_3">IDCity </label>
		<div>
			<SELECT STYLE="width:185px" name ="IDCiuded">
			<option value="" selected="selected">Select</option>
		<?php
				   while($row=mysql_fetch_array($exec)) {
					   if($efetc['IDCity']==$row['IDCity']){
						   echo "<option value='$row[IDCity]' selected='selected'>$row[country],$row[cityName]</option>";
					   }else{
	         				echo "<option value='$row[IDCity]'>$row[country],$row[cityName]</option>";
					   }
	      	}
	    
	    echo "</SELECT>";

			echo "<input type='button' onclick='add_City($newvar);' value='Add New City' style='width:135px;' />";

?>
			
		</div> 
		</li>		
<li id="li_5" >
		<label class="description" for="element_5">Title </label>
		<div>
			<input id="element_5" name="title" class="element text medium" type="text" maxlength="255" value="<?php if(isset($type)){ echo $fetc['title'];}else{ "";}?>"/>  
			<!--echo $row1[4];-->
		</div>
			</li>

<li id="li_4" >
		<label class="description" for="element_4">Description News </label>
		<div>
			<textarea id="element_4" name="descriptionNews" class="element text medium"><?php if(isset($type)){ echo $fetc['descriptionNews'];}else{ " ";} ?></textarea>
			<!--echo $row1[3];-->
			
		</div> 
		</li>		<li id="li_5" >
		<label class="description" for="element_5">URL </label>
		
			<input id="element_5" name="rssUrl" class="element text medium" type="url" maxlength="255" value="<?php if(isset($type)){ echo $fetc['rssUrl'];}else{ "";}?>"/>  
			<!--echo $row1[4];-->
			</li>
			<li class="buttons">
			    <input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		    </li>
			<input type="hidden" name="type" value="<?php echo $type;?>" />
			<input type="hidden" name="editid" value="<?php echo $editid;?>" />
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