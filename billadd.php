<?php
session_start();
?>
<head>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>

<script type="text/javascript">
$(function(){
		   $("#addnew").click(function(){
									   $.get("additemreply.php",function(data){
																		 
																		 });
									   window.open($(this).attr("href"),"ADD","width=500px,height=500px");
									   return false;
									   });
		   });
</script>
</head>
<?php
if(!$_SESSION['OrgID'])
{
require_once("returnlogin_1.html");
}
else
{
	
	$billtype=$_GET["type"];
	echo "<div><a id='addnew'  href='billaddtable.php?type=".$billtype.">".新增."</a></div>";

	}
?>