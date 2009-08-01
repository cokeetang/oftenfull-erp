<?php
$billid=$_GET['id'];
$pay=$_GET['pay'];
require_once("../sqlconnect.php");
$query="update tbBill set fdPayment=fdPayment+{$pay} where id={$billid}";
mysql_query($query);
if(mysql_affected_rows()==1)
echo "OK";
else
echo "插入失败";
?>