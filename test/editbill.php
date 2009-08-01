<?php
session_start();
$orgid=$_SESSION["OrgID"];
//$auditid=$_SESSION["auditid"];
require_once("ifshenhe.php");
require_once("check.php");
require_once("sqlconnect.php");

$edit=$_GET["edit"];
$add=$_GET["add"];
$billid=$_GET['billid'];
if($billid=='')
{
	$billid=0;
	}
$billtype=$_GET['billtype'];
if($billtype=='')
{
	require_once("sqlconnect.php");
	$result=mysql_query("select fdBillTypeID,fdFromOrgID,fdToOrgID from tbBill where id={$billid}");
	$billtype=mysql_result($result,0,"fdBillTypeID");	
	$fromid=mysql_result($result,0,"fdFromOrgID");
	$toid=mysql_result($result,0,"fdToOrgID");
	}
require_once("sqlconnect.php");
$shenhe=checkifshenhe($billid);
if(($shenhe[0]!=0&&$shenhe[0]!=3)||$orgid==$toid)
echo "<script type='text/javascript'>window.location.href='sq.php?status=".$shenhe[0]."&id=".$billid."&type=".$billtype."';</script>";
//mysql_query("insert into tbBill(fdbilltypeid) values({$billtype})" );
//$result=mysql_query("select id from tbBill");
//echo mysql_result($result,0,"id");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="table.css" rel="stylesheet" rev="stylesheet"></link>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/ajaxfileupload.js"></script>
<script type="text/javascript">
		   		   //全局变量
		   fullcost=0;//全部items价格的和
		   ifadditem=1;//判断行为是编辑还是增加
		   startid=5000;
		   nowid=0;
		   array_del=[];//删除数组
		   array_edit=[];//编辑数组
		   array_add=[];//新增数组

$(function(){

		   		   		   $("tr").live("mouseover",function(){$(this).css("backgroundColor","#f99")});
		   $("tr").live("mouseout",function(){$(this).css("backgroundColor","#fff")});

		 //  from:$("#from select").attr("value"),to:$("#to select").attr("value")
		 $("#upfrom").val($("#from select").val());
		 $("#upto").val($("#to select").val());
		 $("#from select").change(function(){
										   $("#upfrom").val($(this).val());
										   });
		 $("#to select").change(function(){
										   $("#upto").val($(this).val());
										   });
		   
		   
		  		    if("<?php echo $edit;?>")
		   {
			   $("#to").css("display","none");
			   }

		   function changefullcost(thedata){
	$("#fullcost").html(thedata);}
		   $("#queren").click(function(){
									   $.get("queren.php",{billid:<?php echo $billid ?>,auditid:<?php echo $orgid ?>},function(data){
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
		   $("#zuofei").click(function(){
									   $.get("zuofei.php",{billid:<?php echo $billid ?>,auditid:<?php echo $orgid ?>},function(data){
			if(data=="OK"){
			window.close();
			window.opener.location.href=window.opener.location.href;}});
									   return false;
									   });
		   $("#chancelzuofei").click(
									 function(){
										$.get("zuofei.php",{chancel:1,billid:<?php echo $billid ?>,auditid:<?php echo $orgid ?>},function(data){
			if(data=="OK"){
			window.close();
			window.opener.location.href=window.opener.location.href;}
	
	}) ;
										 
										 return false;
										 }
				
									 );
		   $("#shenhe").click(function(){
									   $.get("shenhe.php",{billid:<?php echo $billid ?>,auditid:<?php echo $orgid ?>},function(data){
if(data=="OK")																																																											{
alert("成功");


//window.opener.document.getElementsByTagName("option")[<?php echo $billtype;?>].selected=true;	
window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
window.close();																																																									}
else
alert(data);
});
									 
									   return false;});

	  

		   $("#neworg").click(function(){
									   
									   window.open("neworg.php?role=6&style=2","neworg","width=200,height=300");
									   
									   });
		   		   $("#neworg_5").click(function(){
									   
									   window.open("neworg.php?role=5&style=2","neworg","width=200,height=300");
									   
									   });
		   
		   $("#tijiao").click(
							  function(){
								  
			 $thetr=$("#itemreply table").find(".newitem");
			   $thetr.each(function(){
								  array_add.push("{\"id\":"+$(this).find("td:eq(1)").attr("href")+",\"sn\":\""+$(this).find("td:eq(2)").text()+"\",\"count\":"+$(this).find("td:eq(3)").text()+",\"price\":\""+$(this).find("td:eq(4)").text()+"\"}");	
								  
									});	
			  //send editdata;
			  
			  $.post("editbillreply.php",{from:$("#from select").attr("value"),to:$("#to select").attr("value"),billid:<?php echo $billid; ?>,billtype:<?php echo $billtype; ?>,"del[]":array_del,"edit[]":array_edit,"add[]":array_add},function(data){
																																																												 		   array_del=[];//删除数组
		   array_edit=[];//编辑数组
		   array_add=[];//新增数组
																																																												if(data=="OK")																																																											{
alert("成功");


//window.opener.document.getElementsByTagName("option")[<?php echo $billtype;?>].selected=true;	
window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
window.close();																																																									}
else
alert(data);
window.opener.document.getElementsByTagName("select")[0].fireEvent("onchange");	
window.close();	
}
);

			   
			   
			   });
		   $("#fanhui").click(function(){
									   window.location.reload();});
		   $(".close").click(function(){
									  $(".hideplace").hide("slow");
									  return false;
									  
									  
									  });
//		   $("#addbtn").click(function(){
//									   
//										      $.post("additemreply.php",{billid:<?php// echo $billid;?>,sortid:$("#hideadd select:eq(0)").attr("value"),classid:$("#hideadd select:eq(1)").attr("value"),sn:$("#sn").attr("value"),count:$("#count").attr("value"),price:$("#price").attr("value")},function(data){
//																																																//   billid=data;
//																																																   	window.reload();
//																			
//																			});});

														$(".deleteitem").live("click",function(){
																							    
																   $(this).parent().parent().remove();
																   fullcost=0;
																							    $("#itemreply table .item").each(function(){
																													 
													 fullcost+=Number($(this).find("td:eq(5)").text());});
		   changefullcost(fullcost);
																   		  
																   if($(this).parent().parent().hasClass("olditem"))
																   {
																	   array_del.push("{\"id\":"+$(this).parent().parent().find("td:eq(0)").find("a").attr("id")+",\"count\":\""+$(this).parent().parent().find("td:eq(2)").text()+"\",\"count\":"+$(this).parent().parent().find("td:eq(3)").text()+",\"price\":\""+$(this).parent().parent().find("td:eq(4)").text()+"\"}");

																																				
																	   }
																   return false;
																   });
																										 $.get("sorthassn.php?sortid="+$("#hideadd select:first").attr("value"),function(data){
																											  if(data==1){
																												  $("#snl").show();
																												
																											  $("#count").attr("value",1);
																											  $("#countl").hide();}
																											  else
																											  {
																												  $("#snl").hide();
																												  $("#count").attr("value","");
																												  $("#countl").show();}
																											  
																											  });
												 $.get("getclassfromsort.php?sortid="+$("#hideadd select:first").attr("value"),function(data){
																										$("#class").html(data);});								   
$("#addbtn").click(function(){
	$("#tijiao").removeAttr("disabled");
	
							if(ifadditem==0)
							{
								
								//alert(nowid);
								thetr=$("#"+nowid).parent().parent();
								thetr.find("td:eq(2)").text($("#sn").val());
								thetr.find("td:eq(3)").text($("#count").val());
								thetr.find("td:eq(4)").text($("#price").val());
								thetr.find("td:eq(5)").text($("#count").val()*$("#price").val());
								ifadditem=1;
								$("#hideadd").hide("slow");
								
								 if(thetr.hasClass("olditem"))
								 {
									 array_edit.push("{\"id\":"+nowid+",\"sn\":\""+$("#sn").val()+"\",\"count\":"+$("#count").val()+",\"price\":\""+$("#price").val()+"\"}");
									
									 }
									  fullcost=0;
										   $("#itemreply table .item").each(function(){
																					  
													 fullcost+=Number($(this).find("td:eq(5)").text());});
		   changefullcost(fullcost);
								
								}
							else
							{
				

							$.get("getclassname.php?",{classid:$("#class").val()},function(data){
																								 
									$("#itemreply table").append("<tr class='newitem item' ><td class='class'><a id="+(nowid=startid++)+" class='edititem' href='#'>编辑</a></td><td class='class new' href="+$("#class").val()+">"+data+"</td><td class='class new'>"+$("#sn").attr("value")+"</td><td class='class new'>"+$("#count").attr("value")+"</td><?php if($billtype!=2) echo "<td class='class new'>\"+$(\"#price\").attr(\"value\")+\"</td><td class='class new' >\"+Number($(\"#count\").attr(\"value\"))*Number($(\"#price\").attr(\"value\"))+\"</td>"; ?><td class='class new'><a href='#' class='deleteitem'>X</a></td></tr>");	
									$("#itemreply").find("td").removeClass("nowitem");
									//$("#"+nowid).parent().parent().parent().fadeOut("slow");
									//$("#"+nowid).parent().parent().parent().fadeIn("slow");
									$("#"+nowid).parent().parent().find("td").addClass("nowitem");
									fullcost=0;
											   $("#itemreply table .item").each(function(){
																						 
													 fullcost+=Number($(this).find("td:eq(5)").text());});
		   changefullcost(fullcost);
																								 });
							$("#hideadd").hide("slow");
							
							}
							});

		   $(".edititem").live("click",function(){
												$("#addbtn").val("修改");
									if($("#hideadd").attr("display")!="block")
									{			
									$("#hideadd #sn").prevAll().hide();
									nowid=$(this).attr("id");
									var sn=$(this).parent().parent().find("td:eq(2)").html();
									if(sn!="&nbsp;")
									{
										$("#snl").show();
									$("#countl").hide();
									
									$("#sn").val(sn);
										}
										else
										sn='';
									
									var count=$(this).parent().parent().find("td:eq(3)").html();
									if(count!=1){
									$("#countl").show();
									$("#snl").hide();
									$("#count").val(count);
									}
									$("#price").val($(this).parent().parent().find("td:eq(4)").html());
									ifadditem=0;
									$("#hideadd").show("slow");
									$("#itemreply").find("td").removeClass("nowitem");
									$("#"+nowid).parent().parent().find("td").addClass("nowitem");
									}
									else
									{ifadditem=0;
									nowid=$(this).attr("id");
										}
									return false;
									
									});
		   $("#add").click(function(){
									$("#addbtn").val("添加");
									$("#sn").val("");
									$("#price").val("");
									 $("#hideadd #sn").prevAll().show();
									$("#hideimport").hide("slow");
									$("#hideadd").show("slow");
									});
		   $("#import").click(function(){
										
									$("#hideimport").show("slow");
									$("#hideadd").hide("slow");
									   });
		   
		   $("#type").find("option[value=<?php echo $_GET['type']?>]").attr("selected","selected");
		   $("#hideadd select:first").change(
											 function(){
												 $.get("getclassfromsort.php?sortid="+$(this).attr("value"),function(data){
																										$("#class").html(data);});
												 $.get("sorthassn.php?sortid="+$(this).attr("value"),function(data){
																											  if(data==1){
																												  $("#snl").show();
																												
																											  $("#count").attr("value",1);
																											  $("#countl").hide();}
																											  else
																											  {
																												  $("#sn").attr("value","");
																												  
																												  $("#snl").hide();
																												
																												  $("#count").attr("value","");
																												  $("#countl").show();}
																											  
																											  });
												 }
											 
											 );
		   
		   $("#itemreply table .item").each(function(){
													
													 fullcost+=Number($(this).find("td:eq(5)").text());});
		   changefullcost(fullcost);
		   $("#uploadbtn").click(function(){
										  $("#hideimport").hide();
										
										  $("#uploadreply").show();
										  
										  });
		   		 if(<?php echo $billid;?>)
				 {
				 if(<?php echo $shenhe[0];?>>=2)
		  {
			  $("#itemreply a").removeAttr("href");
			 }
				 }
		   
		   });
</script>
<link href="table.css" rel="stylesheet" rev="stylesheet"/>
<style type="text/css">
.hideplace{
	border:1px #666 solid;
	display:none;}
.type{
	float:left;
	border:1px #036 solid;
	margin:3px;
	padding:5px;
	color:#C63;
	font-style:italic;}
#billcost{
	
	
	}
#neworg{
	display:block;
	margin-top:15px;
	margin-left:5px;
	width:70px;}
a{
	text-decoration:none;
	color:#06C;
	font-size:0.9em;
	}
a:hover{
	color:#C30;
	text-decoration:underline;}
</style>
<?php
$query="select fdName from tbBillType where id={$billtype}";
$result=mysql_query($query);
?>
<title><?php echo mysql_result($result,0,"fdName");?></title>
</head>

<body>

<?php

//require_once("billdata.php");
//data2select(getdata("tbOrg"));

require_once("memdata.php");
require_once("scripts/arrayfinction.php");
if($orgid==$fromid||$billid==0)
{
if($billtype==1)//进仓单
{
	echo "<div id='from' class='type'>";
	echo "从: ";
	array2select(getOrgFromRoles(array(1)));//仅供应商
	echo "</div>";
	echo "<div id='to' class='type'>";
	echo "到: ";
	array2select(getOrgFromRoles(array(2)));//仅供应商
	echo "</div>";

	}
else if($billtype==2)//调货单
{
//		echo "<div id='from' class='type'>";
//	echo "从";
//	array2select(getOrgFromRoles(array(2,3,4)));//内部员工、外部员工、仓库
//		echo "</div>";
		echo "<div id='to' class='type'>";
	echo "到: ";
	array2select(deleteDataInArrayByKey($orgid,getOrgFromRoles(array(2,3,4))));//内部员工、外部员工、仓库
		echo "</div>";
	}
else if($billtype==3)//调货单
{
			echo "<div id='from' class='type'>";
			echo "从: ";
	array2selectwithself(array($orgid,'*自己的库存*'),getOrgFromRoles(array(2)));//仅供应商
	echo "</div>";



		echo "<div id='to' class='type'>";

	echo "到: ";
	array2select(getOrgFromRoles(array(5,6)));//经销商/客户
		echo "</div>";
	echo "<a href='#' id='neworg' style='clear:left; float:left'>添加新客户</a>";
	echo "<a href='#' id='neworg_5' style='float:left'>添加新的经销商</a>";

	}
else if($billtype==4)//调货单
{
		echo "<div id='from' class='type'>";
	echo "从: ";
	array2select(getOrgFromRoles(array(5,6)));//经销商/客户
	echo "</div>";
		echo "<div id='to' class='type'>";
	echo "到: ";
	array2select(getOrgFromRoles(array(2)));//仓库
		echo "</div>";
	
	}
}
else
{

	}


?>


<br/>
<div style="clear:left;">
<?php

if($billid=='')
{
	echo "<a href='#' id='add'>新增</a> / <a href='#' id='import'>导入</a>&nbsp";
	}
else if((($orgid==$fromid)||isOrgHasPri($orgid,$billtype+4))&&$shenhe[0]==0&&($orgid!=$toid))
echo "<a href='#' id='add'>新增</a> / <a href='#' id='import'>导入</a>&nbsp";

$query="select id from tbItem where fdBillID={$billid}";
$result=mysql_query($query);
if(mysql_affected_rows()&&(isOrgHasPri($orgid,$billtype)&&($shenhe[0]==0)))
echo "  <a href='#' id='shenhe'>审核</a>";
if($shenhe[0]==1&&$shenhe[0]!=3&&isOrgHasPri($orgid,$billtype))
{
echo "  <a href='#' id='zuofei'>作废</a>&nbsp";

}
if($shenhe[0]==3)
echo "<a href='#' id='chancelzuofei'>取消作废</a>";
if(($orgid==$toid||($billtype==3&&isOrgHasPri($orgid,3)))&&$shenhe[0]==1)
echo "<a href='#' id='queren'>确认</a> &nbsp;<br/>";


?>

</div>
<div id="itemreply">

<?php
if($billid!='')
{
	require_once("billdata.php");
	showbillitem($billtype,$billid);
	}
else
{
		echo "<table>";
	echo "<tr>";
	echo "<td class='head'>ID</td>";	
	echo "<td class='head'>名称</td>";
	echo "<td class='head'>S/N</td>";
	echo "<td class='head'>数量</td>";
if($billtype!=2){
	echo "<td class='head'>单价<tt>（/元）</tt></td>";
	echo "<td class='head'>合计<tt>（/元）</tt></td>";
}
	echo "<td class='head'>删除</td>";
	echo "</tr>";
	echo "</table>";
	}
?>

</div>

<div>
<div id="billcost">
<div id="hideadd" class="hideplace">
<a>大类</a><?php
require_once("getdata.php");
array2select(showsort());
?>
<a>细类</a><select id="class"></select><br/>
<div id="snl">S/N&nbsp;<input type="text"  id="sn"value=""/></div>
<div id="countl">数量<input type="text" id="count" value=""/></div>
<?php
if($billtype!=2)
echo "单价<input type='text' id='price' value=''/><tt>（/元）</tt><br/>";
?>
<input type="button" id="addbtn" value="添加"/>
<input type="button" value="清空"/>
<a href="#" class="close">&times;</a>
</div>

<div id="hideimport" class="hideplace">
<form action="uploadcsv.php" enctype="multipart/form-data" method="post">
<input id="csvfile" type="file" name="csvfile" value=""/>
<input type="text" value=<?php echo $billtype;?> style="display:none" name="billtype" />
<input type="submit" value="上传" id="uploadbtn"/>
<input type="text" name='billtype' value="<?php echo $billtype;?>" style="display:none"/>
<input type="text" name='upfrom' value="<?php echo $orgid;?>" id="upfrom" style="display:none"/>
<input type="text" name='upto' value="" id="upto" style="display:none"/>
</form>
<a href="#" class="close">&times;</a>
</div>
<span>总金额：</span>
<span id="fullcost"></span>
<span id="pages"></span>
</div>
<?php
if($shenhe[0]==0)
{
echo "<input type='button' disabled='disabled' value='提交' id='tijiao' name='tijiao'/><input type='button' value='恢复' id='fanhui' name='fanhui'/>";
}
?>
</div>
</body>
</html>
