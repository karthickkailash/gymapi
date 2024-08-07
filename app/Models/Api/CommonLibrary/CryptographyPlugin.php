<?php

namespace App\Models\Api\CommonLibrary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use DB;

class CryptographyPlugin extends Model
{

    /** @phpstan-ignore-next-line */
    private $nonce;
    /** @phpstan-ignore-next-line */
    private $key;
    /** @phpstan-ignore-next-line */
    private $block_size;

    public function __construct() {
      
       $this->nonce = env('LIB_SODIUM_NOUNCE');
        $this->key = env('LIB_SODIUM_KEY');
        //$get_val = DB::table('sodium_key_nonce')->first();
       // $this->nonce = $get_val->sodium_nonce;
       // $this->key = $get_val->sodium_key;
        //$this->block_size = '64';
      
    }
   
    /*
   public function sym_encode($message) 
    {
        try 
        {
            
                
            // Generate a secret key. This value must be stored securely.
           // $key = sodium_crypto_aead_xchacha20poly1305_ietf_keygen();
           // $key_en=(bin2hex($key));
           // dd($key_en);
           // $key_de=(hex2bin($key_en));

            // Generate a nonce for EACH MESSAGE. This can be public, and must be provided to decrypt the message.
            $nonce = \random_bytes(\SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
            //dd(base64_encode($nonce));
            $nonce_en=(bin2hex($nonce));
           // dd($nonce_en);
            $nonce_de=(hex2bin($nonce_en));

            // Text to encrypt.
            $message = 'Hello World';

            // Encrypt
            $encrypted_text = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($message, '', $nonce_de, $key_de);

           // dd($encrypted_text);
            // Decrypt
            $original_message = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($encrypted_text, '', $nonce_de, $key_de);

            dd($original_message);
           //return $cipher;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    
    public function sym_decode($encrypted) 
    {
        try {
          
            $encrypted = trim($encrypted); 
            if (!empty($encrypted)) {
				if(ctype_xdigit($encrypted)){
					// unpack base64 message
					$decoded = sodium_hex2bin($encrypted);
					if ($decoded === false) {
						return '';
					}
					$nonce_decoded = sodium_hex2bin($this->nonce);
					$key_decoded = sodium_hex2bin($this->key);
					// decrypt it and account for extra padding from $block_size (enforce 512 byte limit)
					$decrypted_padded_message = sodium_crypto_secretbox_open($decoded, $nonce_decoded, $key_decoded);
					$message = sodium_unpad($decrypted_padded_message, $this->block_size <= 512 ? $this->block_size : 512);

					if ($message === false) {
						return '';
					}

					// cleanup
					sodium_memzero($decoded);
					sodium_memzero($key_decoded);
					sodium_memzero($nonce_decoded);
                   
					return $message;
				} else {
					return '';            
				}
			} else {
                return '';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    */

     /**
     * 
     *
     * @param  string $str
     * 
     * @return mixed
     * 
     */

    
    
    function encode($str) 
    {
        //print_r($this->nonce);exit;
        try {
            $message = trim($str);
            if ($message != '') {

                $nonce_decoded = sodium_hex2bin($this->nonce);
                $key_decoded = sodium_hex2bin($this->key);
                // encrypt message and combine with nonce
               // $cipher = $encrypted_text = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($message, '', $nonce_decoded, $key_decoded);
               // return sodium_bin2hex(rtrim($cipher));
               $cipher = sodium_bin2hex(sodium_crypto_secretbox($message, $nonce_decoded, $key_decoded));
                //cleanup
               sodium_memzero($message);
                sodium_memzero($key_decoded);
                sodium_memzero($nonce_decoded);
               return utf8_decode(utf8_encode(rtrim($cipher)));
                //return sodium_bin2hex($cipher);
            } else {
                return "";
            }
        } catch (\Exception $e) {
            return $e->getMessage();
 
        }
    }

    /**
     * 
     *
     * @param  string $code
     * 
     * @return mixed
     * 
     */
    function decode(string $code) {
        try {
            $encrypted = trim($code);
            if (!empty($encrypted)) {
				if(ctype_xdigit($encrypted)){
					$decoded = sodium_hex2bin($encrypted);
                    /** @phpstan-ignore-next-line */
					if ($decoded === false) {
						return '';
					}
					$nonce_decoded = sodium_hex2bin($this->nonce);
					$key_decoded = sodium_hex2bin($this->key);
					// decrypt it
					$message = sodium_crypto_secretbox_open($decoded, $nonce_decoded, $key_decoded);
                   
					if ($message === false) {
						return '';
					}
					// cleanup
					sodium_memzero($decoded);
					sodium_memzero($key_decoded);
					sodium_memzero($nonce_decoded);
					return utf8_decode(utf8_encode(rtrim($message)));
				} else {
					return '';            
				}
			} else {
                return '';
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 
     *
     * @param  string $hexdata
     * 
     * @return mixed
     * 
     */
    protected function hex2bin($hexdata) {
        $bindata = '';

        for ($i = 0; $i < strlen($hexdata); $i += 2) {
            $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
        }

        return $bindata;
    }

}

