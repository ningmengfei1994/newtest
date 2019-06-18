<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong> <span id="msg">用户名或密码错误！</span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span id="btn-login" class="btn btn-primary btn-block">登 录</span>
    </form>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
  <script>
  $(function(){  
    // 给登录按钮添加点击事件
    $("#btn-login").on("click",function(){
      // 2.收集数据
      var email=$("#email").val();
      var password=$("#password").val();
      // 3.用正则校验数据
      var reg =/\w+[@]\w+[.]+/;
      // test校验的意思
      if(!reg.test(email)){
        // 4.验证失败给提示
        $("#msg").text("邮箱格式错误");
        // 错误时显示错误提示的div
        $(".alert").show();
        // 返回
        return;
      }else{
        // 正确的话隐藏错误提示
        $(".alert").hide();
      }
      // 5.发送ajax请求
    $.ajax({
        type: "post",
        url: "api/_userLogin.php",
        // 向后台传入用户输入的账号密码
        data: {email:email,password:password},
        // 设置响应的格式
        dataType: "json",
        // 请求后的回调
        success: function (response) {
          // 登陆成功
          if(response.code==1){
            // 登陆成功后服务器会缓存账号密码，直接跳转到index页面
            location.href="index.php";
          }else{
            // 登录失败时候通知msg的值：操作失败
            $("#msg").text(response.msg);
            // 并且显示错误提示模块
            $(".alert").show();
          }
        }
      });

    })
  })
  </script>
</body>
</html>
