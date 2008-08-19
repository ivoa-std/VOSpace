<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once('../vospace_service.php');

require_once('debug_funcs.php');

class target_node{
  public $target;
  function __construct($tg) {
    $this->target = $tg;
  }
}

class TestVOSpaceService extends UnitTestCase {
  function setUp() {
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

    //barf_var($prop_list);

    $this->assertNotNull($prop_list);

    $size = $prop_list["provides"][0];

    // properties are of a class Property
    $this->assertNotNull($size);
    $this->assertEqual($size["uri"], "ivo://net.ivoa.vospace/properties#size");
    $this->assertEqual($size["readOnly"], TRUE);
  }

  function testGetNode() {
    
    $node = $this->service->GetNode(new target_node('ivo://example.org!vospace/128cubed_hierarchy.png'));

    //barf_var($node);

    $this->assertNotNull($node["node"]);
    $this->assertEqual($node["node"]->properties[0]["_"], 569516);
  }


}


$test = &new TestVOSpaceService();
$test->run(new HtmlReporter());

?>
