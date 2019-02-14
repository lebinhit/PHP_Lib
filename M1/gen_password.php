<?php
$password = 'forixadmin!123';
echo "md5 pass: ".md5($password); //md5 hash
echo "sh1 pass: ".$salt=sha1($password); //sh1 hash
echo "magento pass: ". md5($salt.$password).":".$salt; //magento hash  with salt

//for wordpress, you need include PasswordHash class.
#$wp_hasher = new PasswordHash(8, true);
#echo "wp(v3 & v4) pass is: ". $wp_hasher->HashPassword( trim( $password ) );
die();