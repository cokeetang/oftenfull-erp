<?php
$orgname=$_GET["orgname"];
require_once("sqlconnect.php");
$query="select id from tbOrg where fdName='{$orgname}'";
$result=mysql_query($query);
if(mysql_affected_rows()==0)
echo "无该人员";
else
{
	require_once("getdata.php");
	showorgtable(mysql_result($result,0,"id"));
	
	
	}

?>