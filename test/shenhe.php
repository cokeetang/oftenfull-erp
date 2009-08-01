<?php
$billid=$_GET["billid"];
$auditid=$_GET["auditid"];
require_once("sqlconnect.php");
require_once("billdata.php");
$query="select fdBillTypeID from tbBill where id={$billid}";
$result=mysql_query($query);
$billtype=mysql_result($result,0,"fdBillTypeID");
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
		 $classid=$row["fdClassID"];
		$objectname=getobjectname($classid);
		 $sn=$row["fdSN"];
		 $count=$row["fdQuantity"];
		 $cost=$row["fdPrice"];
		if($sn!='')
		{
			if($billtype!=1)
			{
			$query="select id from tbObject where fdSN='{$sn}' and fdOrgID={$from}";
			$result=mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error.="不存在该SN的".$objectname."\n";
			echo $error;
			//return 0;
			}
			else
			{
			$objectid=mysql_result($result,0,"id");
			$query="update tbObject set fdStatus=1 where id={$objectid}";
			mysql_query($query);
			}				
			}
			
			else if($billtype==1)
			{
			$query="select id from tbObject where fdSN='{$sn}'";
			mysql_query($query);
			if(mysql_affected_rows())
			{
			$error+="数据库存在相同SN的货物".$objectname."\n";
			 echo $error;
			 //return 0;
			}
			else
			{
			$query="insert into tbObject(fdClassID,fdSN,fdStatus,fdQuantity,fdCost,fdOrgID) values({$classid},'{$sn}',1,{$count},{$cost},{$from})";
			
			mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error+="数据插入错误";
            echo $error;
			//return 0;
         
			}
			}
			}
		}
		else
		{
			if($billtype!=1)
			{
			//现存的状态0的物件数目
			$the_0_count=0;
			$the_1_count=0;
			$query="select fdQuantity,fdCost from tbObject where fdClassID={$classid} and fdOrgID={$from} and fdStatus=0";
			$result=mysql_query($query);
			if(mysql_affected_rows())
			{
				$the_0_count=mysql_result($result,0,"fdQuantity");
			}
			else
			{
				//插入空的数量；
				$query="insert into tbObject(fdClassID,fdOrgID,fdStatus,fdQuantity,fdCost) values({$classid},{$from},0,0,0)";
				mysql_query($query);
			}
			//现存的状态1的物件数目
			$query="select fdQuantity,fdCost from tbObject where fdClassID={$classid} and fdOrgID={$from} and fdStatus=1";
			$result=mysql_query($query);
			if(mysql_affected_rows())
			{
				$the_1_count=mysql_result($result,0,"fdQuantity");
			}
			else
			{
				//插入空的数量
				$query="insert into tbObject(fdClassID,fdOrgID,fdStatus,fdQuantity,fdCost) values({$classid},{$from},1,0,0)";
				mysql_query($query);
			}
			if($count>$the_0_count+$the_1_count)
			{
			$error.=$objectname."数目不足\n";
			echo $error;	
			//return 0;
			}
			else
			{
				if($the_1_count>=$count)
				{
					//不做任何事情

				}
				else
				{
					$need_0_count=$count-$the_1_count;
					$the_0_left=$the_0_count-$need_0_count;
					$the_1_now=$count;
					$query="update tbObject set fdQuantity={$the_0_left} where fdClassID={$classid} and fdOrgID={$from} and fdStatus=0";
					mysql_query($query);
					$query="update tbObject set fdQuantity={$the_1_now} where fdClassID={$classid} and fdOrgID={$from} and fdStatus=1";
					mysql_query($query);
				}
			}
				
				
			}
			elseif($billtype==1)
			{
			$query="select fdQuantity,fdCost from tbObject where fdClassID={$classid} and fdOrgID={$from} and fdStatus=1";
			$result=mysql_query($query);
			if(mysql_affected_rows())
			{
				$thecount=mysql_result($result,0,"fdQuantity");
				$thecost=mysql_result($result,0,"fdCost");
				$nowcount=$count+$thecount;
				$nowcost=($thecost*$thecount+$cost*$count)/$nowcount;
			$query="update tbObject set fdQuantity={$nowcount},fdCost={$nowcost} where fdOrgID={$from} and fdStatus=1 and fdClassID={$classid}";
			mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error+="数据更新错误\n";
            echo $error;
			//return 0;
            
			}	
			}
			else
			{
				$query="insert into tbObject(fdClassID,fdStatus,fdQuantity,fdCost,fdOrgID) values({$classid},1,{$count},{$cost},{$from})";
			mysql_query($query);
			if(!mysql_affected_rows())
			{
			$error+="数据插入错\n误";
            echo $error;
			//return 0;
			}
			}
			}
		}
	}	

	if($error=="")
	{
$audit=date("Y-n-j H:i:s");
$query="update tbBill set fdStatus=1,fdAuditOrgID={$auditid},fdAudit='{$audit}' where id={$billid}";
mysql_query($query);	
echo "OK";
	}
	else
	echo $error;



?>