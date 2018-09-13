<?php

// File to download.
$filepath = '/home/file/public_html/var/support/';


// Give a nice name to your download.
$filename = 'no_file.txt';
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
readfile_chunked($filepath.$filename);




// Read a file and display its content chunk by chunk
function readfile_chunked($filename, $retbytes = TRUE) {
    // Maximum size of chunks (in bytes).
    $maxRead = 1 * 1024 * 1024; // 1MB
    $buffer = '';
    $cnt    = 0;
    $handle = fopen($filename, 'rb');

    if ($handle === false) {
        return false;
    }

    while (!feof($handle)) {
        $buffer = fread($handle, $maxRead);
        echo $buffer;
        ob_flush();
        flush();

        if ($retbytes) {
            $cnt += strlen($buffer);
        }
    }

    $status = fclose($handle);

    if ($retbytes && $status) {
        return $cnt; // return num. bytes delivered like readfile() does.
    }

    return $status;
}

