<p style="font-family:verdana,arial,sans-serif;font-size:20px;">Exchange Data</p>
<table border="1" bordercolor="#009966" style="background-color:#FFFFCC" width="400" cellpadding="1" cellspacing="1">
	<tr>
		<td>IDSetoff</td>
		<td>IDAddress</td>
		<td>IDCity</td>
		<td>IDMaterial</td>
		<td>IDCenter</td>
		<td>objectName</td>
		<td>CompanyName</td>
		<td>Cash</td>
		<td>Description</td>
		<td>WebSite</td>
		<td>Telephone</td>
		<td>Email</td>
		<td>Validate</td>
		<td>InicDate</td>
		<td>EndDate</td>
		<td>newfield</td>
	</tr>
<?php
include("serverconfig.php");
 $fetch = "select * from exchanges";
$exe =mysql_query($fetch);
while($row = mysql_fetch_array($exe))
{
echo "<tr>
		<td>$row[IDSetoff]</td>
		<td>$row[IDAddress]</td>
		<td>$row[IDCity]</td>
		<td>$row[IDMaterial]</td>
		<td>$row[IDCenter]</td>
		<td>$row[objectName]</td>
		<td>$row[CompanyName]</td>
		<td>$row[Cash]</td>
		<td>$row[Description]</td>
		<td>$row[WebSite]</td>
		<td>$row[Telephone]</td>
		<td>$row[Email]</td>
		<td>$row[Validate]</td>
		<td>$row[InicDate]</td>
		<td>$row[EndDate]</td>
		<td>$row[newfield]</td>
	</tr>";
}
?>
</table>

