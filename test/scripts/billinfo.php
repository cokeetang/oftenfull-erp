<?php
session_start();
require_once("../sqlconnect.php");
$orgid=$_SESSION["OrgID"];
$billid=$_GET["billid"];
$query="select * from tbBill where id={$billid}";
$result=mysql_query($query);
$billtype=mysql_result($result,0,"fdBillTypeID");
$audit=mysql_result($result,0,"fdAudit");
$confirm=mysql_result($result,0,"fdConfirm");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="../print.css"/>
<title>所做的处理</title>
</head>

<body>
<?php
echo "表单审核时间：".$audit."<br/>";
echo "表单创建时间：".$confirm;
?>
<br/>
表单内容：
<?php
	require_once("../billdata.php");
	printbillitem($billtype,$billid);
?>
</body>
</html>