<?php
header("Cache-Control: no-cache, must-revalidate"); 
$orgid=$_GET["orgid"];
require_once("../sqlconnect.php");
	$query="delete from tbOrg where id={$orgid}";
	mysql_query($query);
	$query="delete from tbMember where fdOrgID={$orgid}";
	mysql_query($query);	
	echo "OK";
	
?>