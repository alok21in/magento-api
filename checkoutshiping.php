<?php

/**
 * @author kem parson
 * @copyright 2016
 */
//ini_set('display_errors','On');
//error_reporting(E_ALL); 
$customer=$_REQUEST['customer'];
require_once 'config.php';
require_once 'soapconfig.php';

Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
//$product = Mage::getModel('catalog/product')->load($productId);

$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
$qid=$quote->getId();

function getshiping($qid)
{

try{
$result = $proxy->shoppingCartShippingList($sessionId, $qid);
//var_dump($result);
$i=0;
foreach ($result as $method):

$ret[$i]['code']=$method->code;
$ret[$i]['method']=$method->method ;
$ret[$i]['price']=$method->price ;
$i++;
endforeach;
return array_values($ret);
}

catch (Exception $e) {
$message = $e->getMessage();
    return  $reter['error']=$message ;   
    return $reter;
}
 
}   


function setshiping($qid)
{
    
   $code=$_REQUEST['code']; 

 
 try
 {
   $result = $proxy->shoppingCartShippingMethod($sessionId, $qid, $code); 
   $ret['sucess']="true";
    return $ret;
 }
 
 
 catch (Exception $e) {
$message = $e->getMessage();
    return  $reter['error']=$message ;   
    return $reter;
}   
}

if ($_REQUEST['action']=="setshiping")
 echo json_encode(setshiping($qid));
 else
 
echo json_encode (getshiping($qid));

?>