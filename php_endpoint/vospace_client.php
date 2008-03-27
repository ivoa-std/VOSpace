<?php

function barf($client) {
    print "<pre>\n";
    print "Request:\n".htmlspecialchars($client->__getLastRequest()) ."\n";
    print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
    print "</pre>"; 

    print "<pre>"; 
    print_r($client->__getTypes());
    print "</pre>"; 

}

$client = new SoapClient("vospace10_caltech.wsdl",		 
			 array('location' => 'http://vops1.hq.eso.org:8080/vospace/services/VOSpacePort',
			       "trace"      => 1,
			       "exceptions" => 1));
  
try { 
  $response = $client->GetNode(array("target" => 'ivo://foo.bar.baz!bang'));
} 
catch (SoapFault $exp) { 
  //  print $exp;
  print "<pre>";     
  var_dump($exp);
  print "</pre>"; 
  print $exp->getMessage(); 
}

barf($client);

?>
