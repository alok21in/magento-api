<?php

/**
* @author alok dubey
* @ 2018
*/

$find_a_medvacation=$_REQUEST['find_a_medvacation'];
$location=$_REQUEST['location'];
$product_type=$_REQUEST['product_type'];
if(!$find_a_medvacation && !$location && !$product_type)
{
$ret="Parameter missing need atleast one";
 echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);

 exit;
}

require_once 'config.php';
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));



if($find_a_medvacation && $location && $product_type)
{
$product_collection = Mage::getResourceModel('catalog/product_collection')
->addAttributeToSelect('*')
->addAttributeToFilter('find_a_medvacation',array('like' => $find_a_medvacation))
->addAttributeToFilter('product_vendor',array('like' => $location))
->addAttributeToFilter('product_type',array('like' => $product_type))->load();
}

elseif($find_a_medvacation && $location)
{
$product_collection = Mage::getResourceModel('catalog/product_collection')
->addAttributeToSelect('*')
->addAttributeToFilter('find_a_medvacation',array('like' => $find_a_medvacation))
->addAttributeToFilter('product_vendor',array('like' => $location))->load();

}
elseif($find_a_medvacation && $product_type)
{
$product_collection = Mage::getResourceModel('catalog/product_collection')
->addAttributeToSelect('*')
->addAttributeToFilter('find_a_medvacation',array('like' => $find_a_medvacation))
->addAttributeToFilter('product_type',array('like' => $product_type))->load();

}
elseif($location && $product_type)
{
$product_collection = Mage::getResourceModel('catalog/product_collection')
->addAttributeToSelect('*')
->addAttributeToFilter('product_vendor',array('like' => $location))
->addAttributeToFilter('product_type',array('like' => $product_type))->load();

}
else{

$product_collection=Mage::getResourceModel('catalog/product_collection')
->addAttributeToSelect('*')
->addAttributeToFilter(
array(
    array('attribute'=> 'find_a_medvacation','like' => $find_a_medvacation),
    array('attribute'=> 'product_vendor','like' => $location),
    array('attribute'=> 'product_type','like' => $product_type)
)
)->load();
}






foreach($product_collection as $product) {
$id=$product->getId();
$ret[$id]['id']=$id;
$ret [$id]['name']=strip_tags($product->getName());
$ret[$id] ['price']= number_format($product->getFinalPrice(),2) ;  
$ret[$id]['regular_price']=number_format($product->getPrice(),2);
$ret[$id] ['shortdescription']=strip_tags($product->getShortDescription());
$ret[$id] ['description']=strip_tags($product->getDescription());
$productimage=Mage::helper('catalog/image')->init($product, 'image');
$ret[$id] ['image']=(string)$productimage;



  $product_2=Mage::getModel('catalog/product')->load($id);
  
  
  if($product_2->getOptions())
  {
  
  $i=0;
    foreach ($product_2->getOptions() as $_option) {
    $i++;
        $values = $_option->getValues();
      //  print_r($_option->default_title);exit;
        
       //$ret[$id]['custom']['title'.$i]= $_option->default_title;
        
        foreach ($values as $v) {
           // print_r($v->getId());
            
            $ret[$id]['custom'][$_option->default_title][$v->getId()]=$v->getTitle();
            
            //echo "<br />";
        }
    }
    }







}

$ret=array_values($ret); 

if (empty($ret))
{
$ret="No data found in database";
 echo  json_encode(array('sucess'=>"false",'message'=>$ret),JSON_PRETTY_PRINT);

 exit;
}

echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);  

?>