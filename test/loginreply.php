<?php 
session_start();
$tureverify=$_SESSION['verify'];
$verify=strtolower($_POST["verify"]);
$id=$_POST["id"];
$pwd=$_POST["pwd"];
if(!$verify||!$verify)
{
echo "�������벻����,ҳ����"."<span style='color:red' id='time'></span>"."���ڻ��Զ���ת����½ҳ";
require_once("returnlogin.html");
}
elseif($tureverify!=$verify)
{
echo "��֤�벻��ȷ,ҳ����"."<span style='color:red' id='time'></span>"."���ڻ��Զ���ת����½ҳ";
require_once("returnlogin.html");
}
else
{
	require_once("sqlconnect.php");
	$result=mysql_query("select fdPassword,fdDisabled from tbOrg where fdLogin='{$id}'");
	if(!mysql_num_rows($result))
	{
echo "�����ڸ��û���,ҳ����"."<span style='color:red' id='time'></span>"."���ڻ��Զ���ת����½ҳ";
require_once("returnlogin.html");
}
elseif(mysql_result($result,0,"fdDisabled"))
{
echo "���ʺ��ѽ��ã���ȷ����Ҫ����ϵ����Ա,ҳ����"."<span style='color:red' id='time'></span>"."���ڻ��Զ���ת����½ҳ";
require_once("returnlogin.html");	
}
elseif(crypt($pwd,mysql_result($result,0,"fdPassword"))!=mysql_result($result,0,"fdPassword"))
{
	//echo crypt('123456',md5('123456'))."<br/>";
	//echo crypt($pwd,"e1XyWvbZd9MmI");

echo "���벻��ȷ,ҳ����"."<span style='color:red' id='time'></span>"."���ڻ��Զ���ת����½ҳ";
require_once("returnlogin.html");
}
else
{
	echo "��½�ɹ�";
	$result=mysql_query("select id from tbOrg where fdLogin='{$id}'");
	$orgid=mysql_result($result,0,"id");
	$_SESSION['OrgID']=$orgid;
require_once("tohomepage.html");
}
	}
?>