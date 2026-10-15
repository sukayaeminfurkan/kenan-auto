<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kenan Auto — Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen">

    <!-- Header -->
    <nav class="bg-red-600 px-6 py-4 flex items-center justify-between">
        <span class="text-white font-bold text-lg">Kenan Auto — Admin</span>
        <form method="POST" action="/logout">
            @csrf
            <button class="text-white text-sm hover:underline">Çıkış Yap</button>
        </form>
    </nav>

    <!-- İçerik -->
    <div class="max-w-4xl mx-auto py-12 px-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Admin Paneli</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="/admin/servis-noktalari"
               class="admin-card hover:shadow-md transition">
                <div class="text-3xl mb-3">🔧</div>
                <div class="font-bold text-gray-800">Servis Noktaları</div>
                <div class="text-sm text-gray-500 mt-1">Ekle, düzenle, sil</div>
            </a>

            <a href="/admin/araclar"
               class="admin-card hover:shadow-md transition">
                <div class="text-3xl mb-3">🚗</div>
                <div class="font-bold text-gray-800">Araçlar</div>
                <div class="text-sm text-gray-500 mt-1">Ekle, düzenle, öne çıkar</div>
            </a>

            <a href="/admin/markalar"
               class="admin-card hover:shadow-md transition">
                <div class="text-3xl mb-3">🏷️</div>
                <div class="font-bold text-gray-800">Markalar & Modeller</div>
                <div class="text-sm text-gray-500 mt-1">Marka ve model yönetimi</div>
            </a>
        </div>
    </div>
</div>
</body>
</html>
