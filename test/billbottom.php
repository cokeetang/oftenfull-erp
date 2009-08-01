<?php
session_start();
if(!$_SESSION['OrgID'])
{
require_once("returnlogin_1.html");
}
else
{
	
	$billtype=$_GET["type"];
	echo "<div><a  href='billadd.php?type=".$billtype.">".新增."</a></div>";
	}
?>
