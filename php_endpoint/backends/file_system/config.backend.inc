<?php

  // Backend specific configuration goes in here.

  // Top level of files being served by the endpoint.
  // This is the top node of the vospace.
if (! defined('FILE_SYSTEM_ROOT')) {
  define('FILE_SYSTEM_ROOT', '/var/www/vos/vospace/backends/file_system/sample_data/');
 }

// root url for returning data
// this should be the web server path the to the files being served
if(! defined('HTTP_ROOT')) {
  define('HTTP_ROOT', 'http://cadac-dev.ucsd.edu/vos/vospace/backends/file_system/sample_data/');
 }

// who to list as the data owner in the owner property
if (! defined('DATA_OWNER')) {
  define('DATA_OWNER', 'R. Wagner, rwagner@physics.ucsd.edu');
 }


?>
