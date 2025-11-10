<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckSsoTokenExpiration
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

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $accessToken = $request->cookie('sso_tok');
        $expiresAt = $request->cookie('sso_tok_expired');

        if (!$accessToken || !$expiresAt) {

            // Hapus cookie jika token tidak ada
            Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
            Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

            // hapus session auth
            if (auth()->check()) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return to_route('login')->withErrors(['message' => 'Access token not found']);
        }

        // Periksa apakah token sudah expired
        if (now()->timestamp > (int) $expiresAt) {

            // Hapus cookie jika token expired
            Cookie::queue(Cookie::forget('sso_tok', '/', env('COOKIE_DOMAIN')));
            Cookie::queue(Cookie::forget('sso_tok_expired', '/', env('COOKIE_DOMAIN')));

            // hapus session auth
            if (auth()->check()) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return to_route('login')->withErrors(['message' => 'Access token has expired']);
        }


        // get sso token user
        // Cache user data untuk menghindari HTTP call berulang
        $cacheKey = "sso_user_{$accessToken}";

        $ssoUser = Cache::remember($cacheKey, 300, function () use ($accessToken) {
            // HTTP call hanya jika belum ada di cache
            $response = Http::withToken($accessToken)->get("{$this->ssoUrl_}/api/user");
            return $response->json();
        });


        // SSO user null
        if (empty($ssoUser)) {
            // hapus session auth
            if (auth()->check()) {
                auth()->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return to_route('login')->withErrors(['message' => 'SSO User not found']);
        }


        // Cek dulu apakah user sudah ada, hindari updateOrCreate yang tidak perlu
        $user = User::where('kd_karyawan', $ssoUser['kd_karyawan'])->first();

        if (empty($user)) {
            // User baru, buat record
            $user = User::create([
                'kd_karyawan' => $ssoUser['kd_karyawan'],
                'name' => $ssoUser['name'],
                'email' => $ssoUser['email'],
                'password' => bcrypt('password'), // Hanya dipanggil sekali saat create
            ]);
        } else {
            // User sudah ada, update hanya jika ada perubahan
            if ($user->name !== $ssoUser['name'] || $user->email !== $ssoUser['email']) {
                $user->update([
                    'name' => $ssoUser['name'],
                    'email' => $ssoUser['email'],
                ]);
            }
        }

        // Set data pengguna ke request
        $request->attributes->set('user', $ssoUser);

        // Autentikasi pengguna lokal (opsional, untuk session Laravel)
        // Login hanya jika belum login
        if (!auth()->check() || auth()->id() !== $user->id) {
            auth()->login($user);
        }

        return $next($request);
    }
}