<?php    
//批量删除接口            
include_once '../../functions.php';

$ids=$_POST['ids'];

$conn = connect();

$str = implode(',',$ids);
$sql="delete from categories where id in({$str})";  //in(1,2,3)
$delAllres=mysqli_query($conn,$sql);


$response=['code'=>0,'msg'=>"删除失败"];

if($delAllres){
  $response['code']=1;
  $response['msg']="删除成功";
}

header('content-type:application/json;charset=utf-8');
echo  json_encode($response);
?>