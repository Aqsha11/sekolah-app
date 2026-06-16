<?php

namespace App\Providers;

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
        // Dipakai oleh sidebar (badge notif) dan bell icon di navbar
        View::composer('admin.*', function ($view) {
            $view->with('unreadMessages', Kontak::where('status', 'unread')->count());
        });
    }
}
