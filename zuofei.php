<?php
$billid=$_GET["billid"];
$auditid=$_GET["auditid"];
require_once("sqlconnect.php");
if($_GET["chancel"]==1)
{
	
$query="update tbBill set fdAuditOrgID={$auditid},fdStatus=0 where id={$billid}";
mysql_query($query);
if(mysql_affected_rows())
echo "OK";	
	
	}
else
{
	$cancel=date("Y-n-j H:i:s");
	
$query="update tbBill set fdAuditOrgID={$auditid},fdStatus=3,fdCancel='{$cancel}' where id={$billid}";
mysql_query($query);
if(mysql_affected_rows())
echo "OK";	
	}

?>