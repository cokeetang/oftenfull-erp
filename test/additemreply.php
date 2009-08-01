<?php
$sortid=$_POST["sortid"];
$classid=$_POST["classid"];
$billid=$_POST["billid"];
$sn=$_POST["sn"];
$count=$_POST["count"];
$price=$_POST["price"];
$from=$_POST["from"];
$to=$_POST["to"];
$create=date("Y-n-j-H-i-s");
require_once("sqlconnect.php");
if(!isset($_GET["$billid"]))
{
mysql_query("insert into tbBill(fdBillTypeID,fdFromOrgID,fdToOrgID) values({$type},{$from},{$to})" );
$result=mysql_query("select id from tbBill");
echo mysql_result($result,0,"id");
}
else
{
	
	
	}
?>