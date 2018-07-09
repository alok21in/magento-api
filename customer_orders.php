<?php

/**
 * @author Alok Dubey
 * @2018
 */

//ini_set('display_errors','On');
//error_reporting(E_ALL); 
$customer=$_REQUEST['customer_id'];
require_once 'soapconfig.php';
require_once ('config.php');
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));

$filter = array('filter' => array(array('key' => 'customer_id', 'value' =>$customer )));
try{
$result = $proxy->salesOrderList($sessionId, $filter);
$i=0;

//print_r($result);exit;

foreach ($result as $order):
$ret['$i']['orderid']=$order->increment_id;
$ret['$i']['orderdate']=$order->created_at;
$ret['$i']['ordertotal']=$order->grand_total;
//$ret[$i]['orderid']=$order->order_id;





endforeach;
}
catch (Exception $e) {
$message = $e->getMessage();
    //return  $ret['error']=$message ;   
    echo  json_encode(array('sucess'=>"false",'message'=>$message),JSON_PRETTY_PRINT);
   
}

$ret=array_values($ret);       
//$result=json_encode($result);
//echo $result;
echo  json_encode(array('sucess'=>"true",'data'=>$result),JSON_PRETTY_PRINT);




?>