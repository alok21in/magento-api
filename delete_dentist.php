<?php

$id = $_POST['id'];
require_once 'config.php';
Mage::app('default');
umask(0);
Mage::init();
$model = Mage::getModel('dentist/dentist');
try {

    $model->setId($id)->delete();
  
    $message = array('sucess'=>'true','message'=>'deleted successfully');
   echo json_encode($message);
   exit;

} catch (Exception $e){
    $ret= $e->getMessage(); 
    
     $message = array('sucess'=>'true','message'=>$ret);
   echo json_encode($message);
   exit;
}





?>