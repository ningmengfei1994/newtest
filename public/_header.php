<?php                
// 1.创建连接
$conn=connect();
// print_r(connect);
// 2.准备sql
// 查询除了未分类那一项外的所有标题
$sql="select * from categories where id !=1";
// 3.执行查询
$headerArr=query($conn,$sql);
?>
<div class="header">
      <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
        <?php                
        foreach($headerArr as $key => $value){ ?>
          <li><a href="list.php?cid=<?php echo $value["id"] ?>"><i class="fa <?php echo $value["classname"] ?>"></i><?php echo $value["name"]?></a></li>
        <?php } ?>
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="submit" class="btn" value="搜索">
        </form>
      </div>
      <div class="slink">
        <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
      </div>
    </div>