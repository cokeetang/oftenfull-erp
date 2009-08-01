<?php
$loginname=$_GET["login"];
$bloginname=$_GET["blogin"];
require_once("../sqlconnect.php");
if($loginname)
{
if($loginname==$bloginname)
echo 0;
//检查是否该loginname可用
else
{
$query="select fdLogin from tbOrg where fdLogin='{$loginname}'";

$result=mysql_query($query);
if(mysql_num_rows($result))
echo 1;
else
echo 0;
}
}
?>