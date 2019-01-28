<?php
	include("config.php");
    $stmt = "select  ROW_NUMBER() OVER(ORDER BY ops_transportpackage.OrderNo ASC) AS Row,ops_transportpackage.OrderNo,CONVERT(varchar, ops_order.CreatedDate, 120) as OrderDate,
ops_order.AppointmentDate,IsActive,ops_order.OrderNo,Barcode,CONVERT(varchar, ops_order.DeletedDate, 120) as DeletedDate,
case when DeliveryStatus IS NULL then 0 else DeliveryStatus end as DeliveryStatus,CONVERT(varchar, DeliveryDate, 120) as DeliveryDate,
case when IsDriverVerify IS NULL then 0 else IsDriverVerify end as IsDriverVerify,CONVERT(varchar, DriverVerifyDate, 120) as DriverVerifyDate,
case when IsCheckerVerify IS NULL then 0 else IsCheckerVerify end as IsCheckerVerify,CONVERT(varchar, CheckerVerifyDate, 120) as CheckerVerifyDate,
case when IsBranchEmpVerify IS NULL then 0 else IsBranchEmpVerify end as IsBranchEmpVerify,CONVERT(varchar, BranchEmpVerifyDate, 120) as BranchEmpVerifyDate,
case when IsReturnCustomer IS NULL then 0 else IsReturnCustomer end as IsReturnCustomer,CONVERT(varchar, ReturnCustomerDate, 120) as ReturnCustomerDate 
from ops_transportpackage left join ops_order on ops_transportpackage.OrderNo=ops_order.OrderNo  
where ops_order.OrderNo='".$_GET['OrderNo']."'
Order By DeliveryStatus DESC";
    $query = sqlsrv_query($conn, $stmt);
	$object_array = array();
     while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC))
    {
 		array_push($object_array,$row);
    }
    $json_array=json_encode($object_array);
	echo $json_array;
?>
