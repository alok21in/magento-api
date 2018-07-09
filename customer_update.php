<?php

/**
* @author Alok Dubey
* @ 2018
*/
$firstname=$_REQUEST['firstname'];
$lastname=$_REQUEST['lastname'];
$customer=$_REQUEST['custid'];
$telephone=$_REQUEST['mobile'];
$lisence=$_REQUEST['lis'];
$email=$_REQUEST['email'];
require_once ('config.php');
require_once 'soapconfig.php';
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));

try
{

$result =$proxy->customerCustomerUpdate($sessionId, $customer, array('email' => $email, 'firstname' => $firstname, 'lastname' => $lastname,  'le_valid_license'=>$lisence , 'le_phone_number' => $telephone));  
$ret['sucess']=$result ;
}
catch (Exception $e) {
$message = $e->getMessage();

$ret=$message ;   
echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
}
echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);


?>