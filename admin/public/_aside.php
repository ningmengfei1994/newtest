<!-- 左边导航栏 -->
<div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
    <!-- 用三元表达式判断当前进入页面是否有$currentPage == "index"属性，有则点击显示高量active -->
      <li class="<?php echo $currentPage == "index" ? "active" :"" ?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
      <?php
      // 用数组把在文章下边的三个分页里设置的变量值存储着                
      $pageArr=["posts","post-add","categories"];
      // 判断设置的在三个分页中的变量值在数组$pageArr是否存在，存在说明点击的是这个页面，设置高亮
      $bool=in_array($currentPage,$pageArr);
      ?>
      <!-- 判断当前当前文章是否打开状态，离开则关闭 -->
        <a href="#menu-posts" class="<?php echo $bool?"":"collapsed" ?>" data-toggle="collapse" <?php echo $bool ?'aria-expanded="true"':"" ?>>
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo $bool?"in":"" ?>" <?php echo $bool ?'aria-expanded="true"':"" ?>>
          <!-- 判断当前点击页面里边是否存在posts变量，有则点击的是当前页面，显示高亮 -->
          <li class="<?php echo $currentPage == "posts" ? "active" :"" ?>"><a href="posts.php">所有文章</a></li>
          <!-- 判断当前点击页面里边是否存在post-add变量，有则点击的是当前页面，显示高亮 -->
          <li class="<?php echo $currentPage == "post-add" ? "active" :"" ?>"><a href="post-add.php">写文章</a></li>
          <!-- 判断当前点击页面里边是否存在categories变量，有则点击的是当前页面，显示高亮 -->
          <li class="<?php echo $currentPage == "categories" ? "active" :"" ?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <!-- 判断当前点击页面里边是否存在comments变量，有则点击的是当前页面，显示高亮 -->
      <li class="<?php echo $currentPage == "comments" ? "active" :"" ?>">
        <a href="comments.php "><i class="fa fa-comments"></i>评论</a>
      </li>
       <!-- 判断当前点击页面里边是否存在user变量，有则点击的是当前页面，显示高亮 -->
      <li class="<?php echo $currentPage == "users" ? "active" :"" ?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li >
      
      <?php                
       // 用数组把在设置下边的三个分页里设置的变量值存储着               
      $setArr=["nav-menus","slides","settings"];
       // 判断设置的在三个分页中的变量值在数组$setArr是否存在，存在说明点击的是这个页面，设置高亮
      $setBool=in_array($currentPage,$setArr);
      ?>
      <!-- 判断当前当前文章是否打开状态，离开则关闭 -->
        <a href="#menu-settings" class="<?php echo $setBool?"":"collapsed" ?>" data-toggle="collapse" <?php echo $setBool ?'aria-expanded="true"':"" ?>>
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $setBool?"in":"" ?>" <?php echo $setBool ?'aria-expanded="true"':"" ?>>
        <!-- 判断当前点击页面里边是否存在nav-menus变量，有则点击的是当前页面，显示高亮 -->
          <li class="<?php echo $currentPage == "nav-menus" ? "active" :"" ?>"><a href="nav-menus.php">导航菜单</a></li>
          <!-- 判断当前点击页面里边是否存在slides变量，有则点击的是当前页面，显示高亮 -->
          <li class="<?php echo $currentPage == "slides" ? "active" :"" ?>"><a href="slides.php">图片轮播</a></li>
          <!-- 判断当前点击页面里边是否存在settings变量，有则点击的是当前页面，显示高亮 -->
          <li class="<?php echo $currentPage == "settings" ? "active" :"" ?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script>
    $(function(){
      // 发送ajax请求获取头像
      $.ajax({
        type:"post",
        url:"api/_getUserAvatar.php",
        dataType:"json",
        success:function(response){
          if(response.code==1){
            // 1.动态设置头像昵称
            var profile=$(".profile");
            profile.children("img").attr("src",response.avatar);
            profile.children("h3").text(response.nickname);
          }
        }
      })
    })
  </script>