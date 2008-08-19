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

function barf_min($client) {
    print "<pre>\n";
    print "Request:\n".htmlspecialchars($client->__getLastRequest()) ."\n";
    print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
    print "</pre>"; 
}

function barf_var($var) {
    print "<pre>\n";
    var_dump($var);
    print "</pre>"; 
}

function url_exists($url) {
  $hdrs = @get_headers($url);
  return is_array($hdrs) ? preg_match('/^HTTP\\/\\d+\\.\\d+\\s+2\\d\\d\\s+.*$/',$hdrs[0]) : FALSE;
}

?>
