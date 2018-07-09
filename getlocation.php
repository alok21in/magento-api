<?php

/**
 * @author alok dubey
 *  2018
 */
require_once 'config.php';
$s_id=$_REQUEST['s_id'];
$product_type=$_REQUEST['product_type'];

if(!$s_id && !$product_type)
{
 $message = array('sucess'=>'false','message'=>'Parameter missing');
   echo json_encode($message);
   exit;
}


Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));

$products = Mage::getModel('catalog/product')
->getCollection()
->distinct(true)
->addAttributeToSelect('product_vendor')
->addAttributeToFilter('find_a_medvacation',$s_id)
->addAttributeToFilter('product_type',$product_type)
->load();

//print_r($products->getSelect()->__toString());exit;

foreach($products as $product){
	
    
    $id=$product->getId();
    //$ret[$id]['id']=$id;
    $ret[]=$product->getProductVendor();
   

    
    
    } 
    //print_r($ret);exit;
    $ret=array_unique($ret);
    $ret=array_values($ret);
    
      if (empty($ret))
    {
    $ret="";
     echo  json_encode(array('sucess'=>"false",'data'=>$ret),JSON_PRETTY_PRINT);
    }
    else
    {
    echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);
    }
   // print_r($ret);exit;
        
 
 //$result=json_encode($ret,JSON_PRETTY_PRINT) ;  
 
 //echo $result;
 ?>