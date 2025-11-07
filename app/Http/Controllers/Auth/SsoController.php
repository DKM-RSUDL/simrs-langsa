<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SsoController extends Controller
{
    private $ssoUrl_;
    private $clientId_;
    private $secretKey_;
    private $appUrl_;

    public function __construct()
    {
        $this->ssoUrl_ = rtrim(env('SSO_BASE_URI'), '/');
        $this->clientId_ = env('SSO_CLIENT_ID');
        $this->secretKey_ = env('SSO_SECRET_KEY');
        $this->appUrl_ = rtrim(config('app.url'), '/');
    }

    public function redirectToSso()
    {
        // Redirect ke halaman login SSO, bukan langsung ke authorize
        // SSO akan handle authorize setelah user login
        $ssoLoginUrl = $this->ssoUrl_ . '/login';

        Log::info('Redirecting to SSO Login', [
            'sso_login_url' => $ssoLoginUrl
        ]);

        return redirect($ssoLoginUrl);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            Log::error('SSO Callback: No authorization code');
            return redirect('/login')->withErrors(['message' => 'Authorization code not found']);
        }

        $redirectUri = $this->appUrl_ . '/callback';

        Log::info('SSO Callback received', [
            'code' => substr($code, 0, 10) . '...',
            'redirect_uri' => $redirectUri
        ]);

        // Request access token
        $response = Http::asForm()->post($this->ssoUrl_ . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId_,
            'client_secret' => $this->secretKey_,
            'redirect_uri' => $redirectUri,
            'code' => $code,
        ]);

        $responseData = $response->json();

        Log::info('SSO Token Response', [
            'status' => $response->status(),
            'has_token' => isset($responseData['access_token']),
        ]);

        // Cek jika ada error
        if (!$response->successful() || isset($responseData['error'])) {
            Log::error('SSO Token Error', [
                'response' => $responseData,
                'status' => $response->status()
            ]);

            return redirect('/login')->withErrors([
                'message' => $responseData['error_description'] ?? 'Failed to obtain access token'
            ]);
        }

        if (isset($responseData['access_token'])) {
            $accessToken = $responseData['access_token'];
            $expiresIn = $responseData['expires_in'] ?? 3600;
            $expiresAt = now()->addSeconds($expiresIn)->timestamp;

            // Simpan ke cookie
            Cookie::queue(
                'sso_tok',
                $accessToken,
                $expiresIn / 60,
                '/',
                env('COOKIE_DOMAIN'),
                env('SESSION_SECURE_COOKIE', false),
                true,
                false,
                'Lax'
            );

            Cookie::queue(
                'sso_tok_expired',
                $expiresAt,
                $expiresIn / 60,
                '/',
                env('COOKIE_DOMAIN'),
                env('SESSION_SECURE_COOKIE', false),
                true,
                false,
                'Lax'
            );

            $ssoUser = $this->getUserBypass($accessToken);

            if (!empty($ssoUser) && isset($ssoUser['kd_karyawan'])) {
                $user = User::updateOrCreate(
                    ['kd_karyawan' => $ssoUser['kd_karyawan']],
                    [
                        'name' => $ssoUser['name'],
                        'email' => $ssoUser['email'],
                        'password' => bcrypt('password'),
                    ]
                );

                auth()->login($user);

                Log::info('User logged in successfully', ['user_id' => $user->id]);

                return redirect()->intended('/home');
            } else {
                Log::error('Failed to get SSO user data', ['response' => $ssoUser]);
                return redirect('/login')->withErrors(['message' => 'Failed to get user information']);
            }
        }

        return redirect('/login')->withErrors(['message' => 'Failed to obtain access token']);
    }

    public function getUserBypass($token)
    {
        try {
            $response = Http::withToken($token)
                ->timeout(10)
                ->get($this->ssoUrl_ . '/api/user');

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('SSO Get User Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('SSO Get User Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function getUser()
    {
        $accessToken = request()->cookie('sso_tok');

        if (!$accessToken) {
            return response()->json(['error' => 'No access token'], 401);
        }

        return response()->json($this->getUserBypass($accessToken));
    }

    public function logout(Request $request)
    {
        Log::info('User logging out', ['user_id' => auth()->id()]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus cookie
        Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
        Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

        // Redirect ke SSO logout juga (opsional)
        // return redirect($this->ssoUrl_ . '/logout');

        return redirect('/login');
    }
}