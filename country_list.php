<?php

/**
 * @author Alok Dubey
 * @2018
 */
ini_set('display_errors','On');
//error_reporting(E_ALL); 
require_once 'soapconfig.php';
require_once ('config.php');

$countries = $proxy->directoryCountryList($sessionId);
foreach ($countries as $country):
$ret['country'][$country->country_id]=$country->name;
endforeach;


$ret=array_values($ret);
//echo json_encode($ret);
echo  json_encode(array('sucess'=>"true",'data'=>$ret),JSON_PRETTY_PRINT);
?>