<?php
header("Cache-Control: no-cache, must-revalidate"); 
require_once("sqlconnect.php");
if($_GET["sortid"]&&$_GET["roleid"])
{
$sortid=$_GET["sortid"];
$roleid=$_GET["roleid"];
	require_once("getdata.php");
	showsortroletable($sortid,$roleid);
	//echoxmlOC(showOrgs(),showclasss());
	}
elseif($orgid=$_GET["org"])
{
		require_once("getdata.php");
		showorgtable($orgid);
//		echoOrgs(showOrgs());
	//	echoxmlOCO($orgid);

	}
elseif($classid=$_GET["class"])
{
	$showwho=$_GET['showwho'];
		require_once("getdata.php");
		showclasstable($showwho,$classid);
		//echoclasss(showclasss());
		//echoxmlOOC($classid);

	}

	
	


?>