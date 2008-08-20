<?php
// if ($handle = opendir('./sample_data/')) {
//     while (false !== ($file = readdir($handle))) {
//         if ($file != "." && $file != ".." && $file != ".svn") {
//             echo "$file\n";
//         }
//     }
//     closedir($handle);
// }

 foreach (glob("/var/www/vos/vospace/backends/file_system/sample_data/*") as $filename) {
     echo "$filename <br>";
 }

// $v = "/foo/.svn";
// echo basename($v) . "<br>";
// echo $v[strlen($v)- 1];

// if(is_file("sample_data"))
//   echo "True<br>";
// else
//   echo "False<br>";

?>
