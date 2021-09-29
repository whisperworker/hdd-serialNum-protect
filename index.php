<?php

require_once 'crypt.php';
$str = shell_exec('wmic DISKDRIVE GET SerialNumber');
$strRegEx = preg_match('/[\n][\w]{2,}/', $str, $matches);

$serialNum = trim(implode($matches));


$fileEncrypted = 'aes-encrypted.txt';
$contents = file_get_contents($fileEncrypted);


$contentsDecrypted = openssl_decrypt($contents, $cipher, $serialNum, $options = OPENSSL_RAW_DATA, $iv);
echo $contentsDecrypted;






