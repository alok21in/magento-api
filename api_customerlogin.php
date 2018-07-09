<?php


/**
 * @author alok dubey
 *  2018
 */
//ini_set('display_errors','On');
//error_reporting(E_ALL);

require_once 'config.php';

$email= $_POST['email'];
$password= $_POST['pass'];


if(!$_POST['email'] || !$_POST['pass'])
{

    $message = array('sucess'=>'0','message'=>'Parameter missing');
   echo json_encode($message);
   exit;
}


$error="false";

Mage::app('default');
umask(0);
Mage::init();
Mage::getSingleton('core/session', array('name' =>'frontend'));
$customer = Mage::getModel("customer/customer");
$session = Mage::getSingleton('customer/session');
$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
$customer->loadByEmail($email);

        
    try {
                  $session->login($email, $password);
                  
                  
                    
                    
                } catch (Mage_Core_Exception $e) {
                    switch ($e->getCode()) {
                        case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
                        $ret['sucess']="false";
                            $ret['message'] = 'This account is not confirmed.';
                            $error="true";
                            break;
                        case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
                        $ret['sucess']="false";
                             $ret['message'] = 'Invalid login or password.';
                             $error="true";
                            break;
                        default:
                            $message = $e->getMessage();
                           $ret['sucess']="false";
                            $ret['message'] = $message ;
                    } 
                    }   
        

if($error=='false')
{       $id=$customer->getId();
        $ret['sucess']="true";
        $ret['id']=$id;
umask(0);
Mage::init();

$mage_id=$customer->getId();


if($mage_id==$id){
    $img="customerpic/$mage_id.jpg";
    if(file_exists($img)):
    $imagelocaton=Mage::getBaseUrl()."/mob_api/$img";
    else:
    $imagelocaton='no image found';
    endif;
$ret['info']['firstname'] = $customer->getFirstname();
$ret['info']['lastname'] = $customer->getLastname();
$ret['info']['email'] = $customer->getEmail();
$ret['info']['image'] = $imagelocaton;
$billing = $customer->getDefaultBillingAddress();

/*if (!empty($billing)) {
$ret['billing']['prefix'] =$billing->getFirstname() ;
$ret['billing']['firstname'] =$billing->getFirstname() ;
$ret['billing']['middlename'] = $billing->getMiddlename();
$ret['billing']['company'] = $billing->getCompany();
$ret['billing']['street'] = $billing->getStreet();
$ret['billing']['city'] = $billing->getCity();
;
$ret['billing']['country'] = $billing->getCountry();
$ret['billing']['postcode'] = $billing->getPostcode();
$ret['billing']['telephone'] = $billing->getTelephone(); 
$ret['billing']['fax'] =$billing->getFax() ;
}

if (!empty($shipping)) {
$shipping = $customer->getDefaultShipping();
$ret['shipping']['prefix'] =$shipping->getFirstname() ;
$ret['shipping']['firstname'] =$shipping->getFirstname() ;
$ret['shipping']['middlename'] = $shipping->getMiddlename();
$ret['shipping']['company'] = $shipping->getCompany();
$ret['shipping']['street'] = $shipping->getStreet();
$ret['shipping']['city'] = $shipping->getCity();
;
$ret['shipping']['country'] = $shipping->getCountry();
$ret['shipping']['postcode'] = $shipping->getPostcode();
$ret['shipping']['telephone'] = $shipping->getTelephone(); 
$ret['shipping']['fax'] =$shipping->getFax() ;

}*/
   
   
    
    
    
    
    
}

else{
    
$ret['error']="Id and Email do not match please to login customer";   
    
}
 



  }  
$result=json_encode($ret) ;
 echo $result;


?>