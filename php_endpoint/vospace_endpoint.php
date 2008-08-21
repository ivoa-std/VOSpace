<?php 

require_once('vospace_service.php');
// ini_set('soap.wsdl_cache_enabled', 0);

$vospace_server = new SoapServer('vospace.wsdl');

// make it fault
//$vospace_server = new SoapServer('tests/stockquote.wsdl');

$vospace_server->SetClass("VOSpaceService");

$vospace_server->handle();

?>
