<?php                
include_once "../../functions.php";
// 1.根据用户的id查询
session_start();
// $userid拿到用户输入的唯一id
$userid=$_SESSION["user_id"];
// 2.创建连接
$conn=connect();
// 3.准备sql
$sql="select*from users where id = {$userid}";
// 4.执行sql
$queryRes=query($conn,$sql);
// 5.返回数据
$response = ["code"=>0,"msg"=>"操作失败"];
if($queryRes){
    $response["code"]=1;
    $response["msg"]="操作成功";
    // 拿到用户的名字
    $response["nickname"]=$queryRes[0]['nickname'];
    // 拿到用户的头像
    $response["avatar"]=$queryRes[0]['avatar']; 
}
// 返回json类型的字符串
header('content-type:application/json;charset=utf-8');
echo json_encode($response);

?>