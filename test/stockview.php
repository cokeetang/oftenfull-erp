<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="table.css" rel="stylesheet" rev="stylesheet"/>
<style type="text/css">
#head{
	width:100%;
	height:50px;
	border-bottom:1px #333 solid;}
#head .type{
	float:left;}
#head .type{
	border:2px  #036 solid;	
	padding:5px;	
	font-size:0.9em;
	font-family:Arial, Helvetica, sans-serif;
	color:#FFF;
	
	background-color:#666;
	}
#head .xuanze{
	color:#FFF;
	border:none;
	
	
	}
#head option{
	color:#000;
	background-color:#FFF;}
#head .biaoti{
	
	
	text-align:center;
	font-weight:bold;
	background-color:#000;}
#returndata{
	width:100%;
	margin-top:10px;}
#stockmem{
	cursor:pointer;
	color:#000;
	
	height:52px;
	width:123px;
	border:2px #03c solid;
	background-color:#666;}
.stockmem{
	background-color:#CCC;}
.type a{
	text-decoration:none;}

</style>
<link rel="stylesheet" rev="stylesheet" href="js/jquery.autocomplete.css"/>
<script type="text/javascript" src="js/jquery-1.3.2.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script type="text/javascript">

//function loadpage(href)
//{
//	$.get(href,function(data){$("#returndata").html(data);});
//
//	}

$(
  function(){
	  $(".type").hover(function(){$(this).css("backgroundColor","#033").css("color","white");},function(){$(this).css("backgroundColor","#666").css("color","#fff");});
	  $("#type2 .roleshow").change(function(){
											$.get("getorg.php",{"roleid":$("#type2 .roleshow").val()},function(data){
																											   $("#type2 #orgshow").html(data);
																											   });
											});
	  $("#stockmem").hover(function(){
									$(this).addClass("stockmem");},function(){
									$(this).removeClass("stockmem");});
	  $("#stockmem").click(function(){
									window.open("scripts/stockmem.php","","width=530,height=500");});
	  		   $("tr").live("mouseover",function(){$(this).css("backgroundColor","#f99")});
		   $("tr").live("mouseout",function(){$(this).css("backgroundColor","#fff")});
	  $(".classopen").live("click",function(){
									 window.open($(this).attr("href"),"OrgClassInfo","width=200,height=300,scrollbars,resizable=yes");
									 return false;
									 
									 });
	  $("#type1 .roleshow").change(function(){
									 	 $(this).parent().parent().nextAll().find("select").find("option:eq(0)").attr("selected","selected");
										 $(this).parent().parent().nextAll().css("backgroundColor","white");
										 $(this).parent().parent().css("backgroundColor","#033");
										 if($("#sortshow").attr("value")!='选择')
									$.get("stock.php",{roleid:$(this).attr("value"),sortid:$("#sortshow").attr("value")},function(data){
																						   $("#returndata").html(data);

																						   
																						   });
									else
									{
										$("#returndata").html("");
										}
									});
									
	  $("#sortshow").change(function(){
									 
									 $(this).parent().parent().nextAll().find("select").find("option:eq(0)").attr("selected","selected");
									 $(this).parent().parent().nextAll().css("backgroundColor","white");
									$(this).parent().parent().css("backgroundColor","#033");
									  if($("#type1 .roleshow").attr("value")!='某角色')
									$.get("stock.php",{sortid:$(this).attr("value"),roleid:$("#type1 .roleshow").attr("value")},function(data){
																						   $("#returndata").html(data);

																						   
																						   });
										else
									{
										$("#returndata").html("");
										}
									});
	  $("#orgshow").change(function(){
									$(this).parent().parent().nextAll().find("option:eq(0)").attr("selected","selected");
									$(this).parent().parent().css("backgroundColor","#033");
									$(this).parent().parent().nextAll().css("backgroundColor","white");
									$(this).parent().parent().prev().css("backgroundColor","white");
									$(this).parent().parent().prev().find("select").find("option:eq(0)").attr("selected","selected");
									$.get("stock.php",{"org":$(this).attr("value")},function(data){
																						   $("#returndata").html(data);

																						   
																						   });
									});
	  $("#classshow").change(function(){
									$(this).parent().parent().prevAll().find("select").find("option:eq(0)").attr("selected","selected"); 
									$(this).parent().parent().css("backgroundColor","#033");
									$(this).parent().parent().prevAll().css("backgroundColor","white");
									$.get("stock.php",{"class":$(this).attr("value")},function(data){
																						   $("#returndata").html(data);
									});
									});
	  $("#orgid_txt").autocomplete("get_auto_complete.php");
	  $("#org_auto_query").submit(function(){
										   if($("#orgid_txt"))
										   {
											$.get("get_auto_complete_query.php",{"orgname":$("#orgid_txt").attr("value")},function(data){
																						   $("#returndata").html(data);

																						   
																						   });
											   }
										   
										   return false;
										   
										   });
	  
	  
	  });
</script>
</head>
<body><?php
require_once("sqlconnect.php");require_once("getdata.php");?>
<div id="head">
<div class="type" id="type1">
<div class="biaoti">查询一</div>
<div class="xuanze">
<?php showRoleSelect(showrole());echo "库存"; showSortSelect(showsort());echo "的情况"; ?></div></div>
<div class="type" id="type2">
<div class="biaoti">查询二</div>
<div class="xuanze"><?php showRoleSelect(showrole()); echo "中";echoOrgs(roleHasOrg(0));echo "的库存情况";?></div>
<div class="xuanze" style="border-top:1px dashed #000; padding-top:2px; margin-top:2px"><form id="org_auto_query" style="padding:0px; margin:0px;"><input type="text" style="width:120px" id="orgid_txt"/>的库存情况<input type="submit" value="查询" name="orgid_txt_submit" id="orgid_txt_submit"/></form></div>
</div>
<div class="type" id="type3">
<div class="biaoti">查询三</div>
<div class="xuanze">
<?php echoclasss(showclasss()); echo "的库存情况";?></div></div>
<input type="button" class="type" value="查询库存流水记录" id="stockmem" />
</div>
<div id="returndata">
</div>


</body>