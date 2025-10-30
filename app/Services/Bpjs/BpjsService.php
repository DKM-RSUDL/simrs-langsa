<?php

namespace App\Services\Bpjs;

use App\Models\BpjsKredensial;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;

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
        $kredensial = $this->getKredensial();
        if (empty($kredensial)) throw new Exception('Kredensial BPJS tidak ditemukan.');

        $timestamp = $this->generateTimestamp();
        $signature = $this->generateSignature($consId, $secretKey, $timestamp);

        return [
            'X-cons-id'    => $consId,
            'X-timestamp'  => $timestamp,
            'X-signature'  => $signature,
            'user_key'     => $userKey,
            'Content-Type' => 'application/json',
        ];
    }

    // public function icare($noKartu, $tglPelayanan)
    // {
    //     $kredensial = $this->getKredensial();
    //     if (!$kredensial) {
    //         throw new \Exception('Kredensial BPJS tidak ditemukan.');
    //     }

    //     $client = new \GuzzleHttp\Client();
    //     $response = $client->request('GET', 'https://new-api.bpjs-kesehatan.go.id/icare-rest-v2.0.0/sep/'.$noKartu.'/tglPelayanan/'.$tglPelayanan, [
    //         'headers' => [
    //             'X-Cons-ID' => $kredensial->cons_id,
    //             'X-Timestamp' => time(),
    //             'X-Signature' => base64_encode(hash_hmac('sha256', $kredensial->cons_id . '&' . time(), $kredensial->secret_key, true)),
    //             'Content-Type' => 'application/json',
    //         ],
    //     ]);

    //     $body = $response->getBody();
    //     $data = json_decode($body, true);

    //     return $data;


    // Contoh penggunaan dengan HTTP Client
    // $response = \Http::withHeaders($headers)
    //     ->post('https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/SEP/2.0/insert', $data);

    // return $response->json();
    // }

    public function icare($noKartu, $kdDokter)
    {
        try {
            $kredensial = $this->getKredensial();
            if (empty($kredensial)) throw new Exception('Kredensial BPJS tidak ditemukan.');

            $headers = $this->generateHeaders($kredensial->cons_id, $kredensial->secret_key, $kredensial->userkey_icare);

            $data = [
                'param'         => $noKartu,
                'kodedokter'    => $kdDokter,
            ];

            $response = Http::withHeaders($headers)->post($kredensial->url_icare, $data);
            $result = $response->json();

            if (empty($result)) throw new Exception();
        } catch (Exception $e) {
            return [
                'status'    => 'error',
                'message'   => $e->getMessage(),
                'data'      => []
            ];
        }
    }
}
