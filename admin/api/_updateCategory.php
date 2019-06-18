<?php                
include_once '../../functions.php';
// 获取参数
$cid=$_POST['cid'];
$name=$_POST['name'];
$slug=$_POST['slug'];
$classname=$_POST['classname'];

// 连接数据库，编写sql，返回数据
// 连接数据库
$conn=connect();
// 编写sql
$updateSql="update categories set name = '{$name}',slug='{$slug}',classname='{$classname}' where id = '{$cid}'";
// 执行sql
$updateRes=mysqli_query($conn,$updateSql);

$response=['code'=>0,'msg'=>"更新失败"];
if($updateRes){
    $response['code']=1;
    $response['msg']="更新成功";
}
// 返回json格式数据
header('content-type:application/json;charset=utf-8'); 
echo json_encode($response);
?>