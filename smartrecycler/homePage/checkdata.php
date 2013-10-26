<?php
include("serverconfig.php");
$str=$_GET['q'];
?>
 <SELECT STYLE="width:185px" name ="IDGroupMaterial">
<option value="" selected="selected">Select</option>
<?php
$sel="select * from groupmaterial where IDGroupCenter='$str'";
$exe=mysql_query($sel);
$groupmaterial=array();
$i=0;
while($fet=mysql_fetch_assoc($exe))
{
echo "<option value=$fet[IDGroupMaterial]>$fet[name]</option>";
$i++;
}
?>
</SELECT>
<input type="button" onclick="add_groupMaterial()" value="Add New" />