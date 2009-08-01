<?php
$billid=$_GET["id"];
require_once("../sqlconnect.php");
$query="select fdAbstract from tbBill where id={$billid}";
$result=mysql_query($query);
$abstract=mysql_result($result,0,"fdAbstract");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
window.onload=function(){
	document.getElementById('qingkong').onclick=function(){
		document.getElementById('abstract').value='';
		}
	}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>表单摘要</title>
<style type="text/css">
textarea{
	width:100%;
	height:250px;}
</style>
</head>

<body>
<form method="post" action="editabstractreply.php">
<textarea name="abstract" id="abstract"><?php echo $abstract; ?>
</textarea>
<input type="text" value="<?php echo $billid;?>" style="display:none" name="id"/>
<input type="submit" value="确定"/>
<input type="reset" value="重置"/>
<input type="button" id="qingkong" value="清空"/>
</form>
</body>
</html>