<?php

/**
* @author Alok Dubey
* @2018
*/

$customer=$_REQUEST['customer']; 
require_once 'soapconfig.php';
require_once ('config.php');
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));

try
{
$result = $proxy->customerAddressList($sessionId, $customer);
$i=0;
foreach ($result as $address):
$ret[$i]['id']=$address->customer_address_id; 
$ret[$i]['firstname']= $address->firstname;
$ret[$i] ['lastname']=$address->lastname;
$ret[$i] ['company']=$address->company;
$ret [$i]['street']=$address->street;
$ret[$i]['city']=$address->city;
$ret[$i]['region_id ']=$address->region_id ;
$ret[$i]['region']=$address->region;
$ret[$i]['postcode']=$address->postcode;
$ret[$i]['country_id']=$address->country_id;
$ret[$i]['telephone']=$address->telephone;
$ret[$i]['fax']=$address->fax;
$ret[$i]['defaultbilling']=$address->is_default_billing ;
$ret[$i]['defaulshiping']=$address->is_default_shipping;


$i++;
endforeach;
$ret=array_values($ret);
}
catch (Exception $e) {
$message = $e->getMessage();
$errors="true" ;    
$ret['error']=$message ;
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
exit;
}
//echo json_encode($ret);
echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);

?>