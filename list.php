<!-- 文章列表页 -->


<!-- 复制引入封装页面 -->
<?php include_once 'functions.php';
// 获取分类id
$cid=$_GET['cid'];
// 1.创建连接
$conn=connect();
// 2。准备sql
// 文章id，文章标题，文章发布日期，文章内容，阅读量，点赞量，图片，分类名称，作者名字
$sql="SELECT p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
-- 每篇文章的评论条数
(SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
-- 给posts设置别名为p
FROM posts p
-- categories的id参照post的category_id
LEFT JOIN categories c on c.id = p.category_id
-- user里的id参照post的user_id
LEFT JOIN users u on u.id = p.user_id
-- 按照分类id跳转页面
WHERE p.category_id = {$cid}
-- 获取条数
   
LIMIT 10";
// 3.获取数据
$listArr=query($conn,$sql);
// print_r($listArr);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>

    <?php include_once 'public/_header.php'?>
    <?php include_once 'public/_aside.php'?>

    <div class="content">
      <div class="panel new">
        <!-- 渲染到页面中 -->
        <h3><?php echo $listArr[0]["name"] ?></h3>
        <?php foreach ($listArr as $key =>$value){ ?>
          <div class="entry">
          <div class="head">
            <a href="detail.php?pid=<?php echo $value['id']?>"><?php echo $value['title'] ?></a>
          </div>
          <div class="main">
          <p class="info"><?php echo $value['nickname'] ?> 发表于 <?php echo $value['created'] ?></p>
            <p class="brief"><?php echo $value['content'] ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value['views'] ?>)</span>
              <span class="comment">评论(<?php echo $value['commentsCount'] ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value['likes'] ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value['name'] ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div> 
        <?php }   ?>
                
        <div class="loadmore">
          <span class="btn">加载更多</span>

        </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="static/assets/vendors/nprogress/nprogress.js"></script>
  <script src="static/assets/vendors/art-template/template-web.js"></script>
  <script src="static/assets/vendors/jquery/jquery.js"></script>
<script type="text/template" id="entry">
{{each data as value index}}
<div class="entry">
  <div class="head">
      <a href="detail.php?pid={{value.id}}">{{value.title}}</a>
  </div>
  <div class="main">
    <p class="info">{{value.nickname}}发表中{{value.created}}</p>
    <p class="brief">{{value.content}}</p>
    <p class="extra">
      <span class="reading">阅读({{value.views}})</span>
      <span class="comment">评论({{value.commentsCount}})</span>
      <a href="javascript:;" class="like">
        <i class="fa fa-thumbs"></i>
        <span>赞({{value.likes}})</span>
      </a>
      <a href="javascript:;" class="tags">
        分类:<span>{{value.name}}</span>
      </a>
    </p>
    <a href="javascript:;" class="thumb">
      <img src="static/uploads/hots_2.jpg" alt="">
    </a>
  </div>
</div>
{{/each}}
</script>
  <script>
  $(function(){
    // 1.给加载更多添加点击事件
    // 初始页数为第1页
    var currentPage=1;
    // 设置加载更多点击事件
    $(".loadmore .btn").on("click",function(){
      // 获取分类数据的id，利用=号把数字截取出来
      var cid=location.search.split("=")[1];
      // 每次点击加1
      currentPage++;
      // 请求ajax
      $.ajax({
        type:"post",
        url:"api/_getMorePost.php",
        data:{
        // 传入分类id
        cid:cid,
        // 传入当前第几页，当前设置为1，
        currentPage:currentPage,
        // 传入展示条数
        pageSize:10,
      },
        dataType:"json",
        
        success:function(response){
          console.log(response);
          //判断数据是否请求成功
          if(response.code==1){
             var html = template("entry",response);
            //  将获取的内容添加到加载更多前面
             $(".loadmore").before(html);
          if(currentPage==response.total){
            // 隐藏加载更多按钮
             $(".loadmore").hide();
}
}   
          
        }

      });
    })
  });
</script>
</body>
</html>