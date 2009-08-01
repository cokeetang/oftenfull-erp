<?php
session_start();
$org=$_SESSION["OrgID"];
require_once("sqlconnect.php");
if($_GET["billtype"]&&$_SESSION["OrgID"])
{
	$org=$_SESSION["OrgID"];
    $billtype=$_GET["billtype"];
	$pagestart=$_GET["pagestart"];
	require_once("billdata.php");
   
	showbilltable($billtype,$org,$pagestart);
//	showsortroletable($sortid,$roleid);

	//echoxmlOC(showOrgs(),showclasss());
	}
?>