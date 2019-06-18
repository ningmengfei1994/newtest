<?php                
include_once "functions.php";
$conn =connect(); //创建链接
$sql="select * from  表名";
$res=query($conn,$sql);

?>