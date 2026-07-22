<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center px-4">
        <div class="text-8xl font-bold text-red-500 mb-4">403</div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Akses Ditolak</h1>
        <p class="text-gray-500 mb-6 max-w-md">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url()->previous() ?: '/' }}"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            Kembali
        </a>
    </div>
</body>
</html>
