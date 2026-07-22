<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Render komponen layout guest (halaman login)
     */
    public function render(): View
    {
        return view('admin.layouts.guest');
    }
}
