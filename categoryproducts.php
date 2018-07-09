<?php
/**
 * @author alok dubey
 *  @2018
 */

require_once 'config.php';
Mage::app();
Mage::app()->getTranslator()->init('frontend');
Mage::getSingleton('core/session', array('name' => 'frontend'));

$cat_id=$_REQUEST['id'];
$category = Mage::getModel('catalog/category')->load($cat_id);

$products = Mage::getModel('catalog/product')
->getCollection()
->addAttributeToSelect('*')
->addCategoryFilter($category)
->load();



foreach($products as $product){
	$img= Mage::helper('catalog/image')->init($product, 'small_image');
    
//print_r($product->getOptions());

    $id=$product->getId();
       
    $ret[$id]['id']=$id;
    $ret[$id]['name']=strip_tags($product->getName());
    $ret[$id] ['price']= number_format($product->getFinalPrice(),2) ;  
    $ret[$id]['regular_price']=number_format($product->getPrice(),2);
    $ret[$id] ['shortdescription']=strip_tags($product->getShortDescription());
    if($product->getRatingSummary()):
    $ret[$id] ['reviews']=$product->getRatingSummary();
    else:
    $ret[$id] ['reviews']='None';
    endif;
    $ret[$id]['img']=(string) $img;
    
        
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
   // exit;
    
    
    
    }
    
 $ret=array_values($ret);
 $result=json_encode($ret,JSON_PRETTY_PRINT) ;   

echo $result;
?>