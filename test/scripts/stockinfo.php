<?php
session_start();
require_once("../sqlconnect.php");
$orgid=$_SESSION["OrgID"];
$billid=$_GET["billid"];
require_once("../getdata.php");
?>

		
		
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>此刻库存详情</title>
<link rel="stylesheet" rev="stylesheet" href="../table.css"/>
</head>

<body>
<?php
showorgtableonlyfull($orgid,$billid);
?>
</body>
</html>