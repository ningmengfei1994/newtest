<?php                
include_once '../../functions.php';
// 1.获取参数、
$name = $_POST['name'];
$slug = $_POST['slug'];
$classname=$_POST['classname'];
// 2.连接数据库
$conn=connect();
// 3.添加sql
$countSql="select count(*) as count from categories where name='{$name}'";
// 4.输出sql
$countRes=query($conn,$countSql);
$count=$countRes[0]['count'];

$response=['code'=>0,'msg'=>"添加失败"];

if($count>0){ //说明数据存在 应该不添加
    $response['msg']="该名称已存在,添加失败";
}else{  //数据不存在  添加
 $addSql ="insert into categories values(null,'{$slug}','{$name}','{$classname}')";
 $addRes=mysqli_query($conn,$addSql);
 if($addRes){
    $response['code']=1;
    $response['msg']="添加成功";
 }
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>