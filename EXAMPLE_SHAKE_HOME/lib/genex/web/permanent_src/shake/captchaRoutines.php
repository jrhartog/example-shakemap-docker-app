<?php
/* captchaRoutines.php - included by comment_form.php and wp_tt_make.php 
 *                       to do "string things" for the "CAPTCHA" and input field
 */

$key = "GSM 3.2.1";

function mungString($string) {
/* encrypt, base64 encode, then make result "URL-safe"
 * precond: $string exists
 * postcon: returns a URL-safe string 
 * method:  http://www.php.net/manual/en/function.mcrypt-encrypt.php
 */

    global $key;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, $iv);
    $encstring = base64_encode($crypttext);

    $encstring = str_replace(array('+','/','='), array('-','_','.'), $encstring);

    return $encstring;
}

function unMungString($string) {
// Decode the word
    global $key;

    $word = str_replace(array('-','_','.'),array('+','/','='), $string);

    $string = base64_decode($word);


    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $word = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, $iv);
    return $word;
}

function RandomString($length=32) {
// function to generate random strings
    $randstr = '';
    srand((double)microtime()*1000000);
    //our array add all letters and numbers if you wish
#  $chars = array ( 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $chars = array ( 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

    for ($rand = 0; $rand <= $length; $rand++) {
        $random = rand(0, count($chars) -1);
        $randstr .= " " . $chars[$random];
    }
    return $randstr;
}

function isMatch($hash, $testWord) {
   $testHash = preg_replace('/=+$/', '', base64_encode(pack('H*', md5($testWord) ) ) );

    return $hash == $testHash; 
}
?>
