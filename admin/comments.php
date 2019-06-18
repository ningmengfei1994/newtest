<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <!-- 引入 -->
  <?php include_once 'public/_navbar.php'?> 

    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
     
        </tbody>
      </table>
    </div>
  </div>
<!-- 设置个变量存储本网页名 -->
<?php $currentPage="comments" ?>
<!-- 引入 -->
<?php $currentPage="comments" ?>
  <?php include_once 'public/_aside.php'?> 
  <script>NProgress.done()</script>
  <!-- 引入requirejs文件 -->
  <script src="../static/assets/vendors/require/require.js" data-main="../static/assets/js/comments.js"></script>
  <script type='text/template' id='commentTemp'>
  {{each data as v index}}
      <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{v.author}}</td>
            <td>{{v.content}}</td>
            <td>{{v.title}}</td>
            <td>{{v.created}}</td>
            <td>{{ if v.status=="held"}}
                未审核
                {{else if v.status =="approved"}}
                准许
                {{else if v.status =="rejected"}}
                拒绝
                {{else if v.status =="trashed"}}
                回收站
                {{/if}}
            </td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
  {{/each}}
  </script>

</body>
</html>
