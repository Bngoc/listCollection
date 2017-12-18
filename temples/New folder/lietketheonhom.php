
<?php 
//Trang lietketheonhom.php
require("dbcon.php");
require("database.php");
$id="";
if (isset($cateid))
$id=$cateid;
$stSQL ="select CateID As ID, CateName as Name from tblCategories ";
$result = mysql_query($stSQL, $link);
$totalRows=mysql_num_rows($result);
$strOption=optionselected($stSQL,$id,$link);
?>
<form name=frmMain method=post>
	<tr>
	<td align=left colspan=4>
	Category: <select name=cateid onchange="document.frmMain.submit();">

	<?=$strOption?>
	</select></td>
	<td align=right>&nbsp;</td>
	</tr>
</form>
 
