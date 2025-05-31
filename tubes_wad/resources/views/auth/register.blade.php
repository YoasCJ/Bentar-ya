@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Register</h2> 
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            {{-- Kolom Jurusan --}}
            <div class="mb-4">
                <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}"
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('jurusan') border-red-500 @enderror">
                @error('jurusan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kolom Angkatan --}}
            <div class="mb-4">
                <label for="angkatan" class="block text-sm font-medium text-gray-700">Angkatan</label>
                <input id="angkatan" type="text" name="angkatan" value="{{ old('angkatan') }}"
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('angkatan') border-red-500 @enderror">
                @error('angkatan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kolom Nomor Handphone --}}
            <div class="mb-4">
                <label for="nomor_handphone" class="block text-sm font-medium text-gray-700">Nomor Handphone</label>
                <input id="nomor_handphone" type="text" name="nomor_handphone" value="{{ old('nomor_handphone') }}"
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nomor_handphone') border-red-500 @enderror">
                @error('nomor_handphone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kolom Profile Picture --}}
            <div class="mb-4">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Foto Profil</label>
                <input id="profile_picture" type="file" name="profile_picture"
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('profile_picture') border-red-500 @enderror">
                @error('profile_picture')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Kolom Certificate --}}
            <div class="mb-8">
                <label for="certificate" class="block text-sm font-medium text-gray-700">Sertifikat</label>
                <input id="certificate" type="file" name="certificate"
                    class="mt-1 w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('certificate') border-red-500 @enderror">
                @error('certificate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center items-center">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition-all duration-200">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>
@endsection