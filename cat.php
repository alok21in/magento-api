<?php
/**
 * @Alok Dubey
 * @2018
 */
require_once 'config.php';
require_once 'soapconfig.php';




Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));
$items=0;
$error='false';
  $product=Mage::getModel('catalog/product')->load(1);
    foreach ($product->getOptions() as $_option) {
        $values = $_option->getValues();
        print_r($_option);exit;
        foreach ($values as $v) {
            print_r($v->getTitle());
            echo "<br />";
        }
    }



//print_r($cust);


?>