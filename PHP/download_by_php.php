<?php

// File to download.
$filepath = '/home/file/public_html/var/support/';

// Maximum size of chunks (in bytes).
$maxRead = 1 * 1024 * 1024; // 1MB

// Give a nice name to your download.
$filename = 'not_file.txt';
if(isset($_GET['code'])){
    $filename = 'file1.tar.gz';
}elseif(isset($_GET['db'])){
    $filename = 'file2.gz';
}else{
    die('Plase select file download');
}
// http headers for zip downloads
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($filepath.$filename));
ob_end_flush();
@readfile($filepath.$filename);

