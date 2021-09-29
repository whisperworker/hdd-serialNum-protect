<?php
$str = shell_exec('wmic DISKDRIVE GET SerialNumber');
$strRegEx = preg_match('/[\n][\w]{2,}/', $str, $matches);

$serialNum = trim(implode($matches));

$cryptedInfo = file_get_contents('Crypted.txt');

$ivlen = openssl_cipher_iv_length($cipher="AES-256-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);

$fileEncrypted = 'aes-encrypted.txt';
$contentsEncrypted = openssl_encrypt($cryptedInfo, $cipher, $serialNum, $options = OPENSSL_RAW_DATA, $iv);
file_put_contents($fileEncrypted, $contentsEncrypted);
