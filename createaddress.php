<?php

/**
 * @author Alok Dubey
 * @ 2018
 */

$id=$_REQUEST['customer'];
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
require_once 'soapconfig.php';
require_once ('config.php');
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
/*$proxy = new SoapClient(Mage::getBaseUrl().'/api/v2_soap/?wsdl'); 
$sessionId = $proxy->login(APIUSER, APIKEY);*/
try
{
$result =$proxy->customerAddressCreate($sessionId, $id, array('firstname' => $firstname, 'lastname' => $lastname, 
'street' => array($street, ''), 'city' => $city, 'country_id' => $country_id, 'region' =>$region , 'region_id' => $region_id, 'postcode' =>$postcode , 'telephone' => $telephone, 'is_default_billing' => $defaulbilling, 'is_default_shipping' =>$defaulshiping ));
 $ret['id']=$result ; 
}

catch (Exception $e) {
$message = $e->getMessage();
$errors='true';
   $ret=$message ;   
   echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
   exit;
}

echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);
//echo json_encode($ret);

?>