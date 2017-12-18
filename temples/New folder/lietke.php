<?php 
//Trang lietke.php


if($totalRows>0)
{
$i=0;
while ($row = mysql_fetch_array ($result))
{
	$i+=1;
	?>
	<tr valign="top">
	<td><input type=checkbox name=chkid value='<?=$row["SubCateID"]?>'> </td>
	<td><?=$row["CateID"]?> </td>
	<td><?=$row["SubCateID"]?> </td>
	<td ><a href='capnhat.php?id=<?=$row['SubCateID']?>'>
	<?=$row["SubCateName"]?></a></td>
	</tr>
	<?php
}
?>
<tr valign="top">
<td colspan="4" align="middle">
<hr noshade size="1">
</td>
</tr>
<tr valign="top">
<td colspan=3><input type=submit value="Delete">
<input type=hidden name=from_ value="subcategories">
<input type=hidden name=type value="0">
<input type=hidden name=chon value="">
<input type=button value="New"
onclick="window.open('them.php',target='_main')"></td>
<td >Tong so mau tin <?=$i?></td>
</tr>
<?php
}else{
?>
<tr valign="top">
<td >&nbsp;</td><td >&nbsp;</td><td >&nbsp;</td>
<td > <b><font face="Arial" color="#FF0000"> Oop! Ship not found!</font></b></td>
</tr>
<?php
}
?>
 