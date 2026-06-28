<?php


namespace App\Services;

use Illuminate\Http\Request;
//use http\Env\Request;
use http\Exception;
use function Ramsey\Uuid\Lazy\toString;

class Cipher
{
    private $secretCode;
    private $saltValue;

    public function __construct()
    {
        $this->secretCode = env('SECRET_CODE');
        $this->saltValue = env('SALT_VALUE');
    }

    public function encrypt($strToEncrypt, $secretCode, $saltValue)
    {
        try {
            $iv = str_repeat(chr(0), 16);
            $iterations = 65536;
            $keyLength = 256 / 8;

            $secretKey = hash_pbkdf2('sha256', $secretCode, $saltValue, $iterations, $keyLength, true);

            // AES encryption with CBC mode and PKCS5 Padding
            $cipher = "AES-256-CBC";

            // Encrypt the string
            $encrypted = openssl_encrypt($strToEncrypt, $cipher, $secretKey, OPENSSL_RAW_DATA, $iv);

            // Encode to base64
            return base64_encode($encrypted);
        } catch (Exception $e) {
            return null;
        }
    }

    public function decrypt(Request $request)
    {
        try {
            $iv = str_repeat(chr(0), 16); // Fixed IV of 16 null bytes

            $iterations = 65536;
            $keyLength = 256 / 8; // 32 bytes key

            // Ensure the same salt value used in encryption
            $saltValue = 561982709; // Use the correct salt (same as in encryption)
            $secretCode = 'asdfghjpparvezoiuytuandobqwerl'; // Ensure this matches the encryption secret code

            // Generate the key using PBKDF2
            $key = hash_pbkdf2("sha256", $secretCode, $saltValue, $iterations, $keyLength, true);

            // AES decryption with CBC mode and PKCS5 Padding
            $cipher = "aes-256-cbc";
            $decryptedData = openssl_decrypt(base64_decode($request->himangka), $cipher, $key, OPENSSL_RAW_DATA, $iv);

            return $decryptedData;
        } catch (Exception $e) {
            return response()->json(['error' => 'Decryption error'], 400);
        }
    }
}


