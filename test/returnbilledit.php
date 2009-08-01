<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>	
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
alert("添加成功");
$(window.opener.document).find("select").prepend("<option  value='<?php echo $orgid;?>'><?php echo $name;?></option>");
$(window.opener.document).find("option:eq(0)").attr("selected","selected");
window.close();
</script>
</head>
</body>
</html>