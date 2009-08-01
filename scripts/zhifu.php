<?php
$billid=$_GET['id'];
$haspay=$_GET['has'];
$fullpay=$_GET['full'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>付款</title>
<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $("#letpay").click(function(){
									   $.get("zhifureply.php",{full:<?php echo $fullpay;?>,id:<?php echo $billid;?>,pay:$("#nowpay").val()},function(data){
											if(data=="OK")
											{
												alert("支付成功");
											window.close();
											window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
											}
											else
											alert(data);
																														 
																														 });
									   });
		   });
</script>
<style type="text/css">
#nowpay{
	width:50px;}
</style>
</head>

<body>
<?php

echo "已支付：".$haspay."元<br/>";
echo "剩余量：".($fullpay-$haspay)."元<br/>";
echo "总额：".$fullpay."元";
if($fullpay!=$haspay)
echo "<input type='text' id='nowpay' /><input id='letpay' type='button' value='现支付'>"; 
?>

</body>
</html>