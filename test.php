<?php
require_once("sqlconnect.php");
//
function sortvalue(){
	$count_sort_query="select fdName from tbSort";
$count_sort_result=mysql_query($count_class_query);
$sortarray=array();
while($row=mysql_fetch_assoc($count_sort_result))
$sortarray.push($row["fdName"]);
$length=count($sortarray);
return array($length,$sortarray);	
	}

function sortvalue(){
$count_sort_query="select id,fdName from tbSort";
$count_sort_result=mysql_query($count_sort_query);
$sortarray=array();
while($row=mysql_fetch_assoc($count_sort_result))
array_push($sortarray,array($row["id"],$row["fdName"]));
return $sortarray;	
	}
	//
function classValueFromSort()
{
$sort=sortvalue();
$classarray=array();
for($i=0;$i<count($sort);$i++)
{
	$id=$sort[$i][0];
	$class_query="select fdName from tbClass where fdSortID=$id";
	$class_query_result=mysql_query($class_query);
	
	while($row=mysql_fetch_assoc($class_query_result))
	{
		array_push($classarray,array($sort[$i],array($row["id"],$row["fdName"])));
		}
	}
	return $classarray;

	}
//我们拥有的角色；
function theRoles()
{ $query="select * from tbRole";
  $result=mysql_query($query);
  $thedata=array();
  while($row=mysql_fetch_assoc($thedata))
  {
	  array_push($thedata,array($row["id"],$row["fdName"]));
	  }
return $thedata;
	}
//我们拥有的组织；
function theOrgs($roles)
{
	$thedata=array();
	for($i=0;$i<count($roles);$i++)
	{
	$query="select * from tbOrg where fdRoleID=$roles[$i]['id']";
	$result=mysql_query($query);
	while($row=mysql_fetch_assoc($thedata))
	{
		//array_push($thedata,array($roles[$i],array($row["fdname"],$row["id"])));
		array_push($thedata,$row["id"])
		}
	}
	return $thedata;
	}
//单独含有的数目
function orgHasObjectNum($org)
{
	$query="select id from tbObject where fdOrgID=$org";
	return mysql_num_rows(mysql_query($query));	
	}
//每个组织含有的物件数目；
function orgsHasObjectNum($orgs)
{
	$thedata=array();
	for($i=0;$i<count($orgs);$i++)
	{
		array_push($thedata,array($orgs[$i],orgHasObjectNum($orgs[$i])));
		}}
?>