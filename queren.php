<?php
$billid=$_GET["billid"];
$auditid=$_GET["auditid"];
require_once("sqlconnect.php");
require_once("billdata.php");
$query="select fdBillTypeID from tbBill where id={$billid}";
$result=mysql_query($query);
$billtype=mysql_result($result,0,"fdBillTypeID");
//$query="update tbBill set fdAuditOrgID={$auditid},fdStatus=2 where id={$billid}";
//mysql_query($query);
$query="select fdFromOrgID,fdToOrgID from tbBill where id={$billid}";
$result=mysql_query($query);
$from=mysql_result($result,0,"fdFromOrgID");
$to=mysql_result($result,0,"fdToOrgID");
//定义一个错误集合.
$error='';

	$query="select * from tbItem where fdBillID={$billid}";
	$result_1=mysql_query($query);
	while($row=mysql_fetch_assoc($result_1))
	{
		
		//fdBillID,fdObjectID,fdQuantity,fdPrice,fdClassID,fdSN
		$itemid=$row["id"];
		 $classid=$row["fdClassID"];
		$objectname=getobjectname($classid);
		 $sn=$row["fdSN"];
		 $count=$row["fdQuantity"];
		 $cost=$row["fdPrice"];
	if($sn)
	{
		if($billtype!=1)
		{
			$query="select id from tbObject where fdSN='{$sn}' and fdOrgID={$from} and fdStatus=1";
			$result=mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error.="SN为".$sn."的".$objectname."未在转移状态\n";
			echo $error;
			//return 0;
			}
			else
			{
			$objectid=mysql_result($result,0,"id");
			$query="update tbObject set fdStatus=0,fdOrgID={$to} where id={$objectid}";
			mysql_query($query);
			$query="update tbItem set fdObjectID={$objectid} where id={$itemid}";
			mysql_query($query);
			}
		}
		elseif($billtype==1)
		{
		
			$query="select id from tbObject where fdSN='{$sn}' and fdOrgID={$from} and fdStatus=1";		
			$result=mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error+="数据库不存在该SN的".$objectname."\n";
			 echo $error;
			 //return 0;
			}
			else
			{
				$objectid=mysql_result($result,0,"id");
				
				$query="update tbObject set fdStatus=0,fdOrgID={$to} where fdOrgID={$from} and fdSN='{$sn}' and fdStatus=1";
		
				mysql_query($query);
				if(!mysql_affected_rows())
			    {
			     $error+="数据库不存在该物件".$objectname."\n";
			      echo $error;
				 // return 0;
			     }
			$query="update tbItem set fdObjectID={$objectid} where id={$itemid}";
			mysql_query($query);
				 
				
			}
		}
	
	}
	else
	{
		if($billtype!=1)
		{
			$query="select fdCost from tbObject where fdClassID={$classid} and fdOrgID={$from} and fdStatus=0";
			$result=mysql_query($query);
			if(mysql_affected_rows())
			{
				$the_cost=mysql_result($result,0,"fdCost");
				
			}
			
			$query="select fdQuantity,fdCost from tbObject where fdClassID={$classid} and fdOrgID={$from} and fdStatus=1";
			$result=mysql_query($query);
			if(mysql_affected_rows())
			{
				$the_1_count=mysql_result($result,0,"fdQuantity");
				
			}
			if($count>$the_1_count)
			{
			$error.="没有足够的".$objectname."在途数目\n";
			//return 0;
			}
			else
			{
					

				    $theleft=$the_1_count-$count;
					$query="select id,fdQuantity from tbObject where fdClassID={$classid} and fdOrgID={$to} and fdStatus=0";
					$result=mysql_query($query);
					if(mysql_affected_rows())
					{
						$objectid=mysql_result($result,0,"id");
						$beforecount=mysql_result($result,0,"fdQuantity");
						$nowcount=$beforecount+$count;
						$query="update tbObject set fdQuantity={$nowcount} where id={$objectid}";
						mysql_query($query);
						$query="update tbObject set fdQuantity={$theleft} where fdClassID={$classid} and fdOrgID={$from} and fdStatus=1";
					mysql_query($query);
					$query="update tbItem set fdObjectID={$objectid} where id={$itemid}";
			        mysql_query($query);
					}
					else
					{
						$query="insert into tbObject(fdClassID,fdOrgID,fdStatus,fdQuantity,fdCost) values({$classid},{$to},0,{$count},'{$the_cost}')";
						mysql_query($query);
						$query="update tbObject set fdQuantity={$theleft} where fdClassID={$classid} and fdOrgID={$from} and fdStatus=1";
					mysql_query($query);
						
						}
					
					

				
			}
			
			
			
		}
		elseif($billtype==1)
		{
		
		$query="select fdQuantity from tbObject where fdClassID={$classid} and fdStatus=1 and fdOrgID={$from}";
		$result=mysql_query($query);
		if(mysql_affected_rows()==1)
		{
			$hascount=mysql_result($result,0,"fdQuantity");
			}
		if($hascount<$count)
		{
			$error+="数目不够\n";
			echo $error;
			//return 0;
			}
		else{
			$leftcount=$hascount-$count;
			$query="update tbObject set fdQuantity={$leftcount} where fdClassID={$classid} and fdStatus=1 and fdOrgID={$from}";
			mysql_query($query);
			$query="select id,fdCost,fdQuantity from tbObject where fdClassID={$classid} and fdStatus=0 and fdOrgID={$to}";
			$result=mysql_query($query);
			if(!mysql_affected_rows())
			{

				$query="insert into tbObject(fdClassID,fdStatus,fdQuantity,fdCOst,fdOrgID) values({$classid},0,{$count},{$cost},{$to})";
				mysql_query($query);
				}
			else
			{
				$objectid=mysql_result($result,0,"id");
				$beforecount=mysql_result($result,0,"fdQuantity");
				$nowcount=$beforecount+$count;
				$beforecost=mysql_result($result,0,"fdCost");
				$nowcost=($beforecost*$beforecount+$count*$cost)/$nowcount;
				$query="update tbObject set fdStatus=0,fdQuantity={$nowcount},fdCost={$nowcost} where id={$objectid}";
				mysql_query($query);
				$query="update tbItem set fdObjectID={$objectid} where id={$itemid}";
			    mysql_query($query);
				}
			
			}
		
		}
		
		
	}
	
	}




	if($error=="")
	{
		$confirm=date("Y-n-j H:i:s");
$query="update tbBill set fdStatus=2,fdConfirm='{$confirm}' where id={$billid}";
mysql_query($query);
echo "OK";
	}
	else
	echo $error;


?>