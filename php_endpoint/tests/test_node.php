<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once(BACKEND.'node.php');

class TestNode extends UnitTestCase {

  function setUp() {
    $this->node = new Node('ivo://example.org!vospace/bill_of_rights.txt'); 
  }

  function testNewNode() {
    $this->assertNotNull($this->node);
    $this->assertEqual($this->node->uri, 'ivo://example.org!vospace/bill_of_rights.txt'); 
    $this->assertEqual($this->node->file_path, FILE_SYSTEM_ROOT . 'bill_of_rights.txt'); 
  }

  function testNodeExists() {
    $this->assertTrue($this->node->exists());
  }

  function testNodeDoesntExist() {
    $false_node = new Node('ivo://example.org!vospace/foo.txt');
    $this->assertFalse($false_node->exists());
  }

  function testPropertySize(){
    //bill_of_rights = 2821 bytes
    $this->node->populateProperties();
    $this->assertEqual( $this->node->properties[0]["_"], "2821");
    $this->assertEqual( $this->node->properties[1]["_"], DATA_OWNER);
  }
}


$test = &new TestNode();
$test->run(new HtmlReporter());

?>
