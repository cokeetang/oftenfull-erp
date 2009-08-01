<?php
$id=$_POST["id"];
$name=$_POST["name"];
$login=$_POST["login"];
$contact=$_POST["contact"];
if($_POST["disable"]=='on')
$disable=1;
else
$disable=0;
$newroles=$_POST["roles"];
require_once("sqlconnect.php");
require_once("check.php");
$result=mysql_query("update tbOrg set fdLogin='{$login}',fdContact='{$contact}',fdName='{$name}', fdDisabled={$disable} where id={$id}");
$result=mysql_query("delete from tbMember where fdOrgID={$id}");
foreach($newroles as $newrole)
mysql_query("insert into tbMember(fdOrgID,fdRoleID) values($id,$newrole)");


?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
alert("修改成功");
window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
//window.opener.location.reload();
window.close();
</script>