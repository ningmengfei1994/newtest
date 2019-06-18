<?php                
include_once '../../functions.php';
// 获取id参数
$cid=$_POST['id'];
// 连接数据库
$conn=connect();
// 创建sql语句
$delSql="delete from categories where id ='{$cid}'";
// 执行sql语句
$delRes=mysqli_query($conn,$delSql);


$response=['code'=>0,'msg'=>"删除失败"];
if($delRes){
    $response['code']=1;
    $response['msg']="删除成功";
}
// 返回json格式数据
header('content-type:application/json;charset=utf-8'); 
echo json_encode($response);
?>