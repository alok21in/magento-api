<?php

/**
* @author Alok Dubey
* @ 2018
*/
$quote_id=$_REQUEST['quote_id'];
$customer=$_REQUEST['customer_id'];
$firstname=$_REQUEST['firstname'];
$lastname=$_REQUEST['lastname'];
$street=$_REQUEST['street'];
$city=$_REQUEST['city'];
$region=$_REQUEST['region'];
$postcode=$_REQUEST['postcode'];
$country_id=$_REQUEST['country_id'];
$telephone=$_REQUEST['telephone'];
$is_default_billing=$_REQUEST['is_default_billing'];
$storeId=1;
require_once 'soapconfig.php';
require_once 'config.php';

if($customer)
{

$cust = Mage::getModel('customer/customer')->load($customer);
$quote = Mage::getModel('sales/quote')->loadByCustomer($cust);
$quote_id=$quote->getId();

}



$result = $proxy->shoppingCartCustomerAddresses($sessionId, $quote_id, array(array(
'mode' => 'billing',
'firstname' => 'first name',
'lastname' => 'last name',
'street' => 'street address',
'city' => 'city',
'region' => 'region',
'postcode' => 'postcode',
'country_id' => 'US',
'telephone' => '123456789',
'is_default_billing' => 1
)), $storeId);   



?>