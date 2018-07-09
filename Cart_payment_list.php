<?php
require_once 'config.php';
require_once 'soapconfig.php';
$customer=$_REQUEST['customer'];
$storeId=1;
$quote_id=$_REQUEST['quote_id'];

Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
//print_r($storeId);exit;

if($customer)
{

$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
$quote_id=$quote->getId();

}
 
try
{
$result = $proxy->shoppingCartPaymentList($sessionId, $quote_id, $storeId);  
 $ret='true' ; 
}

catch (Exception $e) {
$message = $e->getMessage();
$errors='true';
      $ret=$message ;   
   echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
   exit;
}
echo  json_encode(array('sucess'=>"true",'data'=>$result),JSON_PRETTY_PRINT);
//echo json_encode($ret);


?>