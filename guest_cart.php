<?php
/**
 * @Alok Dubey
 * @2018
 */
require_once 'config.php';
require_once 'soapconfig.php';

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


if(!isset($quote_id))
{
$quote_id = $proxy->shoppingCartCreate($sessionId,$storeId);
}




if($qty && $product_id)

{
try{
$result_3 = $proxy->shoppingCartProductAdd($sessionId, $quote_id, array(array(
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
   
echo  json_encode(array('sucess'=>"false",'message'=>$message,'quote_id'=>""),JSON_PRETTY_PRINT);  
   
   exit;
}

$result_cart = $proxy->shoppingCartInfo($sessionId, $quote_id);

}




if(isset($customer))
{
$result = $proxy->shoppingCartInfo($sessionId, $quote_id);
//var_dump($result);
$result=$result->items;

//print_r($result);exit;


foreach($result as $one_product)
{
//print_r($one_product->product_id);exit;
$product_id=$one_product->product_id;
$qty=$one_product->qty;

Mage::app();
Mage::app()->getTranslator()->init('frontend');

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
$result_cart = $proxy->shoppingCartInfo($sessionId, $quote_id);

}



echo  json_encode(array('sucess'=>"true",'quote_id'=>$result_cart->quote_id,'message'=>"Product successfully added to your cart",'data'=>$result_cart),JSON_PRETTY_PRINT);
//var_dump($result);
//print_r(json_encode($result));
?>