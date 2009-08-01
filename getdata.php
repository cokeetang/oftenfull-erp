<?php
function roleHasOrgsID($roleid)
{
	$orgsid=array();
	$query="select fdOrgID from tbMember where fdRoleID={$roleid}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		array_push($orgsid,$row["fdOrgID"]);
		}
	return $orgsid;
	}
function roleHasOrg($roleid)
{
	if($roleid){
$orgsid=roleHasOrgsID($roleid);
$orgs=array();
foreach($orgsid as $orgid)
{
	array_push($orgs,array($orgid,orgName($orgid)));
	}}
return $orgs;
	}
//某org的Name信息；
function orgName($orgid)
{
	$query="select * from tbOrg where id={$orgid}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		return $row["fdName"];
		}
	
	}


//显示sort、role库存表
function showsortroletable($sortid,$roleid)
{
	$orgsid=roleHasOrgsID($roleid);
	$orgs=array();
	foreach($orgsid as $orgid)
	array_push($orgs,array($orgid,orgName($orgid)));
	echo "<table>";
	echo "<tr>";
    $classs=sortHasClass($sortid);	
	echo "<td class='head'>&nbsp;</td>";
	foreach($classs as $class)
	{
	echo "<td class='head'>$class[1]</td>";
		}
	echo "</tr>";
foreach($orgs as $org)
{
	echo "<tr>";
	echo "<td class='class'>$org[1]</td>";
	foreach($classs as $class)
	{
	$countinfo=classOrgHasObject($class[0],$org[0],1);
	if($countinfo[0]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	
	echo "<td class='class'><a class='classopen' href=getorghaclassinfo.php?class=".$class[0]."&org=".$org[0].">$countinfo[0]</a></td>";
		}
	echo "</tr>";
	}
	echo "</table>";

	}
//显示class库存表
function showclasstable($showwho,$classid)
{
	echo "<table>";
	echo "<thead><tr>";
	echo "<td class='head'>&nbsp;</td>";	
	echo "<td class='head'>数量（包含在途出）</td>";
	echo "<td class='head'>在途出</td>";
	echo "<td class='head'>在途入</td>";
	echo "</tr></thead>";
	$orgs=showOrgs($showwho,$classid);
	$fullcount=0;
	$fullcount_out=0;
	$fullcount_in=0;
	
	foreach($orgs as $org)
	{
	echo "<tr>";

	$countinfo=classOrgHasObject($classid,$org[0],$showwho);
	if($countinfo[0])
	echo "<td class='class'><a class='classopen' href=getorghaclassinfo.php?class=".$classid."&org=".$org[0].">$org[1]</a></td>";
	else
	echo "<td class='class'>$org[1]</td>";
	if($countinfo[0]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	{
	echo "<td class='class'>$countinfo[0]</td>";
	$fullcount+=$countinfo[0];
	}
	if($countinfo[1]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	{
	echo "<td class='class'>$countinfo[1]</td>";
	$fullcount_out+=$countinfo[1];
	}
	if($countinfo[2]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	{
	echo "<td class='class'>$countinfo[2]</td>";
	$fullcount_in+=$countinfo[2];
	}
	echo "</tr>";	
		}
	echo "<tfoot><tr ><td class='class'>总计</td><td class='class'>$fullcount</td><td class='class'>$fullcount_out</td><td class='class'>$fullcount_in</td></tr></foot>";
	echo "</table>";
	}
//require_once("sqlconnect.php");
//showclasstable(1);
//显示org库存表
function nowhasclass($classid,$orgid)
{
//	$result_0=0;//总数
//	$query_0="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid}";
//	$result=mysql_query($query_0);
//	if(mysql_affected_rows())
//	{
//		while($rows=mysql_fetch_assoc($result))
//		{
//			$result_0+=$rows["fdQuantity"];
//
//		}
//	}
//	return $result_0;
}
function showorgtableonlyfull($orgid,$billid)
{
	echo "方法待修复";
	//if($billid!=0)
//	{
//	$query="select fdToOrgID fro tbBill where id={$billid}";
//	$result=mysql_query($query);
//	if(mysql_result($result,0,"fdToOrgID")==$orgid)
//	$method=-1;
//	else
//	$method=1;
//	$query="select * from tbItem where fdBillID={$billid}";
//	$result=mysql_query($query);
//	while($row=mysql_fetch_assoc($result))
//	{
//		$sn=$row["fdSN"];
//		$class=$row["fdClassID"];
//		$count=$row["fdQuantity"];
//		if($sn)
//		{
//			
//		}
//		
//	}
//	}
//	echo "<table>";
//	echo "<tr>";
//	echo "<td class='head'>&nbsp;</td>";	
//	echo "<td class='head'>数量</td>";
//
//	echo "</tr>";
//	$sorts=showsort();
//	foreach($sorts as $sort)
//	{
//	echo "<tr>";
//	echo "<td class='sort'>$sort[1]</td>";
//	echo "<td class='sort'>&nbsp;</td>";
//
//	echo "</tr>";
//	$classs=sortHasClass($sort[0]);
//	foreach($classs as $class)
//	{
//	echo "<tr>";
//	echo "<td class='class'><a class='classopen' href=getorghaclassinfo.php?class=".$class[0]."&org=".$orgid.">$class[1]</a></td>";
//	$countinfo=classOrgHasObject($class[0],$orgid);
//	if($countinfo[0]==0)
//	echo "<td class='class'>&nbsp</td>";
//	else
//	echo "<td class='class'>$countinfo[0]</td>";
//
//	echo "</tr>";
//		}
//	}
//	echo "</table>";
	}
function showorgtable($orgid)
{
	echo "<table>";
	echo "<tr>";
	echo "<td class='head'>&nbsp;</td>";	
	echo "<td class='head'>数量（包含在途出）</td>";
	echo "<td class='head'>在途出</td>";
	echo "<td class='head'>在途入</td>";
	echo "</tr>";
	$sorts=showsort();
	foreach($sorts as $sort)
	{
	echo "<tr>";
	echo "<td class='sort'>$sort[1]</td>";
	echo "<td class='sort'>&nbsp;</td>";
	echo "<td class='sort'>&nbsp;</td>";
	echo "<td class='sort'>&nbsp;</td>";
	echo "</tr>";
	$classs=sortHasClass($sort[0]);
	foreach($classs as $class)
	{
	echo "<tr>";
	$countinfo=classOrgHasObject($class[0],$orgid,1);
	if($countinfo[0])
	echo "<td class='class'><a class='classopen' href=getorghaclassinfo.php?class=".$class[0]."&org=".$orgid.">$class[1]</a></td>";
	else
	echo "<td class='class'>$class[1]</td>";
	if($countinfo[0]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	echo "<td class='class'>$countinfo[0]</td>";
	if($countinfo[1]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	echo "<td class='class'>$countinfo[1]</td>";
	if($countinfo[2]==0)
	echo "<td class='class'>&nbsp</td>";
	else
	echo "<td class='class'>$countinfo[2]</td>";
	echo "</tr>";
		}
	}
	echo "</table>";
	}

function showOrgs($showwho,$classid)
{
	//$hascustome代表是否包含客户
	
	$thedata=array();
	if($showwho==1)
	$query="select * from tbOrg";
	elseif($showwho==2)
	$query="select * from tbOrg where id in(select fdOrgID from tbMember where fdRoleID=2 or fdRoleID=3)";
	elseif($showwho==3)
	$query="select * from tbOrg where id in(select fdOrgID from tbMember where fdRoleID=2 or fdRoleID=3) or id in(select fdOrgID from tbObject where fdClassID={$classid} and fdPaid=0 and fdQuantity>0 and fdOrgID in(select fdOrgID from tbMember where fdRoleID=5 or fdRoleID=6));";
	elseif($showwho==4)
	$query="select * from tbOrg where id in(select fdOrgID from tbMember where fdRoleID=5 or fdRoleID=6)";
	elseif($showwho==5)
	$query="select * from tbOrg where id in(select fdOrgID from tbObject where fdClassID={$classid} and fdQuantity>0 and fdStatus=0 and fdPaid=0 and fdOrgID in(select fdOrgID from tbMember where fdRoleID=5 or fdRoleID=6));";
	elseif($showwho==6)
	$query="select * from tbOrg where id in(select fdOrgID from tbObject where fdPaid=1 fdClassID={$classid} and fdQuantity>0 and fdStatus=0 and fdOrgID in(select fdOrgID from tbMember where fdRoleID=5 or fdRoleID=6));";
		
	
	$result=mysql_query($query);
	if(mysql_affected_rows()>0)
	{
	while($row=mysql_fetch_assoc($result))
	{
		array_push($thedata,array($row["id"],$row["fdName"]));
		}
	}
	return $thedata;
	}
//式输出数组内容
function echoOrgsOptions($orgs)
{

		echo "<option disabled='disabled'>某单位</option> ";
	for($i=0;$i<count($orgs);$i++)
	{
	echo "<option value=".$orgs[$i][0].">".$orgs[$i][1]."</option> ";}

}
function echoOrgs($orgs)
{
	echo "<select id='orgshow' >";
		echo "<option disabled='disabled'>某单位</option> ";
	for($i=0;$i<count($orgs);$i++)
	{
	echo "<option value=".$orgs[$i][0].">".$orgs[$i][1]."</option> ";}
    echo "</select>";
}
function echoclasss($orgs)
{echo "<select id='classshow' >";
	echo "<option disabled='disabled'>某细类</option> ";
	for($i=0;$i<count($orgs);$i++)
	{
	echo "<option value=".$orgs[$i][0].">".$orgs[$i][1]."</option> ";}
	echo "</select>";
}



function showclasss()
{
	$thedata=array();
	$query="select * from tbClass";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
		array_push($thedata,array($row["id"],$row["fdName"]));
		}
	return $thedata;
	}
//每个组织含有的每类物品数目及其状态；
function orgHasClassCount($orgid,$classid)
{
	$query="select * from tbObject where fdOrgID={$orgid} and fdClassID={$classid}";
	$result=mysql_query($query);
	return mysql_num_rows($result);
	}
//every org has some classs;
function echoxmlOC($orgs,$classs)
{
	$string="<?xml version='1.0'?> <orgs></orgs>";
	$xml=simplexml_load_string($string);   
	for($i=0;$i<count($orgs);$i++){
        $org=$xml->addChild("org");
		$org->addAttribute("name",$orgs[$i][1]);
		for($j=0;$j<count($classs);$j++)
		{
			$org->addChild($classs[$j][1],orgHasClassCount($orgs[$i][0],$classs[$j][0]));			
			}		
		}
	echo  $xml->asXML();
}
//将2维数组转化为列表；

//所有的大类
function showsort()
{
	$thedata=array();
	$query="select * from tbSort";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
	array_push($thedata,array($row["id"],$row["fdName"]));
	}
	return $thedata;
	}
function showrole()
{
	$thedata=array();
	$query="select * from tbRole";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
	array_push($thedata,array($row["id"],$row["fdName"]));
	}
	return $thedata;
	}
function showroleid()
{
	$thedata=array();
	$query="select * from tbRole";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
	array_push($thedata,$row["id"]);
	}
	return $thedata;
	}

function showrolesoption($roles)
{
	foreach($roles as $role)
	echo "<option value=".$role[0].">".$role[1]."</option>";
	}
//数组A中包含数组B的元素
function AinB($array_1,$array_2)
{
	$data=array();
	foreach($array_1 as $data_1)
	foreach($array_2 as $data_2)
	{
		if($data_1==$data_2)
		array_push($data,$data_1);
		}
	return $data;
	
	}
//a是否在数组A中
function isainA($data,$array)
{
	foreach($array as $dataA)
	{
		if($data==$dataA)
		return 1;
		}
	return 0;
	}
//显示所有role，但是将org的role标记selected属性
function showorghasrolesoption($orgroleids,$roles)
{
	$roleids=array();
	foreach($roles as $role)
	{
		array_push($roleids,$role[0]);
		}
	$orgsin=AinB($orgroleids,$roleids);
	foreach($roles as $role)
	{
		if(isainA($role[0],$orgsin)==1)
		echo "<option selected='selected' value=".$role[0].">".$role[1]."</option>";
		else
		echo "<option value=".$role[0].">".$role[1]."</option>";
	}
	}

//某大类含有的小类
function sortHasClass($sortid)
{
	$thedata=array();
	$query="select * from tbClass where fdSortID={$sortid}";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($result))
	{
	array_push($thedata,array($row["id"],$row["fdName"]));
	}
	return $thedata;
	}

//每类含有的物品数目；
function classHasObject($classid)
{
	$query_0="select * from tbObject where fdClassID={$classid}";
	$result_0=mysql_query($query_0);
	$query_1="select * from tbObject where fdClassID={$classid} and fdStatus=1";
	$result_1=mysql_query($query_1);
	$result_2=$result_0-$result_1;
	return mysql_num_rows(array($result_0,$result_1,$result_2));
	}
//每个组织含有的每类物品数目及其状态；
			
function classOrgHasObject($classid,$orgid,$showwho)
{
	$result_0=0;//总数
	$result_1=0;//在途出
	$result_2=0;//在途入
	if($showwho==3||$showwho==5)
	$query_1="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid} and fdStatus=1 and fdPaid=1";
	elseif($showwho==6)
	$query_1="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid} and fdStatus=1 and fdPaid=0";
	else
	$query_1="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid} and fdStatus=1";

	$result=mysql_query($query_1);
	
	if(mysql_affected_rows())
	{
		while($rows=mysql_fetch_assoc($result))
		{
			$result_1+=$rows["fdQuantity"];
		}
	}
	if($showwho==3||$showwho==5)
	$query_0="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid} and fdPaid=0 and fdStatus=0";
	elseif($showwho==6)
	$query_0="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid} and fdStatus=1 and fdPaid=1";
	else
	$query_0="select fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$orgid} and fdStatus=0";
	
	$result=mysql_query($query_0);
	if(mysql_affected_rows())
	{
		while($rows=mysql_fetch_assoc($result))
		{
			$result_0+=$rows["fdQuantity"];

		}
	}
	
	$query_2="select id from tbBill where fdToOrgID={$orgid} and fdStatus=1";
	$result=mysql_query($query_2);
	if(mysql_affected_rows())
	{
		while($rows=mysql_fetch_assoc($result))
		{
			$billid=$rows["id"];
			$query="select fdQuantity from tbItem where fdClassID={$classid} and fdBillID={$billid}";
			$result_in=mysql_query($query);
			if(mysql_affected_rows())
			{
				while($row=mysql_fetch_assoc($result_in))
				$result_2+=$row["fdQuantity"];
			}
		}
	}	
	return array($result_0,$result_1,$result_2);
	}

//输出某org对应的各class及其含有的物品数目以及状态的xml;
function echoxmlOCO($orgid)
{
	
	$string="<?xml version='1.0'?> <sorts></sorts>";
	$xml=simplexml_load_string($string); 
	$sorts=showsort();
	for($i=0;$i<count($sorts);$i++)
	{
		
		$sort=$xml->addChild("sort");
		$sort->addAttribute("name",$sorts[$i][1]);
		$classs=sortHasClass($sorts[$i][0]);
		for($j=0;$j<count($classs);$j++)
		{
				$class=$sort->addChild($classs[$j][1]);
				$data=classOrgHasObject($classs[$j][0],$orgid,1);
				$class->addChild("count",$data[0]);
				$class->addChild("out",$data[1]);
				$class->addChild("in",$data[2]);			
			}
		}
		
	echo  $xml->asXML();

	}
function tableOutOCO($orgid)
{
	echo "<table><tr><td></td><td>".iconv("gb2312","utf-8","数量")."</td><td>".iconv("gb2312","utf-8","数量")."</td><td>".iconv("gb2312","utf-8","数量")."</td><td>".iconv("gb2312","utf-8","数量")."</td></tr>";
	
	echo "<table>";
	}
//对应于种货物，每个组织拥有的数量及其状态；
function echoxmlOOC($class)
{
	$string="<?xml version='1.0'?> <orgs></orgs>";
	$xml=simplexml_load_string($string); 
	$orgs=showOrgs();
	for($i=0;$i<count($orgs);$i++)
	{
		$org=$xml->addChild("org");
		$org->addAttribute("name",$orgs[$i][1]);
	    $data=classOrgHasObject($class[1],$orgid[$i][0],1);
		$org->addChild("count",$data[0]);
		$org->addChild("out",$data[1]);
		$org->addChild("in",$data[2]);		
		}
	echo $xml->asXML();

	}
function showSortSelect($sorts)
{
	echo "<select id='sortshow'>";
		echo "<option disabled='disabled'>某大类</option>";
	for($i=0;$i<count($sorts);$i++)
	{
		echo "<option value=".$sorts[$i][0].">".$sorts[$i][1]."</option>";
		}
	echo "</select>";
}
function showRoleSelect($sorts)
{
	echo "<select class='roleshow' >";
	echo "<option disabled='disabled'>某角色</option>";

	for($i=0;$i<count($sorts);$i++)
	{
		echo "<option value=".$sorts[$i][0].">".$sorts[$i][1]."</option>";
		}
	echo "</select>";
	}
	

?>