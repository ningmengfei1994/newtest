<?php                
include_once '../../functions.php';
$pageSize = $_POST['pageSize'];  //每页数量
$currentPage= $_POST['currentPage']; //当前页
$offset= ($currentPage -1 ) * $pageSize;//从哪开始计算第几页


// 连接数据库
$conn=connect();
// 创建sql
$sql="SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` FROM posts p
left JOIN users u ON u.id = p.user_id
LEFT JOIN categories c ON c.id = p.category_id limit {$offset},{$pageSize}";
//  执行sql
$res =query($conn,$sql);

$countsql = "select count(*) as count from posts";
$countArr = query($conn,$countsql);
$count= $countArr[0]['count'];
$pagecount=ceil($count/$pageSize);



$response=['code'=>0,'msg'=>"操作失败"];
if($res){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['data']=$res;
    $response['pagecount']=$pagecount;
}
header('content-type:application/json;charset=utf-8'); 
echo json_encode($response);

?>