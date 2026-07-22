@php
    $settings = $settings ?? \App\Models\Setting::pluck('value', 'key');
    $primaryColor = $settings['primary_color'] ?? '#2563eb';
    $palette = \App\Models\Setting::generateColorPalette($primaryColor);
@endphp
<style>
    :root {
        --color-primary-50: {{ $palette[50] }};
        --color-primary-100: {{ $palette[100] }};
        --color-primary-200: {{ $palette[200] }};
        --color-primary-300: {{ $palette[300] }};
        --color-primary-400: {{ $palette[400] }};
        --color-primary-500: {{ $palette[500] }};
        --color-primary-600: {{ $palette[600] }};
        --color-primary-700: {{ $palette[700] }};
        --color-primary-800: {{ $palette[800] }};
        --color-primary-900: {{ $palette[900] }};
        --color-primary-950: {{ $palette[950] }};
    }
</style>
