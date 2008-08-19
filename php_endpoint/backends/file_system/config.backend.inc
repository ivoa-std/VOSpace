<?php

  // Backend specific configuration goes in here.

  // Top level of files being served by the endpoint.
  // This is the top node of the vospace.
if (! defined('FILE_SYSTEM_ROOT')) {
  define('FILE_SYSTEM_ROOT', '/var/www/vos/vospace/backends/file_system/sample_data/');
 }

if (! defined('DATA_OWNER')) {
  define('DATA_OWNER', 'R. Wagner, rwagner@physics.ucsd.edu');
 }

?>
