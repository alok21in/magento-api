<?php
//print_r($_POST);exit;
if(!empty($_REQUEST['email']))

{
ini_set('display_errors','On');
error_reporting(E_ALL);
require_once ($_SERVER['DOCUMENT_ROOT'] .'/magento/app/Mage.php');
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));


$yourCustomerEmail=$postcode = $_REQUEST['email'];



$email_id=$_REQUEST['email'];

$customer = Mage::getModel('customer/customer')
        ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
        ->loadByEmail($yourCustomerEmail);
//echo $customer->getId();
        if ($customer->getId()) {

        try {
            $newResetPasswordLinkToken =  Mage::helper('customer')->generateResetPasswordLinkToken();
            $customer->changeResetPasswordLinkToken($newResetPasswordLinkToken);
            $customer->sendPasswordResetConfirmationEmail();
$result = array('message'=> 'If there is an account associated with '.$email_id.' you will receive an email with a link to reset your password.','sucess'=> "true");
             echo json_encode($result);
            } catch (Exception $exception) {
//echo "Exception";
                Mage::log($exception);
        }
    }
    else
    {
$result = array('message'=> 'failed','sucess'=> "false");
echo json_encode($result);
    }

}
else
{
$result = array('message'=> 'failed','sucess'=> "false");
echo json_encode($result);
}
        ?>