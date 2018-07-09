<?php
/**
 * @author alok dubey
 *  @2018
 */
$proxy = new SoapClient('http://medvacations.com/magento/api/v2_soap/?wsdl'); // TODO : change url
$sessionId = $proxy->login('admin', 'admin@123'); // TODO : change login and pwd if necessary


?>