<?php
session_start();
$orgid=$_SESSION["OrgID"];
require_once("ifshenhe.php");
require_once("check.php");
require_once("sqlconnect.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript">
//		   function changecolor()
//		   {if($(".s0 .s1").hasClass("ccolor"))
//		      $(".so .s1").removeClass("ccolor");
//			else
//			   $(".s0 .s1").addClass("ccolor");
//
//setTimeout("changecolor()",500);
//			
//			 
//			 }
$(function(){
		   $(".editabstract").live("click",function(){
													window.open("scripts/editabstract.php?id="+$(this).attr("kk"),'',"width=200,height=300");
													return false;
													});
		   $(".zhifu").live("click",function(){
											 window.open(this.href,'',"width=150,height=150");
											 return false;});

			
		   $(".deletebill").live("click",function(){
												  thedelete=$(this);
												  $.get("scripts/deletebill.php",{billid:$(this).attr("tt")},function(data){
																													  if(data=="OK")
																												  {
																													  alert("删除成功");
																													  thedelete.parent().parent().css("backgroundColor","#f99");
																													  thedelete.parent().parent().hide("slow");}
																													  else
																													  {
																														  alert("删除失败");}
																													  
																													  });
												  return false;});
		   
		   		   $("tr").live("mouseover",function(){$(this).css("backgroundColor","#f99")});
		   $("tr").live("mouseout",function(){$(this).css("backgroundColor","#fff")});
		   $("#returndata .pages").live("click",
										 function(){
												 $.get("bill.php",{pagestart:$(this).attr("ref"),billtype:$("#billtype select").attr("value")},function(data){
																															  $("#returndata").html(data);
																				  });	
												 return false;
											 
											 }
										 
										 );
           

		   $("#billtype select").change(function(){
												 $.get("isorghaswrite.php",{orgid:<?php echo $orgid; ?>,billtype:$("#billtype select").attr("value")},function(data){
																																							
																																							    if($("#billtype select").val()>=1)
												 {
													 if(Number(data))
												 {$("#head a").show();
												 $("#head a").attr("href","editbill.php?add=1&billtype="+$("#billtype select").attr("value"));}
												  else
												 $("#head a").hide();
												 
												 //ajax查询
												 $.get("bill.php",{pagestart:1,billtype:$("#billtype select").attr("value")},function(data){
																															  $("#returndata").html(data);
																				  
																				  
																				  });
												 }
												  else
												 $("#head a").hide();
												 
																																							   
																																							   });
												
												
												 });
$(".editid").live("click",function(){
								   
							window.open("editbill.php?edit=1&billid="+$(this).text(),"editbill","width=800,scrollbars,height=400,location=no,status=no");
							return false;
							
							});  


$("#head a").click(function(){
							window.open($(this).attr("href"),"addbill","width=800,height=400,resizeable=no,location=no,status=yes");
							return false;
							});
		   
		   });

</script>
<style type="text/css">

table{
	border:1px #666 solid;}
table .head{
	background-color:#666;
	color:#CCC;
	font-size:1.2em;
	font-style:oblique;
	font-weight:500;
	border-bottom:2px #000 solid;
	}
table .class{
	border-bottom:1px #333 dotted;
	border-right:1px #666 solid;}

#head div{
	float:left;}
#head a{
	margin-left:20px;
	margin-top:5px;
	color:#36C;
	font-size:0.9em;
	display:block;
	margin-top:10px;
	width:30px;
	text-decoration:none;
	}
#head a:hover{
	text-decoration:underline;
	color:#F3F;}	
#returndata{
	width:100%;
	margin-top:10px;}
#returndata .pages{
	margin-left:2px;
	text-decoration:underline;
	color:#930;
	font-size:0.9em;}
.now{

	font-size:0.9em;
	font-stretch:wider;
	color:#666;
	margin-left:2px;
	}

#head{

	width:100%;
	height:50px;
	border-bottom:1px #333 solid;}
#head .type{
	border:1px #036 solid;
	float:left;
	margin-left:10px;
	padding:5px;
	margin-left:2px;
	font-size:0.9em;
	font-family:Arial, Helvetica, sans-serif;
	color:#930;
	font-style:italic;}
.s0{
	color:#FF3l;
	background-color:#C96;
}
.s1{
	color:#900;
	background-color:#39F;
}
.s2{
	color:#06F;
}
.s3{
	color:#666;
}
.ccolor{
	background-color:#F00;}
</style>
</head>
<body>

<div id="head">
<div class="type" id="billtype">
类别：<?php
require_once("sqlconnect.php");
require_once("billdata.php");
require_once("billtypeorghave.php");
//require_once("editorg.php");
require_once("check.php");

data2select(orgHasPriInArray($orgid,array(array(1,"采购单"),array(2,"调拨单"),array(3,"销售单"),array(4,"退货单"))));
//data2select(getdata("tbBillType"));
//data2select(orgHasBiilType($orgid));
?>
</div>
<a href="#" style="display:none">新增</a>
</div>
<div id="returndata">
</div>
</body>


