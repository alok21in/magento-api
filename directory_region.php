<?php

require_once 'soapconfig.php';

$c_code=$_REQUEST['c_code'];


if(!$c_code)
{
$ret="Country code not found";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT); 
exit;

}

try{
$results = $proxy->directoryRegionList($sessionId,$c_code);
//print_r($results);exit;
if(empty($results))
{
$ret="No data found in database";
 echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT); 
 exit;
}
foreach ($results as $result):
$ret['region'][$result->region_id]=$result->name;
endforeach;


$ret=array_values($ret);
//echo json_encode($ret);

}
catch (Exception $e) {
$message = $e->getMessage();
 $ret=$message ; 
 echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);  
   exit;
}
echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);

?>