<?php

/**
 * @author Alok Dubey
 * @2018
 */
$customer=$_REQUEST['customer_id'];


$firstname=$_REQUEST['firstname'];
$lastname=$_REQUEST['lastname'];
$street=$_REQUEST['street'];
$city=$_REQUEST['city'];
$region=$_REQUEST['region'];
$postcode=$_REQUEST['postcode'];
$country_id=$_REQUEST['country_id'];
$telephone=$_REQUEST['telephone'];
$shiping=$_REQUEST['shiping'];
$region_id=$_REQUEST['region_id'];
$defaulbilling=$_REQUEST['defaultbill'];
$defaulshiping=$_REQUEST['defaultship'];
$po_number=$_REQUEST['po_number']; 
$method=$_REQUEST['method'];
$cc_cid=$_REQUEST['cc_cid'];
$cc_owner=$_REQUEST['cc_owner'];
$cc_type=$_REQUEST['cc_type'];
$cc_exp_year=$_REQUEST['cc_exp_year'];

$storeId=1;
require_once 'soapconfig.php';
require_once ('config.php');
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
$qid=$quote->getId();
//print_r($qid);exit;




  $address = array(
        array(
            'mode' => 'shipping',
            'firstname' => $firstname,
            'lastname' => $lastname,
            'street' => $street,
            'city' => $city,
            'region' => $region,
            'telephone' => $telephone,
            'postcode' => $postcode,
            'country_id' => $country_id,
            'is_default_shipping' => $defaulbilling,
            'is_default_billing' => $defaulshiping
        ),
        array(
            'mode' => 'billing',
           'firstname' => $firstname,
            'lastname' => $lastname,
            'street' => $street,
            'city' => $city,
            'region' => $region,
            'telephone' => $telephone,
            'postcode' => $postcode,
            'country_id' => $country_id,
            'is_default_shipping' => $defaulbilling,
            'is_default_billing' => $defaulshiping
        ),
    );
     // add customer address
    $proxy->shoppingCartCustomerAddresses($sessionId, $qid, $address);
    // add shipping method
    $proxy->shoppingCartShippingMethod($sessionId, $qid, 'flatrate_flatrate');




   $paymentMethod =  array(
    'po_number' => $po_number,
    'method' => $method,
    'cc_cid' => $cc_cid,
    'cc_owner' => $cc_owner,
    'cc_number' =>$cc_number ,
    'cc_type' =>$cc_type ,
    'cc_exp_year' => $cc_exp_year,
   'cc_exp_month' => $cc_exp_month
);
     // add payment method
    $proxy->shoppingCartPaymentMethod($sessionId, $qid, $paymentMethod);





try{
 $orderId = $proxy->shoppingCartOrder($sessionId, $qid, $storeId, null);
   $ret['order']= $orderId;
   
    $result = $proxy->shoppingCartInfo($sessionId, $qid);
//var_dump($result);
$result=$result->items;

//print_r($result);exit;


foreach($result as $one_product)
{
$product_id=$one_product->product_id;
$qty=$one_product->qty;
$result = $proxy->shoppingCartProductRemove($sessionId, $qid, array(array(
'product_id' =>$product_id,
'qty' => $qty,
'options' => null,
'bundle_option' => null,
'bundle_option_qty' => null,
'links' => null
))); 








}
   
    }

catch (Exception $e) {
$message = $e->getMessage();
 $ret=$message ; 
 echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);  
   exit;
}
echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT); 
//echo json_encode($ret);
?>