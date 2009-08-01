<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
<?php
$name=$_POST["name"];
$style=$_POST["style"];
$roleid=$_POST["role"];
$login=$_POST["login"];
$pass=$_POST["pass"];
if($login=='')
$login=$name;
if($pass=='')
$pass=="123456";
$pass=crypt($pass,md5($pass));
$abstract=$_POST["abstract"];
require_once("sqlconnect.php");
$query="insert into tbOrg(fdName,fdLogin,fdPassword,fdContact,fdDisabled) values('{$name}','{$login}','{$pass}','{$abstract}',0)";
mysql_query($query);
$query="select id from tbOrg order by id DESC";
$orgid=mysql_result(mysql_query($query),0,"id");
$query="insert into tbMember(fdOrgID,fdRoleID) values({$orgid},{$roleid})";
mysql_query($query);

if(mysql_affected_rows())
{
	echo "<script type='text/javascript' src='js/jquery-1.3.2.js'></script>";
echo "<script type='text/javascript'>";
echo "alert('添加成功');";
if($style==2)
{
echo "$(window.opener.document).find('select:eq(1)').prepend('<option  value=".$orgid.">".$name."</option>');";
echo "$(window.opener.document).find('select:eq(1)').find('option:eq(0)').attr('selected','selected');";
}
else
{
echo "window.opener.document.getElementsByTagName('select')[0].fireEvent('onchange');";	
	
}
echo "window.close();";
echo "</script>";
	
	}
?>
