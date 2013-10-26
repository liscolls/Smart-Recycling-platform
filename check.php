<?php
include("database.php");
$str=$_GET['q'];
$sel="select * from groupmaterial where IDGroupMaterial='$str'";
$exe=mysql_query($sel);
$fet=mysql_fetch_assoc($exe);
$sel1="select * from groupcenter where IDGroupCenter='$fet[IDGroupCenter]'";
$exe1=mysql_query($sel1);
$fet1=mysql_fetch_assoc($exe1);
?>
<form>
<select ><option>Select</option>
<?php
echo "<option value=$fet1[IDGroupCenter] selected='selected'>$fet1[name]</option>";
?>
</select>
</form>{“type”:”centersList”, “searchterm”:”uuu”, “latitude”:””,”longitude”:””}