<?php
function checkifshenhe($billid){
	$query="select fdStatus,fdAuditOrgID from tbBill where id={$billid}";
	$result=mysql_query($query);
	if(mysql_affected_rows())
	{
		$auditid=mysql_result($result,0,"fdAuditOrgID");
		$status=mysql_result($result,0,"fdStatus");
		return array($status,$auditid);
		}
			else
	return array(0);
	}

?>