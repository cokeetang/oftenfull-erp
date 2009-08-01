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

#head option{
	color:#000;
	background-color:#FFF;}

#returndata{
	width:100%;
	margin-top:10px;}
#stockmem{
	cursor:pointer;
	color:#000;
	float:right;

	width:123px;
}

.type a{
	text-decoration:none;}
.type{
	display:none;}

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
	  $("#ifonlynopaid").click(function(){
										document.getElementById("ifall").fireEvent("onclick");
										});

	  $("#select_type select").change(function(){
											   $val=$(this).val();
											   if($val)
											   {
											   $(".type").hide();
											   $("#type"+$val).show();
											   }

											   
											   
											   });

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
									
									$(this).parent().parent().prev().find("select").find("option:eq(0)").attr("selected","selected");
									$.get("stock.php",{"org":$(this).attr("value")},function(data){
																						   $("#returndata").html(data);

																						   
																						   });
									});
	  $("#class_queue").click(function(){
									
									
									
								    if($("#showall").attr("checked"))
									$.get("stock.php",{"showwho":1,"class":$("#classshow").attr("value")},function(data){
																						   $("#returndata").html(data);
									});
									else if($("#ifall").attr("checked")&&!$("#ifnopaid").attr("checked"))
									$.get("stock.php",{"showwho":2,"class":$("#classshow").attr("value")},function(data){
																						   $("#returndata").html(data);
									});
									else if($("#ifall").attr("checked")&&$("#ifnopaid").attr("checked"))
									$.get("stock.php",{"showwho":3,"class":$("#classshow").attr("value")},function(data){
																						   $("#returndata").html(data);
									});
									else if($("#sale").attr("checked"))
									$.get("stock.php",{"showwho":4,"class":$("#classshow").attr("value")},function(data){
																						   $("#returndata").html(data);
									});
									else if($("#ifonlynopaid").attr("checked"))
									$.get("stock.php",{"showwho":5,"class":$("#classshow").attr("value")},function(data){
																						   $("#returndata").html(data);
									});
									else if($("#ifonlypaid").attr("checked"))
									$.get("stock.php",{"showwho":6,"class":$("#classshow").attr("value")},function(data){
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
<body>
<?php require_once("sqlconnect.php");require_once("getdata.php");?>

<div id="head">
<div id="select_type_c">
<div id="select_type">
<select>
<option value=0 style="background-color:#333; color:#fff">&nbsp;&nbsp;&nbsp;&nbsp;&rarr;请选择某种查询类型&larr;</option>
<option value=1>一:某组织库存某大类产品的情况</option>
<option value=2>二:某单位库存所有产品的情况</option>
<option value=3>三:某细类产品的分布情况</option>

</select>
</div>
<div id="return_type" >
<div class="type" id="type1"><div class="xuanze"><?php showRoleSelect(showrole()); showSortSelect(showsort()); ?></div></div>


<div class="type" id="type2"><div class="xuanze"><?php showRoleSelect(showrole()); echo "中";echoOrgs(roleHasOrg(0));?></div>
<div class="xuanze" style="border-top:1px dashed #000; padding-top:2px; margin-top:2px">
<form id="org_auto_query" style="padding:0px; margin:0px;">输入单位名称<input type="text" style="width:120px" id="orgid_txt"/><input type="submit" value="查询" name="orgid_txt_submit" id="orgid_txt_submit"/></form></div></div>


<div class="type" id="type3">
<div class="xuanze"><?php echoclasss(showclasss()); echo "的库存情况";?></div>
<div id="checkbox_bar"  style="border-top:1px dashed #000; padding-top:2px; margin-top:2px">
<form>
<!--<input class="checkbox" value="" type="radio" name="ifall" id="ifall"/>仅显示公司内部情况？
<input class="checkbox" type="checkbox" id="ifnopaid"/>外加售出未付款的项目？
<input class="checkbox" value="" type="radio" name="ifonlynopaid" id="ifonlynopaid"/>仅显示售出未付款的项目？
<input class="checkbox" value="" type="radio" name="ifonlypaid" id="ifonlypaid"/>仅显示售出已付款的项目-->
<input class="checkbox" name="ssswww" type="radio" value="" checked="" id="showall">显示全部
<input class="checkbox" name="ssswww" type="radio" value=""  id="ifall">仅显示公司内部情况
<input class="checkbox" type="checkbox" id="ifnopaid"/>外加售出未付款的项目？<br/>
<input class="checkbox" name="ssswww" type="radio" value=""  id="sale">显示售出的全部项目
<input class="checkbox" name="ssswww" type="radio" value=""  id="ifonlynopaid">仅显示售出未付款的项目
<input class="checkbox" name="ssswww" type="radio" value=""  id="ifonlypaid">仅显示售出已付款的项目
</form>
<input type="button" value="查询" id="class_queue"/>
</div></div>


</div>
</div>
<input type="button"  value="查询库存流水记录" id="stockmem" />

</div>
<div id="returndata">
</div>


</body>