<?php
$abstract=$_POST["abstract"];
$billid=$_POST["id"];
require_once("../sqlconnect.php");
$query="update tbBill set fdAbstract='{$abstract}' where id={$billid}";
mysql_query($query);
if(mysql_affected_rows()==1)
{
	echo "<script type='text/javascript'>alert('修改成功');</script>";
	
	}
else
{
echo "<script type='text/javascript'>alert('修改失败，返回重修操作');</script>";
}
?>
<script type="text/javascript">
window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
window.close();	
</script>