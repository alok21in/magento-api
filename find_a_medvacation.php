<?php
/**
 * @author alok dubey
 *  @2018
 */
require_once 'soapconfig.php';

$result = $proxy->catalogProductAttributeInfo($sessionId, 'find_a_medvacation');
//var_dump();
$ret['sucess']="true";
$ret['data']=$result->options;
//$result=$result->options;
print_r(json_encode($ret));


?>