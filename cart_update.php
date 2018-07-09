<?php

/**
* @author Alok Dubey
* @ 2018
*/
if(isset($_REQUEST['quote_id']))
{
$quote_id=$_REQUEST['quote_id'];
}
$product_id=$_REQUEST['product_id'];
$qty=$_REQUEST['qty'];
if(isset($_REQUEST['customer_id']))
{

$customer=$_REQUEST['customer_id'];
}
$storeId=1;

if(!$product_id || !$qty)
{

$ret="parameter missing";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
exit;
}

if(!isset($quote_id) && !isset($customer))
{

$ret="quote_id or customer_id is mandatory";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
exit;
}


//print_r($product_id);exit;
require_once 'config.php';
require_once 'soapconfig.php';

Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
//print_r($storeId);exit;

if(isset($customer))
{

$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
$quote_id=$quote->getId();

}
//print_r($quote_id);exit;
try
{
$result = $proxy->shoppingCartProductUpdate($sessionId, $quote_id, array(array(
'product_id' => $product_id,
'qty' => $qty,
'options' => null,
'bundle_option' => null,
'bundle_option_qty' => null,
'links' => null
)), $storeId);   
}
catch (Exception $e) {
$message = $e->getMessage();
   
echo  json_encode(array('sucess'=>"false",'message'=>$message),JSON_PRETTY_PRINT);  
   
   exit;
}

//var_dump($result);

if($result=="true")
{

$ret="Cart updated successfully";
echo  json_encode(array('sucess'=>"true",'message'=>$ret),JSON_PRETTY_PRINT);

}
else
{
$ret="Opps something went worng";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
}





?>