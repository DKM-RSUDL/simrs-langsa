<?php

namespace App\Services\Bpjs;

use App\Models\BpjsKredensial;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use LZCompressor\LZString;

class BpjsService
{

    public function getKredensial()
    {
        $kredensial = BpjsKredensial::where('status', '1')->first();
        return $kredensial;
    }

    private function generateTimestamp()
    {
        // Dapatkan waktu sekarang dalam UTC dan convert ke Unix timestamp
        $timestamp = Carbon::now('UTC')->timestamp;
        return $timestamp;
    }

    private function generateSignature($consId, $secretKey, $timestamp)
    {
        $data = $consId . '&' . $timestamp;
        $signature = hash_hmac('sha256', $data, $secretKey, true);

        return base64_encode($signature);
    }

    private function generateHeaders($consId, $secretKey, $userKey)
    {
        $timestamp = $this->generateTimestamp();
        $signature = $this->generateSignature($consId, $secretKey, $timestamp);

        return [
            'X-cons-id'    => $consId,
            'X-timestamp'  => $timestamp,
            'X-signature'  => $signature,
            'user_key'     => $userKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Decompress response dari BPJS menggunakan LZString
     */
    // protected function decompress($string)
    // {
    //     try {
    //         $decompressed = LZString::decompressFromEncodedURIComponent($string);

    //         if ($decompressed === null || $decompressed === false) {
    //             Log::warning('LZString decompress failed, trying other methods');
    //             // Coba method lain jika gagal
    //             $decompressed = LZString::decompress($string);

    //             if ($decompressed === null || $decompressed === false) {
    //                 return $string; // Return original jika semua gagal
    //             }
    //         }

    //         return $decompressed;
    //     } catch (Exception $e) {
    //         Log::error('Decompress error: ' . $e->getMessage());
    //         return $string; // Return original string jika error
    //     }
    // }
    function decompress($string)
    {
        return LZString::decompressFromEncodedURIComponent($string);
    }



    /**
     * Decrypt response dari BPJS
     * Response BPJS biasanya di-compress dengan LZString
     */
    // public function decryptResponse($response)
    // {
    //     try {
    //         // Decompress response field
    //         $decrypted = $this->decompress($response);
    //         dd($decrypted);

    //         // Parse hasil decompress
    //         $decryptedData = json_decode($decrypted, true);

    //         if (json_last_error() === JSON_ERROR_NONE) {
    //             $response = $decryptedData;
    //         } else {
    //             $response = $decrypted;
    //         }

    //         return $response;
    //     } catch (Exception $e) {
    //         return null;
    //     }
    // }

    function decryptResponse($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        // hash
        $key_hash = hex2bin(hash('sha256', $key));
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        return $output;
    }

    public function icare($noKartu, $kdDokter)
    {
        try {
            // get kredensial
            $kredensial = $this->getKredensial();
            if (empty($kredensial)) throw new Exception('Kredensial BPJS tidak ditemukan.');
            // get header
            $headers = $this->generateHeaders($kredensial->cons_id, $kredensial->secret_key, $kredensial->userkey_icare);
            // data
            $data = [
                "param" => $noKartu,
                "kodedokter" => (int) $kdDokter
            ];
            // post to api i-care
            $response = Http::withHeaders($headers)->post("$kredensial->url_icare/api/rs/validate", $data);
            $result = $response->json();

            // check response
            if (isset($result['response'])) {
                $decryptKey = $kredensial->cons_id . $kredensial->secret_key . $headers['X-timestamp'];
                $decryptResponse = $this->decompress($this->decryptResponse($decryptKey, $result['response']));
                $decryptResult = json_decode($decryptResponse, true);

                // check url
                if (isset($decryptResult['url'])) {
                    return [
                        'status'    => 'success',
                        'message'   => '(' . $result['metaData']['code'] . ') ' . $result['metaData']['message'],
                        'data'      => $decryptResult['url']
                    ];
                }
                throw new Exception('URL I-Care pasien tidak ada pada response BPJS !');
            } else {
                throw new Exception('Data I-Care pasien tidak ditemukan !');
            }
        } catch (Exception $e) {
            return [
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ];
        }
    }
}
