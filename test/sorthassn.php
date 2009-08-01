<?php
function sortHasSN($sortid)
{
	$query="select fdHasSN from tbSort where id={$sortid}";
	$result=mysql_query($query);
	return mysql_result($result,0,"fdHasSN");
	}
$sortid=$_GET["sortid"];
if($sortid<=7)
{
require_once("sqlconnect.php");
echo sortHasSN($sortid);	
}
else
{
	echo "NO";
	}
?>