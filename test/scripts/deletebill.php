<?php
$billid=$_GET["billid"];
require_once("../sqlconnect.php");
	$query="delete from tbBill where id={$billid}";
	mysql_query($query);
	$query="delete from tbItem where fdBillID={$billid}";
	mysql_query($query);	
	echo "OK";
	
?>