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

  function testExistence() {
    $this->assertNotNull($this->vospace);
  }
}


$test = &new TestVOSpace();
$test->run(new HtmlReporter());

?>
