<?php  
$hostname="localhost";
$username="root";
$password="";
$database="kriptografi";
$connect=new mysqli($hostname, $username, $password, $database);
$key = "b1nGuN68Ang3t";
$aes = "AES-256-CBC";
$des = "DES-EDE3-CFB";
$aes_iv = "pU5in61nIK3p4la4";
$des_iv = "C4p38GT7";
$vigenere_key = "yaudah";

function vigenereEncrypt($message, $keyword) {
    $result = '';
    $keyLength = strlen($keyword);

    for ($i = 0, $j = 0; $i < strlen($message); $i++) {
        $char = $message[$i];
        $charCode = ord($char);

        if (ctype_alpha($char)) {
            $caseAdjustment = ctype_upper($char) ? ord('A') : ord('a');
            $result .= chr(($charCode + (ord($keyword[$j % $keyLength]) % 26) - $caseAdjustment) % 26 + $caseAdjustment);
            $j++;
        } else {
            $result .= $char;
        }
    }

    return $result;
}

function vigenereDecrypt($cipher, $keyword) {
    $result = '';
    $keyLength = strlen($keyword);

    for ($i = 0, $j = 0; $i < strlen($cipher); $i++) {
        $char = $cipher[$i];
        $charCode = ord($char);

        if (ctype_alpha($char)) {
            $caseAdjustment = ctype_upper($char) ? ord('A') : ord('a');
            $result .= chr(($charCode - (ord($keyword[$j % $keyLength]) % 26) + 26 - $caseAdjustment) % 26 + $caseAdjustment);
            $j++;
        } else {
            $result .= $char;
        }
    }

    return $result;
}

function superEncryption($input){
    global $vigenere_key,$aes,$key,$aes_iv;

    $step1=vigenereEncrypt($input,$vigenere_key);
    $step2=openssl_encrypt($step1, $aes, $key, 0, $aes_iv);
    return $step2;
}

function superDecryption($input){
    global $vigenere_key,$aes,$key,$aes_iv;

    $step1=openssl_decrypt($input, $aes, $key, 0, $aes_iv);
    $step2=vigenereDecrypt($step1,$vigenere_key);
    return $step2;
}
?>