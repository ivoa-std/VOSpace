<?php

if (! defined('SIMPLE_TEST')) {
  define('SIMPLE_TEST', '/var/www/html/simpletest/');
 }

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once('../node.php');

class TestNode extends UnitTestCase {

  function TestNode() {
    $this->UnitTestCase();
    $this->node = new Node('ivo://example.org!vospace/foo.txt'); 
  }

  function testNewNode() {
    $this->assertNotNull($this->node);
    $this->assertEqual($this->node->uri, 'ivo://example.org!vospace/foo.txt'); 
    $this->assertEqual($this->node->ipath, '/scecZone/home/rwanger/foo.txt'); 
  }

}


$test = &new TestNode();
$test->run(new HtmlReporter());

?>
