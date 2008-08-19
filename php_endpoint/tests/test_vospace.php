<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once(BACKEND.'vospace.php');
require_once('debug_funcs.php');

class TestVOSpace extends UnitTestCase {

  function setUp() {
    $this->vospace = new VOSpace(); 
  }

  function testListNodes() {
    $this->assertNotNull($this->vospace);
    $node = array('uri' => 'ivo://example.org!vospace');
    $node_request = array('nodes' =>
			  array($node));
    $node_list = $this->vospace->listNodes($node_request);
    $this->assertEqual(count($node_list['nodes']), 4);
    // barf_var($node_list);
  }
}


$test = &new TestVOSpace();
$test->run(new HtmlReporter());

?>
