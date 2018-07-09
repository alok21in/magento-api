<?php
/**
 * @author alok dubey
 *  @2018
 */
require_once 'config.php';

$s_id=$_REQUEST['s_id'];
if(!$s_id)
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
->addAttributeToSelect('product_type')
->addAttributeToFilter('find_a_medvacation',$s_id)
->load();

//print_r($products->getSelect()->__toString());exit;

foreach($products as $product){
	
    
    $id=$product->getId();
    //$ret[$id]['id']=$id;
    $ret[]=$product->getProductType();
   

    
    
    } 
    
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
        
 //$ret=array_values($ret);
 //$result=json_encode($ret,JSON_PRETTY_PRINT) ;  
 
 //echo $result;
 ?>