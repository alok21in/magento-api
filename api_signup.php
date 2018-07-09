<?php


/**
 * @author alok dubey
 *  @2018
 */
//ini_set('display_errors','On');
//error_reporting(E_ALL); 
require_once 'config.php';
Mage::app('default');
umask(0);
Mage::init();
//Mage::getSingleton('core/session', array('name' =>'frontend'));

if(!$_POST['firstname'] || !$_POST['lasttname'] ||  !$_POST['email'] || !$_POST['pass'])
{

    $message = array('sucess'=>'0','message'=>'Parameter missing');
   echo json_encode($message);
   exit;
}

$error="false";
$firstname = $_POST['firstname'];
$lasttname = $_POST['lasttname'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$lisence = $_POST['lis'];
//$mobile = $_POST['mobile'];

$websiteId = Mage::app()->getWebsite()->getId();
$store = Mage::app()->getStore();

$customer = Mage::getModel("customer/customer");
            $customer->setWebsiteId($websiteId)
             ->setStore($store)
            ->setFirstname($firstname)
            ->setLastname($lasttname)
            ->setEmail($email)
            ->setLe_valid_license($lisence)
           // ->setLe_phone_number($mobile)
            ->setPassword($pass);
            
 
try{
    $customer->save();
}
catch (Exception $e) {
    //Zend_Debug::dump($e->getMessage());
    $message = $e->getMessage();
    $ret['sucess']="false";
    $ret['message'] = $message ;
    
    $error='true';
}

if($error=='false')
{       $id=$customer->getId();
        $ret['sucess']="true";
        $ret['message'] ="account created successfully" ;
        $ret['id']=$id;
        
        
    }   
    $result=json_encode($ret) ;
     echo $result;
?>