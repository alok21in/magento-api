<?php

/**
 * @author Alok Dubey
 * @ 2018
 */

$id=$_REQUEST['id']; 
require_once ('config.php');
require_once 'soapconfig.php';
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
 
try
{
$result = $proxy->customerAddressDelete($sessionId, $id);  
 $ret='true' ; 
}

catch (Exception $e) {
$message = $e->getMessage();
$errors='true';
      $ret=$message ;   
   echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);
   exit;
}
echo  json_encode(array('sucess'=>"true",'message'=>$ret),JSON_PRETTY_PRINT);
//echo json_encode($ret);
?>