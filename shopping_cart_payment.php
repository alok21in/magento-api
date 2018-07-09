<?php
   require_once 'config.php';
   require_once 'soapconfig.php';
   
   
   $customer=$_REQUEST['customer_id'];
   $po_number=$_REQUEST['po_number']; 
   $method=$_REQUEST['method'];
   $cc_cid=$_REQUEST['cc_cid'];
   $cc_owner=$_REQUEST['cc_owner'];
   $cc_type=$_REQUEST['cc_type'];
   $cc_exp_year=$_REQUEST['cc_exp_year'];
   $storeId=1;
   
Mage::app();
Mage::app()->getTranslator()->init('frontend');
$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
$quote_id=$quote->getId();
   
   //print_r($quote_id);exit;
   
 
 try
 {
   $result = $proxy->shoppingCartPaymentMethod($sessionId, $quote_id, array(
    'po_number' => $po_number,
    'method' => $method,
    'cc_cid' => $cc_cid,
    'cc_owner' => $cc_owner,
    'cc_number' =>$cc_number ,
    'cc_type' =>$cc_type ,
    'cc_exp_year' => $cc_exp_year,
   'cc_exp_month' => $cc_exp_month
), $storeId);  
   
   
   
   
   $ret=$result;
    
 }
 
 
 catch (Exception $e) {
$message = $e->getMessage();
 $ret=$message ;   
    echo  json_encode(array('sucess'=>"true",'message'=>$ret),JSON_PRETTY_PRINT);
  }
  
  echo  json_encode(array('sucess'=>"true",'message'=>$ret),JSON_PRETTY_PRINT);
  
  
  
  ?>