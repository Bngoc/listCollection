<?php
//Trang database.php
function optionselected($stSQL,$item,$links){
	$results = mysql_query($stSQL, $links);
	$totalRows=mysql_num_rows($results);
	$strOption="<option value=\"\"  selected>";
	$strOption .="--Select--</option>";
	if($totalRows>0){
		
	while ($row = mysql_fetch_array ($results)){
			$strOption .="<option value=\"" ;
			$strOption .=$row["ID"]."\"";
			if($row["ID"]==$item)
			$strOption .=" selected  ";
			$strOption .= ">".$row["Name"];
			$strOption .="</option>";
		}
	}
	return $strOption;
}
?>