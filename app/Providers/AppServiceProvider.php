<?php

namespace App\Providers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use App\Models\Kontak;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan service apapun
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap: jalan saat aplikasi mulai
     */
    public function boot(): void
    {
        // Kirim data $unreadMessages ke SEMUA view di folder admin/
        View::composer('admin.*', function ($view) {
            $view->with('unreadMessages', Kontak::where('status', 'unread')->count());
        });

        // Rate limiters
        RateLimiter::for('contact', function ($request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by(
                $request->input('email') . '|' . $request->ip()
            );
        });

        RateLimiter::for('rfid-api', function ($request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(60)->by($request->ip());
        });
    }
}
