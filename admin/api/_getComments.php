<?php                
include_once '../../functions.php';
// 获取从前端得到的当前页码，以及一页几条
$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
// 计算出从哪开始获取数据
$offset=($currentPage-1)*$pageSize;

// 连接数据库
$connect=connect();
// sql语句
$sql="SELECT c.id,c.author,c.content,c.created,c.`status`,p.title FROM comments c
LEFT JOIN posts p on p.id = c.post_id
LIMIT {$offset},{$pageSize}";
// 执行查询
$queryResult=query($connect,$sql);
// 计算出最大页码数
// 最大页码数=ceil（评论数据总数、每页获取的条数）
// 评论数据总数
$sqlCount="SELECT count(*) as count FROM comments";
$countArr=query($connect,$sqlCount);
// 取出数据总数
$count=$countArr[0]['count'];
// 计算最大页码数
$pageCount=ceil($count/$pageSize);
// 返回数据
$response=["code"=>0,"msg"=>"操作失败"];
if($queryResult){
    $response['code'] = 1;
    $response['msg'] = "操作成功";
    $response['data'] = $queryResult;
    $response['pageCount'] = $pageCount;
}
// 返回json格式
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>