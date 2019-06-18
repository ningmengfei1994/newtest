<?php                
include_once "../functions.php";
// 实现加载更多api
// 1.获取参数post请求
//获取分类id
$cid = $_POST['cid'];
//当前第几次点击
$currentPage=$_POST['currentPage'];
//请求条数
$pageSize=$_POST['pageSize'];
//从那开始取=（第几次点击-1）*请求条数  offset=(n-1)*pagesize
$offset=($currentPage-1)*$pageSize;
// 2.创建连接
$conn=connect();
//3.准备sql
// 分类id，文章标题，文章发布日期，文章内容，阅读量，点赞量，图片，分类名称，作者名字
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
-- 从哪开始取，共取多少条
LIMIT {$offset},{$pageSize}";
//4.执行sql
$postArr= query($conn,$sql);



// 获取sql语句总共多少条数据
$countSql="select count(id) as total from posts where category_id={$cid}";
// 执行sql语句
$countArr=query($conn,$countSql);
$count=$countArr[0]['total'];
// 计算出总共能点击几次
$total=ceil($count/$pageSize);
//5.返回数据
/**
 *    {
 *     "code": 0 失败  1 成功
 *     "msg" :"操作信息
 *     "data":返回数据
 *     }
 */
$response = ["code"=>0,"msg"=>"操作失败"];
if($postArr){
  $response["code"]=1;
  $response["msg"]="操作成功";
  $response["data"]=$postArr;
  $response["total"]=$total;
}


header('content-type:application/json;charset=utf-8');
// 把$response转换为json格式的字符串
echo json_encode($response);


?>
