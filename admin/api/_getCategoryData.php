<?php                
// 获取分类数据
include_once '../../functions.php';

$conn=connect();
$sql="select * from categories";
$res = query($conn,$sql);

$response=['code'=>0,'msg'=>"操作失败"];
if($res){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['data']=$res;
}
// 返回json字符串
header('content-type:application/json;charset=utf-8'); 
echo json_encode($response);
?>