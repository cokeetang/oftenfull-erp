<?php
session_start();

if(!$_SESSION['OrgID'])
{
require_once("returnlogin_1.html");
}
else
{
	require_once("sqlconnect.php");
	$loginid=$_SESSION['OrgID'];
	if(isset($_GET["info"]))
	{
		if(!isset($_GET["ch"]))
		{
			$result=mysql_query("select fdContact from tbOrg where id='{$loginid}'");
		echo mysql_result($result,0,"fdContact");
		}
		else
		{
			mysql_query("update tbOrg set fdContact='{$_GET["ch"]}' where id='{$loginid}'");
			echo "OK";
			}
		}

	if(!isset($_GET["pwd"]))
	{
		if(isset($_GET["oldpwd"]))
		{
	$result=mysql_query("select fdPassword from tbOrg where id='{$loginid}'");
	$thepwd=mysql_result($result,0,"fdPassword");
	if($thepwd!=crypt($_GET["oldpwd"],$thepwd))
    echo "false";
	else
	echo "OK";}
	}
	else
	{
		$pwd=crypt($_GET["pwd"],md5($_GET["pwd"]));
	$result=mysql_query("update tbOrg set fdPassword='{$pwd}' where id='{$loginid}'");
	echo "OK";

		
		}
}


?>