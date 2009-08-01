<?php
header("Cache-Control: no-cache, must-revalidate"); 
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="table.css" rel="stylesheet" rev="stylesheet"/>
<style type="text/css">
#head{
	width:100%;
	height:50px;
	border-bottom:1px #333 solid;}
#head div,a{
	float:left;}
#head #role{
	border:1px #036 solid;
	margin-left:10px;
	padding:5px;
	margin-left:2px;
	font-size:0.9em;
	font-family:Arial, Helvetica, sans-serif;
	color:#930;
	font-style:italic;
}
a{
	text-decoration:none;}

#head div a{
	text-decoration:none;
	padding-top:7px;
	padding-left:7px;}
#head div a:hover{
	text-decoration:underline;}
	a:hover{
	text-decoration:underline;}

</style>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
$(function(){
		   $("#bottom td").find("a[cc]").live("click",function(){
															   thedelete=$(this);
												 $.get("scripts/deleteorg.php",{orgid:$(this).attr("cc")},function(data){
																													  if(data=="OK")
																												  {
																													  alert("删除成功");
																													  
																													  thedelete.parent().parent().css("backgroundColor","#f99");
																													  thedelete.parent().parent().hide("slow");}
																													  else
																													  {
																														  alert("删除失败");}
																													  
																													  });
												return false;
												});
		   		   $("#neworg").live("click",function(){
									   
									   window.open("neworg.php?style=1&role="+$("#head select").attr("value"),"neworg","width=200,height=300");
									   
									   });
		   $("tr").live("mouseover",function(){$(this).css("backgroundColor","#f99")});
		   $("tr").live("mouseout",function(){$(this).css("backgroundColor","#fff")});
		   window.name="org";
		    $.get("orgdata.php",{roleid:$("#head select").attr("value")},function(data){																										 $("#bottom").html(data);});
		   $("#bottom a[tt='']").live("click",function(){
										window.open($(this).attr("href"),"editorg","height=400px,width=250px");
										 return false;}
									 );
		   
		   $("#head select").change(function(){
											 if($(this).attr("value"))
											 $("#addhave").html("<a href='#' id='neworg'>添加</a>");
											 else
											  $("#addhave").html("");
											 	 $.get("orgdata.php",{roleid:$(this).attr("value")},function(data){
																										 $("#bottom").html(data);});
										
											 });
		   
		   
		   });
</script>
</head>
<div id="head">
<div id="role">角色：
<?php
require_once("sqlconnect.php");
require_once("getdata.php");
showRoleSelect(showrole());
?>
</div>
<div id="addhave" ></div>
</div>
<div id="bottom"></div>