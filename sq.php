<?php
session_start();
$orgid=$_SESSION["OrgID"];
$billstatus=$_GET["status"];
$billid=$_GET["id"];
$billtype=$_GET["type"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/jquery.PrintArea.js"></script>

<script type="text/javascript">
$(function(){
		   		   		   $("tr").live("mouseover",function(){$(this).css("backgroundColor","#f99")});
		   $("tr").live("mouseout",function(){$(this).css("backgroundColor","#fff")});
		   $("#dayin").hover(function(){$(this).find("img").attr("src","imgs\\print_2.jpg");},function(){$(this).find("img").attr("src","imgs\\print_1.jpg");});
		   $("#dayin").click(function(){
									  $("#returndata").printArea();
									  return false;
									  
									  });
		   $("#queren").click(function(){
									   $.get("queren.php",{billid:<?php echo $billid ?>},function(data){
if(data=="OK")																																																											{
alert("成功");


//window.opener.document.getElementsByTagName("option")[<?php echo $billtype;?>].selected=true;	
window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
window.close();																																																									}
else
alert(data);
});
									   return false;
									   
									   });
		   
		   
		   });
</script>
<link rel="stylesheet" rev="stylesheet" href="print.css"/>
</head>
<body><div>
<?php

if($billstatus==1)
{
echo "<a href='#' id='queren'>确认</a> &nbsp;";
}
if($billstatus>=1)
echo "<a href='#' id='dayin'><img src='imgs\print_1.jpg'/>打印报表</a> &nbsp;<br/>";
?>

</div>
<div id="returndata">
<?php

require_once("sqlconnect.php");
require_once("billdata.php");
printbillitem($billtype,$billid);
?>
</div>
</body>
</html>
