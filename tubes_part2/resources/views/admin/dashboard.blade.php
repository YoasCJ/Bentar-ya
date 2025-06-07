@extends('layouts.app')

@section('title', 'Admin Dashboard - Skill Exchange')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Selamat Datang di Dashboard Admin!</h1>
    <p class="text-gray-700 mb-8">Ini adalah area khusus untuk Administrator. Anda bisa mengawasi dan mengelola aktivitas di aplikasi Skill Exchange.</p>

    {{-- BAGIAN STATISTIK SINGKAT --}}
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Statistik Singkat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Pengguna</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
                </div>
                <i class="fas fa-users text-4xl text-blue-300"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Postingan Terbuka</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $totalOpenPosts }}</p>
                </div>
                <i class="fas fa-hand-holding-heart text-4xl text-green-300"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Butuh Bantuan</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $totalNeedHelpPosts }}</p>
                </div>
                <i class="fas fa-question-circle text-4xl text-red-300"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Item Portfolio</h3>
                    <p class="text-3xl font-bold text-purple-600">{{ $totalPortfolioItems }}</p>
                </div>
                <i class="fas fa-briefcase text-4xl text-purple-300"></i>
            </div>
        </div>
    </div>

    {{-- BAGIAN AKTIVITAS TERBARU --}}
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Aktivitas Postingan Terbaru --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Postingan Terbaru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    @forelse($latestPosts as $post)
                        <li>"{{ Str::limit($post->title, 30) }}" oleh {{ $post->user->name }} ({{ $post->created_at->diffForHumans() }})</li>
                    @empty
                        <li>Tidak ada postingan terbaru.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Aktivitas Pengguna Terbaru --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Pengguna Baru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    @forelse($latestUsers as $userItem)
                        <li>{{ $userItem->name }} ({{ $userItem->role }}) - {{ $userItem->created_at->diffForHumans() }}</li>
                    @empty
                        <li>Tidak ada pengguna baru.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Aktivitas Portfolio Terbaru --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Portfolio Terbaru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    @forelse($latestPortfolios as $portfolio)
                        <li>"{{ Str::limit($portfolio->title, 30) }}" oleh {{ $portfolio->user->name }} ({{ $portfolio->created_at->diffForHumans() }})</li>
                    @empty
                        <li>Tidak ada portfolio terbaru.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection