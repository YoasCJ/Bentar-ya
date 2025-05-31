@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Daftar Semua Profil Pengguna</h1>

    @if ($users->isEmpty())
        <p class="text-center text-gray-600">Belum ada pengguna yang terdaftar.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($users as $user)
                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                    <div class="flex items-center mb-4">

                        @if ($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Foto Profil {{ $user->nama }}"
                                class="w-16 h-16 rounded-full object-cover mr-4 border-2 border-blue-400">
                        @else
                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 text-xl font-semibold mr-4">
                                {{ substr($user->nama, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $user->nama }}</h2>
                            <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-2 text-gray-700">
                        <p><strong class="font-medium">Jurusan:</strong> {{ $user->jurusan ?? '-' }}</p>
                        <p><strong class="font-medium">Angkatan:</strong> {{ $user->angkatan ?? '-' }}</p>
                        <p><strong class="font-medium">No. HP:</strong> {{ $user->nomor_handphone ?? '-' }}</p>
                        <p><strong class="font-medium">Skills:</strong>
                            @if ($user->skills->isNotEmpty())
                                {{ $user->skills->pluck('nama')->join(', ') }}
                            @else
                                -
                            @endif
                        </p>
                        <p><strong class="font-medium">Sertifikat:</strong>
                            @if ($user->certificate_path)
                                <a href="{{ asset('storage/' . $user->certificate_path) }}" target="_blank" class="text-blue-500 hover:underline">Lihat Sertifikat</a>
                            @else
                                Tidak Ada
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection