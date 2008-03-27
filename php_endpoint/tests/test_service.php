<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once('../vospace_service.php');

class TestVOSpaceService extends UnitTestCase {
  function TestVOSpaceService() {
    $this->UnitTestCase();
    $this->vospace_server = new SoapServer('../vospace.wsdl', 
				     array('uri' => 'http://www.ivoa.net/xml/VOSpaceContract-v1.1rc1'));
    $this->vospace_server->SetClass("VOSpaceService");

    $this->service = new VOSpaceService();

  }

  function testNewServer() {
    $this->assertNotNull($this->vospace_server);
  }

  function testFunctionsList() {

    $function_list = $this->vospace_server->getFunctions();

    $this->assertNotNull($function_list);
    $this->assertTrue(in_array("ListNodes", $function_list));
    $this->assertEqual(count($function_list), 15);
  }

  function testProperties() {

    $prop_list = $this->service->GetProperties();

    $this->assertNotNull($prop_list);

    $mime_type = $prop_list["provides"]["mime_type"];

    // properties are of a class Property
    $this->assertNotNull($mime_type);    
    $this->assertEqual($mime_type->uri, "ivo://ivoa.net/vospace/core#mimetype");
    $this->assertEqual($mime_type->readOnly, TRUE);
  }

}


$test = &new TestVOSpaceService();
$test->run(new HtmlReporter());

?>
