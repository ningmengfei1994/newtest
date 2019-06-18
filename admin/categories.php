<?php 
include_once '../functions.php';
checkLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none;">
        <strong>错误！</strong><span id="msg">发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="slug">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
            <input id="btn-add" type="button" class="btn btn-primary" value="添加"/>
            <input style="display:none;"  id="btn-edit" type="button" class="btn btn-primary" value="编辑完成"/>
            <input style="display:none;"  id="btn-cancle" type="button" class="btn btn-primary" value="取消编辑"/>
              
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">

            <!-- show when multiple checked -->

            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
           
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<script src="../static/assets/vendors/art-template/template-web.js"></script>
<script type='text/template' id='list'>
      {{each data value index}}
      <tr data-cid={{value.id}}>
         <td class="text-center"><input type="checkbox"></td>
         <td>{{value.name}}</td>
         <td>{{value.slug}}</td>
         <th>{{value.classname}}</th>
         <td class="text-center">
         <a href="javascript:;" data-cid={{value.id}} class="btn btn-info btn-xs edit">编辑</a>
         <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
         </td>
    </tr>
        {{/each}}
</script>
<!-- 设置个变量存储本网页名 -->
<?php $currentPage="categories" ?>
  <!-- 引入 -->
  <?php include_once 'public/_aside.php'?> 
  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
     $(function(){
//获取分类数据
      function getCategoryData(){
            $.ajax({
              type: "post",
              url: "api/_getCategoryData.php",
              dataType: "json",
              success: function (response) {
                if(response.code==1){
                  var html = template("list",response);
                  $("tbody").html(html);
                }
              }
            });
      }
      getCategoryData();

//新增分类
    $("#btn-add").on("click",function(){
      // 1.收集数据
      var name = $("#name").val();
      var slug = $("#slug").val();
      var classname=$("#classname").val();
      // 2.校验数据
      if(name==""){
        $("#msg").text("分类名称不能为空");
        $(".alert").show();
        return;
      }
      if(slug==""){
        $("#msg").text("分类别名不能为空");
        $(".alert").show();
        return;
      }
      if(classname==""){
        $("#msg").text("分类类名不能为空");
        $(".alert").show();
        return;
      }
      $.ajax({
        type: "post",
        url: "api/_addCategory.php",
        data: $("#data").serialize(),
        dataType: "json",
        success: function (response) {
          if(response.code ==1){ //添加成功
           //填入后清空数据
           $("#name").val("");
            $("#slug").val("");
            $("#classname").val("");
          getCategoryData();
         

        }else{
          $("#msg").text(response.msg);
          $(".alert").show();
         }
        }
      });
    });
// 定全局变量接收数据
var currentRow="";
// 编辑按钮点击事件 
    $("tbody").on("click",".edit",function(){
      // 用cid获取点击的id
      currentRow=$(this).parents('tr');
      var cid =$(this).attr("data-cid");
      // 把获取的id赋值给编辑完成按钮
      $("#btn-edit").attr("data-cid",cid);
      // 1.按钮的隐藏与显示
      $("#btn-add").hide();
      $("#btn-edit").show();
      $("#btn-cancle").show();
      // 2.获取点击数据
      var name = $(this).parents('tr').children().eq(1).text();
      var slug = $(this).parents('tr').children().eq(2).text();
      var classname = $(this).parents('tr').children().eq(3).text();
      // 3.展示数据
      $("#name").val(name);
      $("#slug").val(slug);
      $("#classname").val(classname);
    })


// 编辑完成按钮
    $("#btn-edit").on("click", function(){
       //1.获取id
       var cid = $(this).attr("data-cid");
       //2.校验数据
       var  name = $("#name").val();
        var  slug = $("#slug").val();
        var  classname = $("#classname").val();
        //2.校验数据
        if(name == "") {
          $("#msg").text("分类名称不能为空");
          $(".alert").show();
          return;
        }
        if(slug == "") {
          $("#msg").text("分类别名不能为空");
          $(".alert").show();
          return;
        }
        if(classname == "") {
          $("#msg").text("分类类名不能为空");
          $(".alert").show();
          return;
        }

       //3.发送请求
       $.ajax({
         type: "post",
         url: "api/_updateCategory.php",
         data:{cid:cid,name:name,slug:slug,classname:classname},
         dataType: "json",
         success: function (response) {
           if(response.code==1){
            //  1.隐藏按钮
            $("#btn-add").show();
             $("#btn-edit").hide();
             $("#btn-cancle").hide();
            
            //  2.保存原来数据
            var  name = $("#name").val();
             var  slug = $("#slug").val();
             var  classname = $("#classname").val();
            //  3.清空数据
            $("#name").val("");
            $("#slug").val("");
            $("#classname").val("");
            // 4.更新数据
            currentRow.children().eq(1).text(name);
              currentRow.children().eq(2).text(slug);
              currentRow.children().eq(3).text(classname);

           }
         }
       }); 
       
});



// 取消编辑
    $("#btn-cancle").on("click",function(){
        // 1.数据清空
        $("#name").val("");
        $("#slug").val("");
        $("#classname").val("");
        //  2.按钮消失
        $("#btn-add").show();
        $("#btn-edit").hide();
        $("#btn-cancle").hide();
    })

// 点击删除
     $("tbody").on("click",".del",function(){
      //  1.获取id
      var row=$(this).parents('tr');
      var cid=row.attr("data-cid");
      // 2.发送请求
      $.ajax({
        type: "post",
        url: "api/_deleteCategory.php",
        data: {id:cid},
        dataType: "json",
        success: function (response) {
          if(response.code==1){
            row.remove();
          }
        }
      });

     })

// 实现全选功能
     $("thead").on("click","input",function(){
      //  1.判断自己是否被选中
      var status = $(this).prop("checked");
      $("tbody input").prop("checked",status);
        if(status){
          $("#delAll").show();
        }else{
          $("#delAll").hide();
        }
     })

// 反选
  $("tbody").on("click","input",function(){
      //  表头的多选按钮
       var head=$("thead input");
      // 表单的所有多选按钮
      var body = $("tbody input");
      // 当表单内的input数量==选中多选按钮的数量时则表头多选按钮被选中
     if(body.size()==$("tbody input:checked").size()){
      //  选中状态为true则选中
      head.prop("checked",true);
     }else{
      //  选中状态为true则选中
      head.prop("checked",false);
     }
    //  当表单选中项大于等于2个的话显示批量删除项
    if($("tbody input:checked").size()>=2){
      // 大于等于2则显示
      $("#delAll").show();
    }else{
      // 否则继续隐藏
      $("#delAll").hide();
    }

  });

// 批量删除axadxac 
  $("#delAll").on("click",function(){
    // 1.获取所有选中
    var ids =[];
    // 表单所有项都选中状态
    var body=$("tbody input:checked");
    // 2.获取所有选中的id
    body.each(function (index,element){
      // element==this
      var id =$(element).parents("tr").attr("data-cid");
      ids.push(id);
    })
    // 3.发送请求，删除数据，更新界面
    $.ajax({
      type:"post",
      url:"api/_delAllCategory.php",
      data:{ids:ids},
      dataType:"json",
      success:function(response){
        
        if(response.code==1){
          body.parents("tr").remove();
        }
      }
    })
  })

})
    
  </script>
</body>
</html>
