@extends('layouts.app')

@section('title', 'Admin Dashboard - Skill Exchange')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Selamat Datang di Dashboard Admin!</h1>
    <p class="text-gray-700">Ini adalah area khusus untuk Administrator. Anda bisa menambahkan link ke pengelolaan user, postingan, dll. di sini.</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {{-- Kotak untuk Manajemen Pengguna --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Pengguna</h2>
            <p class="text-gray-600 mb-4">Lihat dan kelola semua akun pengguna terdaftar.</p>
            <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg inline-block">
                Kelola Pengguna <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        {{-- Kotak untuk Manajemen Postingan --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Postingan</h2>
            <p class="text-gray-600 mb-4">Pantau dan modifikasi semua postingan yang ada.</p>
            <a href="#" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg inline-block">
                Kelola Postingan <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>

        {{-- Kotak untuk Manajemen Skill --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Manajemen Skill</h2>
            <p class="text-gray-600 mb-4">Tambah, edit, atau hapus skill yang tersedia.</p>
            <a href="#" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded-lg inline-block">
                Kelola Skill <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>

</div>
@endsection