<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class AES {

    protected $key;
    protected $data;
    protected $method;
    protected $options = 0;

    public function __construct($data = null, $key = null, $blockSize = 256, $mode = 'CBC') {
        if ($data !== null) {
            $this->setData($data);
        }
        if ($key !== null) {
            $this->setKey($key);
        }
        $this->setMethod($blockSize, $mode);
    }

    public function setData($data) {
        if (!is_string($data)) {
            throw new Exception('Data must be a string.');
        }
        $this->data = $data;
    }

    public function setKey($key) {
        if (!is_string($key)) {
            throw new Exception('Key must be a string.');
        }
        $this->key = hash('sha256', $key, true);
    }

    public function setMethod($blockSize, $mode = 'CBC') {
        $validModes = ['CBC', 'CFB', 'CFB1', 'CFB8', 'CTR', 'ECB', 'OFB', 'XTS'];
        if ($blockSize == 192 && in_array($mode, ['CBC-HMAC-SHA1', 'CBC-HMAC-SHA256', 'XTS'])) {
            throw new Exception('Invalid block size and mode combination!');
        }
        if (!in_array($mode, $validModes)) {
            throw new Exception('Invalid mode!');
        }
        $this->method = 'AES-' . $blockSize . '-' . $mode;
    }

    public function validateParams() {
        return $this->data !== null && $this->method !== null && $this->key !== null;
    }

    protected function getIV() {
        return '1234567890123456';
    }

    public function encrypt() {
        if ($this->validateParams()) {

            return trim(openssl_encrypt($this->data, $this->method, $this->getIV(), $this->options, $this->getIV()));

        } else {
            throw new Exception('Invalid params!');
        }
    }

    public function decrypt() {
        if ($this->validateParams()) {

            $ret = openssl_decrypt($this->data, $this->method, $this->getIV(), $this->options, $this->getIV());
            return trim($ret);
        } else {
            throw new Exception('Invalid params!');
        }
    }
}
