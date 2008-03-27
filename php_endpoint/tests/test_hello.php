<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once('log.php');


class TestOfLogging extends UnitTestCase {
  function TestOfLogging() {
    $this->UnitTestCase();
  }
  function testCreatingNewFile() {
    @unlink('/tmp/test.log');

    $log = new Log('/tmp/test.log');
    $this->assertFalse(file_exists('../temp/test.log'), 'No file created before first message');

    $log = new Log('/tmp/test.log');
    $log->message('Should write this to a file');
    $this->assertTrue(file_exists('/tmp/test.log'));

  }
}

$test = &new TestOfLogging();
$test->run(new HtmlReporter());

?>
