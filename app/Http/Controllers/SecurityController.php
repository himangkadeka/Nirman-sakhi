<?php

namespace App\Http\Controllers;

use App\Models\MainWorkerForm;
use App\Models\TemporaryWorkerForm;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Exception;
use RealRashid\SweetAlert\Facades\Alert;

class SecurityController extends Controller
{

    protected $encryptMethod = 'AES-256-CBC';



    public function decrypt($encryptedString, $key)
    {
        $json = json_decode(base64_decode($encryptedString), true);
        try {
            $salt = hex2bin($json["salt"]);
            $iv = hex2bin($json["iv"]);
        } catch (Exception $e) {
            return null;
        }

        $cipherText = base64_decode($json['ciphertext']);

        $iterations = intval(abs($json['iterations']));
        if ($iterations <= 0) {
            $iterations = 999;
        }
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));
        unset($iterations, $json, $salt);

        $decrypted= openssl_decrypt($cipherText , $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        unset($cipherText, $hashKey, $iv);

        return $decrypted;
    }// decrypt



    public function encrypt($string, $key)
    {
        $ivLength = openssl_cipher_iv_length($this->encryptMethod);
        $iv = openssl_random_pseudo_bytes($ivLength);

        $salt = openssl_random_pseudo_bytes(256);
        $iterations = 999;
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));

        $encryptedString = openssl_encrypt($string, $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);

        $encryptedString = base64_encode($encryptedString);
        unset($hashKey);

        $output = ['ciphertext' => $encryptedString, 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];
        unset($encryptedString, $iterations, $iv, $ivLength, $salt);

        return base64_encode(json_encode($output));
    }// encrypt


    /**
     * Get encrypt method length number (128, 192, 256).
     *
     * @return integer.
     */
    protected function encryptMethodLength()
    {
        $number = filter_var($this->encryptMethod, FILTER_SANITIZE_NUMBER_INT);

        return (int) abs(intval($number));
    }// encryptMethodLength


    public function setCipherMethod($cipherMethod)
    {
        $this->encryptMethod = $cipherMethod;
    }// setCipherMethod

    public function testDecrypt(Request $request)
    {
        $token = '';
        $tokenEncrypted = MainWorkerForm::select('worker_id', 'vaultToken')->get();
//        return $tokenEncrypted;
        foreach ($tokenEncrypted as $tokenEnc) {
//            return($tokenEnc->vaultToken);

            $vaultTokenMain = $this->decrypt($tokenEnc->vaultToken, 'cb337a199c797cac72594e20639e1e804b0f45d50fa1c621c86be43aa0aed6c9');

            $token .= $tokenEnc->worker_id."->";
            $token .=$vaultTokenMain;
            $token .= "\n";
        }
        $data = $this->decrypt($request->encryptedString,$request->key);
        return $token;
    }

}
