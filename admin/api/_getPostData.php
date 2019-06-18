<?php                
include_once '../../functions.php';

// 获取参数
$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
$status=$_POST['status'];
$categoryId=$_POST['categoryId'];

// 计算偏移量（n-1）*数量
$offset =($currentPage -1 ) * $pageSize;

$conn = connect();

$where =" where 1=1 ";

if($status!="all"){
    $where.=" and p.`status`= '{$status}'";
}

if($categoryId !="all"){
    $where.=" and p.category_id= '{$categoryId}'";
}

$sql="SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` FROM posts p
left JOIN users u ON u.id = p.user_id
LEFT JOIN categories c ON c.id = p.category_id" . $where ."limit {$offset},{$pageSize}";

// echo $sql;
$res = query($conn,$sql);

$countSql="select count(*) as count from posts p" .$where;

$countArr = query($conn,$countSql);
$count=$countArr[0]['count'];


$pageCount = ceil($count/$pageSize);

$response=['code'=>0,'msg'=>"操作失败"];
if($res){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['data']=$res;
    $response['pageCount']=$pageCount;
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
