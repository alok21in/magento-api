<?php
/**
 * @Alok Dubey
 * @2018
 */
$quote_id=$_REQUEST['quote_id'];
$product_id=$_REQUEST['product_id'];
$qty=$_REQUEST['qty'];
$customer=$_REQUEST['customer_id'];

$storeId=1;

if(!$product_id || !$qty)
{
$ret="Product_id and Qty are required";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
exit;
}

require_once 'config.php';
require_once 'soapconfig.php';

//$result = $proxy->catalogProductTypeList($sessionId);

if(!$quote_id)
{
$quote_id = $proxy->shoppingCartCreate($sessionId,$storeId);
}
//print_r($quote_id);exit;

$result_2 = $proxy->shoppingCartInfo($sessionId, $quote_id,$storeId);
try{
$result_3 = $proxy->shoppingCartProductAdd($sessionId, $result_2->quote_id, array(array(
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
   
echo  json_encode(array('sucess'=>"true",'data'=>$message),JSON_PRETTY_PRINT);  
   
   exit;
} 
if($result_3=='true')
{
$result_4 = $proxy->shoppingCartProductList($sessionId, $quote_id, $storeId);


Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));

if($customer)
{
$cust = Mage::getModel('customer/customer')->load($customer);
//$done_d=Mage::getModel('sales/quote')->load($quote_id)->setCustomerId($customer)->save();
$cust['mode'] = 'customer';
$cust['customer_id']=$cust->entity_id; 
$proxy->shoppingCartCustomerSet($sessionId, $quote_id, $cust);


$check_move=$proxy->shoppingCartProductMoveToCustomerQuote($sessionId, $quote_id, array(array(
'product_id' => $product_id,
'qty' => $qty,
'options' => null,
'bundle_option' => null,
'bundle_option_qty' => null,
'links' => null
)), $storeId);
}
//var_dump($check_move);exit;



$result_5 = $proxy->shoppingCartInfo($sessionId, $quote_id, $storeId);

//$quote_id->setCustomer($cust);


/*
$result_6 = $proxy->shoppingCartCustomerAddresses($sessionId, $quote_id, array(array(
'mode' => 'billing',
'firstname' => 'first name',
'lastname' => 'last name',
'street' => 'street address',
'city' => 'Delhi',
'region' => 'Delhi',
'postcode' => '110085',
'country_id' => 'IND',
'telephone' => '123456789',
'is_default_billing' => 1
)));  
*/

echo  json_encode(array('sucess'=>"true",'message'=>"Product successfully added to your cart",'data'=>$result_5),JSON_PRETTY_PRINT);
//print_r(json_encode($result_5));
}

else{
$ret="Opps something went worng";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
exit;
}

?>