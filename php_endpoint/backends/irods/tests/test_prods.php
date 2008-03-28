<?php

include('../config.inc');

require_once(SIMPLE_TEST . 'unit_tester.php');
require_once(SIMPLE_TEST . 'reporter.php');

require_once(PRODS_ROOT."RODSConn.class.php");
require_once(PRODS_ROOT."RODSConnManager.class.php");

class TestPRODS extends UnitTestCase {
  function TestPRODS() {
    $this->UnitTestCase();
    $this->account=new RODSAccount(IRODS_SERVER, IRODS_PORT, IRODS_USER, IRODS_PASS, IRODS_ZONE);
  }

  function setUp(){
    $this->conn = RODSConnManager::getConn($this->account);
  }

  function tearDown(){
    RODSConnManager::releaseConn($this->conn);  
  }

  function testGetConnection() {
    $this->assertNotNull($this->conn);
    $this->assertTrue($this->conn->dirExists (IRODS_HOME));
    $this->assertTrue($this->conn->dirExists (IRODS_HOME."/blah"));
  }

  function testProdsDir() {

    $dir=new ProdsDir($this->account,IRODS_HOME);

    $childdirs=$dir->getChildDirs();
    $this->assertTrue( count($childdirs) > 0 );

    $childfiles=$dir->getChildFiles();
    $this->assertTrue( count($childfiles) > 0 );

  }

  function testProdsFile() {

    $dir=new ProdsDir($this->account,IRODS_HOME);
    $myfile=new ProdsFile($this->account,IRODS_HOME."/test1");
    $myfile->open("w+","demoResc");
    $bytes=$myfile->write("Hello world from Sifang!\n");
    $this->assertEqual( $bytes, 25 );
    $myfile->close();

    $myfile->open("r","demoResc",true);
    $str=$myfile->read(200);
    $this->assertEqual($str, "Hello world from Sifang!\n");
    $myfile->close();
  }

  function testStats() {
   
    $file=new ProdsFile($this->account,IRODS_HOME."/test.php");
    $stats = $file->getStats();
    $this->assertEqual($stats->name, "test.php");

  }

}

$test = &new TestPRODS();
$test->run(new HtmlReporter());

?>