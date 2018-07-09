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

if(!$_POST['name'] || !$_POST['email'] ||  !$_POST['dental_facility'] || !$_POST['treatments'])
{

    $message = array('sucess'=>'false','message'=>'Parameter missing');
   echo json_encode($message);
   exit;
}

$error="false";
$name= $_POST['name'];
$email = $_POST['email'];
$dental_facility= $_POST['dental_facility'];
$location= $_POST['location'];
$treatments= $_POST['treatments'];
$experience= $_POST['experience'];
$languages= $_POST['languages'];
$message= $_POST['message'];

$websiteId = Mage::app()->getWebsite()->getId();
$store = Mage::app()->getStore();

$dentist= Mage::getModel("dentist/dentist");
            $dentist->setWebsiteId($websiteId)
             ->setStore($store)
            ->setName($name)
            ->setDental_facility($dental_facility)
            ->setEmail($email)
            ->setLocation($location)
            ->setTreatments($treatments)
            ->setExperience($experience)
            ->setLanguages($languages)
            ->setMessage($message);
            
 
try{
    $dentist->save();
}
catch (Exception $e) {
    //Zend_Debug::dump($e->getMessage());
    $message = $e->getMessage();
    $ret['sucess']="false";
    $ret['message'] = $message ;
    
    $error='true';
}

if($error=='false')
{       $id=$dentist->getId();
        $ret['sucess']="true";
        $ret['message'] ="account created successfully" ;
        $ret['id']=$id;
        
        
    }   
    $result=json_encode($ret) ;
     echo $result;
?>