<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SsoController extends Controller
{
    private $ssoUrl_;
    private $clientId_;
    private $secretKey_;

    public function __construct()
    {
        $this->ssoUrl_ = env('SSO_BASE_URI');
        $this->clientId_ = env('SSO_CLIENT_ID');
        $this->secretKey_ = env('SSO_SECRET_KEY');
    }

    public function redirectToSso()
    {
        $redirectUri = route('callback');
        $ssoUrl = "$this->ssoUrl_/oauth/authorize?client_id={$this->clientId_}&redirect_uri={$redirectUri}&response_type=code&scope=user-info";

        return redirect($ssoUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');
        $redirectUri = route('callback');

        // Request access token
        $response = Http::post("$this->ssoUrl_/oauth/token", [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId_,
            'client_secret' => $this->secretKey_,
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]);

        $responseData = $response->json();

        // Pastikan response berhasil
        if (isset($responseData['access_token'])) {
            $accessToken = $responseData['access_token'];
            $expiresIn = $responseData['expires_in'] ?? 3600; // Default 1 jam jika tidak ada expires_in

            // Hitung waktu kedaluwarsa (dalam detik)
            $expiresAt = now()->addSeconds($expiresIn)->timestamp;

            // Simpan Access Token ke cookie
            Cookie::queue(
                'sso_tok',
                $accessToken,
                $expiresIn / 60, // Waktu kedaluwarsa dalam menit
                '/', // Path eksplisit ke root
                env('COOKIE_DOMAIN'), // Pastikan domain sesuai
                false, // Secure (ubah ke true jika HTTPS)
                false, // HttpOnly
                false, // Raw
                'Lax' // SameSite
            );

            // Simpan waktu kedaluwarsa ke cookie terpisah
            Cookie::queue(
                'sso_tok_expired',
                $expiresAt,
                $expiresIn / 60,
                '/',
                env('COOKIE_DOMAIN'),
                false,
                false,
                false,
                'Lax'
            );

            $SsoUser = $this->getUserBypass($accessToken);

            if (!empty($SsoUser)) {
                $user = User::updateOrCreate(
                    ['kd_karyawan' => $SsoUser['kd_karyawan']],
                    [
                        'name' => $SsoUser['name'],
                        'email' => $SsoUser['email'],
                    ]
                );

                // Set data pengguna ke request
                $request->attributes->set('user', $SsoUser);

                // Autentikasi pengguna lokal (opsional, untuk session Laravel)
                auth()->login($user);

                if (auth()->check()) return to_route('home');
            }
        }

        return redirect('/login')->withErrors(['message' => 'Failed to obtain access token']);
    }

    public function getUserBypass($token)
    {
        $response = Http::withToken($token)->get("$this->ssoUrl_/api/user");
        $user = $response->json();
        return $user;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke SSO Server untuk logout (opsional, untuk mengakhiri sesi di SSO)
        return redirect('/');
    }
}