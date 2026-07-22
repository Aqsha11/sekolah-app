<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Render komponen layout admin
     */
    public function render(): View
    {
        return view('admin.layouts.app');
    }
}
