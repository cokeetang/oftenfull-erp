<?php
$roleid=$_GET["roleid"];
require_once("sqlconnect.php");
require_once("getdata.php");
echo echoOrgsOptions(roleHasOrg($roleid));

?>