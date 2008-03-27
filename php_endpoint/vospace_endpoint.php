<?php 

require_once('vospace_service.php');

$vospace_server = new SoapServer('vospace.wsdl');

// make it fault
//$vospace_server = new SoapServer('tests/stockquote.wsdl');

$vospace_server->SetClass("VOSpaceService");
$vospace_server->handle();

?>
