<?php 
header('content-type:text/html;charset=utf-8'); 
include_once "config.php";               
 
  // 检查登录状态
  function checkLogin(){
    // 启动session
    session_start();
    // 判断登陆成功时候假如没有isLohin这个属性，或者isLohin不等于1的话，返回登录页面
    if(!isset($_SESSION["isLogin"])||$_SESSION["isLogin"]!=1){
        header("Location:login.php");
    }
  }
/**
  * 数据库读写操作
  */


  //1.创建数据库连接
  function connect(){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

    if(!$conn){
    die("数据库连接失败");
    }
    mysqli_query($conn,"set names utf8");
    return $conn;
  }
  //2.执行查询

  function query($conn,$sql){
    $res = mysqli_query($conn,$sql);
    return fetch($res);
  }
  //3.循环遍历 
  function fetch($res){
    $arr=[];
    while($row = mysqli_fetch_assoc($res)){
        $arr[]=$row;
    }
  return $arr;
  
  }
?>