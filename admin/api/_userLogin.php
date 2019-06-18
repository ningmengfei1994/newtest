<?php
include_once "../../functions.php";              
//email:xxx,password:xxx

//1.获取数据
// 获取用户输入的email值
$email=$_POST["email"];
// 获取用户输入的密码值
$password=$_POST["password"];
// 2.创建连接
$conn=connect();
// 3.准备sql
// 判断数据库的资料，用户输入的账号密码和是否激活
$sql="SELECT * from users WHERE email='{$email}' and password ='{$password}' and status='activated'";
// 4.执行sql
$queryRes=query($conn,$sql);
// 5.返回数据
// 设置个数组，当code值为0 时候msg值为登录失败
$response=["code"=>0,"msg"=>"登录失败"];
// 成功执行说明账号密码在数据库中有存储
if($queryRes){
    // 设置的数组中code值为1，则msg值为登陆成功
    $response["code"]=1;
    $response["msg"]="登陆成功";
    // 用session记录登陆状态
    // 开启session
    session_start();
    // $_SESSION["isLogin"]存储登陆成功状态1
    // $_SESSION["user_id"]存储列表中的唯一值id
    $_SESSION["isLogin"]=1;
    $_SESSION["user_id"]=$queryRes[0]["id"];
}
// 返回数据为json格式
header('content-type:application/json;charset=utf-8'); 
echo json_encode($response);
?>