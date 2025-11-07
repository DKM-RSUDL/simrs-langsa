<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckSsoTokenExpiration
{
    private $ssoUrl_;

    public function __construct()
    {
        $this->ssoUrl_ = rtrim(env('SSO_BASE_URI'), '/');
    }

    public function handle(Request $request, Closure $next): Response
    {
        $accessToken = $request->cookie('sso_tok');
        $expiresAt = $request->cookie('sso_tok_expired');

        // Jika tidak ada token, redirect ke login
        if (!$accessToken || !$expiresAt) {
            Log::info('No SSO token found, redirecting to login', [
                'has_token' => !empty($accessToken),
                'has_expires' => !empty($expiresAt)
            ]);
            $this->clearAuthData($request);
            return redirect()->route('login');
        }

        // Periksa apakah token sudah expired berdasarkan waktu lokal
        if (now()->timestamp > (int) $expiresAt) {
            Log::info('SSO token expired locally', [
                'current_time' => now()->timestamp,
                'expires_at' => (int) $expiresAt
            ]);
            $this->clearAuthData($request);
            return redirect()->route('login')->withErrors(['message' => 'Session expired, please login again']);
        }

        // Validasi token dengan SSO server
        try {
            $response = Http::withToken($accessToken)
                ->timeout(10)
                ->retry(2, 100) // Retry 2x jika gagal
                ->get($this->ssoUrl_ . '/api/user');

            if (!$response->successful()) {
                Log::warning('SSO token validation failed', [
                    'status' => $response->status(),
                    'user_id' => auth()->id()
                ]);
                $this->clearAuthData($request);
                return redirect()->route('login')->withErrors(['message' => 'Invalid session, please login again']);
            }

            $ssoUser = $response->json();

            // Validasi struktur data user
            if (!$this->isValidSsoUser($ssoUser)) {
                Log::error('Invalid SSO user data structure', [
                    'response' => $ssoUser,
                    'user_id' => auth()->id()
                ]);
                $this->clearAuthData($request);
                return redirect()->route('login')->withErrors(['message' => 'Invalid user data']);
            }

            // Update atau create user
            $user = $this->syncUser($ssoUser);

            // Set data pengguna ke request untuk digunakan di controller
            $request->attributes->set('sso_user', $ssoUser);

            // Login user jika belum login atau user berbeda
            if (!auth()->check() || auth()->id() !== $user->id) {
                auth()->login($user);
                Log::info('User logged in via middleware', ['user_id' => $user->id]);
            }

            return $next($request);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('SSO connection failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            // Jika SSO server down tapi user masih dalam masa expired, biarkan lanjut
            // Ini untuk menghindari logout massal saat SSO maintenance
            if (auth()->check()) {
                Log::warning('SSO unavailable but user session valid, allowing access');
                return $next($request);
            }

            $this->clearAuthData($request);
            return redirect()->route('login')->withErrors(['message' => 'Connection error, please try again']);

        } catch (\Exception $e) {
            Log::error('SSO validation exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);
            $this->clearAuthData($request);
            return redirect()->route('login')->withErrors(['message' => 'An error occurred, please login again']);
        }
    }

    /**
     * Validasi struktur data user dari SSO
     */
    private function isValidSsoUser($ssoUser)
    {
        return is_array($ssoUser)
            && isset($ssoUser['kd_karyawan'])
            && isset($ssoUser['name'])
            && isset($ssoUser['email'])
            && !empty($ssoUser['kd_karyawan']);
    }

    /**
     * Sinkronisasi data user dengan SSO
     */
    private function syncUser(array $ssoUser)
    {
        $userData = [
            'name' => $ssoUser['name'],
            'email' => $ssoUser['email'],
        ];

        // Cek apakah user sudah ada
        $existingUser = User::where('kd_karyawan', $ssoUser['kd_karyawan'])->first();

        if (!$existingUser) {
            // User baru, set password default
            $userData['password'] = bcrypt('password');
        }

        return User::updateOrCreate(
            ['kd_karyawan' => $ssoUser['kd_karyawan']],
            $userData
        );
    }

    /**
     * Clear authentication data
     */
    private function clearAuthData(Request $request)
    {
        // Hapus cookie
        Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
        Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

        // Hapus session auth
        if (auth()->check()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}