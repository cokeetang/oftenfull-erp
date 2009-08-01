<?php
//在数组中删除某一特定值
//整体比较
function deleteDataInArray($data,$array)
{
	$returnarray=array();
	foreach($array as $data_1)
	{
	  if($data!=$data_1)
	  array_push($returnarray,$data_1);
	}
	return $returnarray;	
}
//键比较
function deleteDataInArrayByKey($key,$array)
{
	$returnarray=array();
	foreach($array as $data_1)
	{
	  if($key!=$data_1[0])
	  array_push($returnarray,$data_1);
	}
	return $returnarray;	
}
?>