<?php 
session_start();
$tureverify=$_SESSION['verify'];
$verify=strtolower($_POST["verify"]);
$id=$_POST["id"];
$pwd=$_POST["pwd"];
if(!$verify||!$verify)
{
echo "内容输入不完整,页面在"."<span style='color:red' id='time'></span>"."秒内会自动跳转到登陆页";
require_once("returnlogin.html");
}
elseif($tureverify!=$verify)
{
echo "验证码不正确,页面在"."<span style='color:red' id='time'></span>"."秒内会自动跳转到登陆页";
require_once("returnlogin.html");
}
else
{
	require_once("sqlconnect.php");
	$result=mysql_query("select fdPassword,fdDisabled from tbOrg where fdLogin='{$id}'");
	if(!mysql_num_rows($result))
	{
echo "不存在该用户名,页面在"."<span style='color:red' id='time'></span>"."秒内会自动跳转到登陆页";
require_once("returnlogin.html");
}
elseif(mysql_result($result,0,"fdDisabled"))
{
echo "此帐号已禁用，如确切需要请联系管理员,页面在"."<span style='color:red' id='time'></span>"."秒内会自动跳转到登陆页";
require_once("returnlogin.html");	
}
elseif(crypt($pwd,mysql_result($result,0,"fdPassword"))!=mysql_result($result,0,"fdPassword"))
{
	//echo crypt('123456',md5('123456'))."<br/>";
	//echo crypt($pwd,"e1XyWvbZd9MmI");

echo "密码不正确,页面在"."<span style='color:red' id='time'></span>"."秒内会自动跳转到登陆页";
require_once("returnlogin.html");
}
else
{
	echo "登陆成功";
	$result=mysql_query("select id from tbOrg where fdLogin='{$id}'");
	$orgid=mysql_result($result,0,"id");
	$_SESSION['OrgID']=$orgid;
require_once("tohomepage.html");
}
	}
?>