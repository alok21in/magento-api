<?php

/**
 * @Alok Dubey
 * @2018
 */

ini_set('display_errors','On');
//error_reporting(E_ALL);

if(isset($_REQUEST['customer_id']))
{
$customer=$_REQUEST['customer_id'];
}
if(isset($_REQUEST['options']))

{
$session=$_REQUEST['session'];
}
if(isset($_REQUEST['quote_id']))
{
$quote_id=$_REQUEST['quote_id'];
}
require_once 'config.php';

//echo"$quote_id";exit;
if(!$quote_id && !$customer)
{

$ret="parameter missing";
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
exit;
}


Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
$items=0;
$error='false';

if(isset($customer))
{
$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
}
else{

//print_r($quote);exit;
$quote = Mage::getModel('sales/quote')->load($quote_id);


}


if(isset($_POST['session']))
$session =$_POST['session'];

else
$session = Mage::getSingleton("core/session")->getEncryptedSessionId();

//$ret['checkout']['sid'] =$session;
 if ($quote) {
    
        $collection = $quote->getItemsCollection();
        if ($collection->count() > 0) {
            foreach( $collection as $item ) {
                $items++;
                $id=$item->getId();
                $ret[$id]['id']=$id;
                $ret[$id]['product_id']=$item->product_id;
                $ret[$id]['name']=$item->getName();
                $ret[$id]['qty']=$item->getQty();
                $amount +=$item->getQty();
                $ret[$id]['price']=$item->getPrice();
                
                

            }
        }
    }
 
    $totals=$quote->getTotals();
   
   
   
   
  // $ret_2['cart']['itemscount']=(int) $amount;
   //$ret_2['cart']['subtotal'] =$quote->getSubtotal();
   //$ret_2['cart']['total'] =$quote->getGrandTotal();
   //$ret_2['cart']['shipping'] =$quote->getShippingAddress()->getShippingAmount();
   
   if(isset($totals['discount']))
     //$ret['cart']['discount']= round($totals['discount']->getValue()); 
     $discount=round($totals['discount']->getValue());
 else {
     //$ret['cart']['discount']='';
     $discount='';
}
  
 
   if(isset($totals['tax'])){
     //$ret['cart']['tax']= round($totals['tax']->getValue()); 
     $tax=round($totals['tax']->getValue());
} else {
      //$ret['cart']['tax']= '';
      $tax='';
}


$ret=array_values($ret); 

echo  json_encode(array('sucess'=>"true",'itemscount'=>(int) $amount,'subtotal'=>$quote->getSubtotal(),'total'=>$quote->getGrandTotal(),
'shipping'=>$quote->getShippingAddress()->getShippingAmount(),'discount'=>$discount,'tax'=>$tax,'data'=>$ret),JSON_PRETTY_PRINT);

      
//$result=json_encode($ret);
//echo $result;





?>