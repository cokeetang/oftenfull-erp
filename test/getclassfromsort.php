<?php
$sortid=$_GET["sortid"];
require_once("getdata.php");
require_once("sqlconnect.php");
function array2option($data)
{

	for($i=0;$i<count($data);$i++)
	{
	echo "<option value=".$data[$i][0].">".$data[$i][1]."</option>  ";
	}
}
array2option(sortHasClass($sortid));
?>