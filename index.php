<?php


/*$str = shell_exec('wmic DISKDRIVE GET SerialNumber');

$strRegEx = preg_match('/[\n][\w]{2,}/', $str, $matches);

$serialNum = trim(implode($matches));


$allowedSerialNums = ['0025_38D6_11B0_8983', 'WXE1E87FDALU'];

foreach ($allowedSerialNums as $allowedSerialNum) {
    if (in_array($serialNum, $allowedSerialNums)) {
        echo '<h1>Hello User</h1>';
        break;
    }
    else {
        echo "<h1>SERIAL NUMBER($serialNum) IS NOT FOUNDED IN THE LIST OF ALLOWED</h1>";
        break;
    }
}*/

/*--------------------------------------------------------------------------------------------------------------------------*/

/*//Записываем в переменную результат выполнения команды
$str = shell_exec('wmic DISKDRIVE GET SerialNumber');
//Достаем серийный номер диска
$strRegEx = preg_match('/[\n][\w]{2,}/', $str, $matches);

//Преобразуем совпадения из массива в строку и хешируем серийник
$serialNum = trim(implode($matches));
$serialNumHash = password_hash($serialNum,PASSWORD_DEFAULT);

//Достаем разрешенные серийники и преобразуем их в массив
$allowedSerialNums = explode(", ", file_get_contents('AllowedSerialNums.txt'));

if (password_verify($allowedSerialNums[0], $serialNumHash)) {
    echo '<h1>Hello User</h1>';
}
else {
    echo "<h1>SERIAL NUMBER IS NOT FOUNDED IN THE LIST OF ALLOWED</h1>";
}*/

/*--------------------------------------------------------------------------------------------------------------------------*/

//Записываем в переменную результат выполнения команды
$str = shell_exec('wmic DISKDRIVE GET SerialNumber');
//Достаем серийный номер диска
$strRegEx = preg_match('/[\n][\w]{2,}/', $str, $matches);

//Преобразуем совпадения из массива в строку и хешируем серийник
$serialNum = trim(implode($matches));

$key = password_hash($serialNum,PASSWORD_DEFAULT);

//Достаем разрешенные серийники и преобразуем их в массив
$allowedSerialNums = file_get_contents('AllowedSerialNums.txt');


//Выбираем метод для шифрования файла
$ivlen = openssl_cipher_iv_length($cipher="AES-256-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);

$fileEncrypted = 'aes-encrypted.txt';
//Шифруем информацию о серийниках
$contentsEncrypted = openssl_encrypt($allowedSerialNums, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
file_put_contents($fileEncrypted, $contentsEncrypted);

//Получаем зашифрованные данные
$serialNumEncrypted = file_get_contents($fileEncrypted);
//хешируем зашифрованные данные
$serialNumHash = password_hash($serialNumEncrypted, PASSWORD_DEFAULT);


//Сверяем хеши зашифрованных и захешированных шифрованных данных
if (password_verify($serialNumEncrypted, $serialNumHash)) {

    $contents = file_get_contents($fileEncrypted);
    $contentsDecrypted = openssl_decrypt($contents, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
    $fileDecrypted = 'aes-decrypted.txt';
    file_put_contents($fileDecrypted, $contentsDecrypted);

    $allowedSerialNumsArr = explode(", ", file_get_contents('AllowedSerialNums.txt'));


    /*if(password_verify($allowedSerialNumsArr[0], $key)) {
        echo "<h1>HELLO USSR</h1>";
    }*/
    foreach ($allowedSerialNumsArr as $allowedSerialNum) {
        //Проверка на наличие серийника в файле и проверка хеша серийника
        if(in_array($serialNum, $allowedSerialNumsArr) && password_verify($allowedSerialNum, $key)) {
            echo "<h1>HELLO USSR</h1>";
            exit;
        }
    }
    echo "<h1>SERIAL NUMBER IS NOT FOUNDED IN THE LIST OF ALLOWED</h1>";
}
else {
    echo "<h1>SERIAL NUMBER IS NOT FOUNDED IN THE LIST OF ALLOWED</h1>";
}

/*--------------------------------------------------------------------------------------------------------------------------*/

/*//Записываем в переменную результат выполнения команды
$str = shell_exec('wmic DISKDRIVE GET SerialNumber');
//Достаем серийный номер диска
$strRegEx = preg_match('/[\n][\w]{2,}/', $str, $matches);

//Преобразуем совпадения из массива в строку и хешируем серийник
$serialNum = trim(implode($matches));
$key = password_hash($serialNum,PASSWORD_DEFAULT);

//Достаем разрешенные серийники и преобразуем их в массив
$allowedSerialNums = explode(", ", file_get_contents('AllowedSerialNums.txt'));

//Выбираем метод для шифрования файла
$ivlen = openssl_cipher_iv_length($cipher="AES-192-CBC");
$iv = openssl_random_pseudo_bytes($ivlen);

for($i = 0; $i < count($allowedSerialNums); $i++) {
    //Шифруем файл, выбирая из массива первый серийный номер; метод; ключ шифрования
    $contentsEncrypted = openssl_encrypt($allowedSerialNums[$i], $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
}

//Создаем файл с зашифрованным серийным номером
$fileEncrypted = 'aes-encrypted.txt';
file_put_contents($fileEncrypted, $contentsEncrypted);

$serialNumEncrypted = file_get_contents('aes-encrypted.txt');

$serialNumHash = password_hash($serialNumEncrypted, PASSWORD_DEFAULT);


if (password_verify($serialNumEncrypted, $serialNumHash)) {
    echo '<h1>Hello User</h1>';
}
else {
    echo "<h1>SERIAL NUMBER IS NOT FOUNDED IN THE LIST OF ALLOWED</h1>";
}*/

/*--------------------------------------------------------------------------------------------------------------------------*/






