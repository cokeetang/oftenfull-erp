<?php
$billtype=$_GET["billtype"];
$orgid=$_GET["orgid"];
require_once("check.php");
echo isOrgHasPri($orgid,$billtype+4);
?>