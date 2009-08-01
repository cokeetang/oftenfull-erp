<?php 
$classid=$_GET["classid"];
require_once("sqlconnect.php");
	$query="select fdName from tbClass where id={$classid}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		echo $row["fdName"];
		}
?>