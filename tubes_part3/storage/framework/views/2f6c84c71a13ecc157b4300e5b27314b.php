<?php $__env->startSection('title', 'Admin Dashboard - Skill Exchange'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Selamat Datang di Dashboard Admin!</h1>
    <p class="text-gray-700 mb-8">Ini adalah area khusus untuk Administrator. Anda bisa mengawasi dan mengelola aktivitas di aplikasi Skill Exchange.</p>

    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Statistik Singkat</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Pengguna</h3>
                    <p class="text-3xl font-bold text-blue-600"><?php echo e($totalUsers); ?></p>
                </div>
                <i class="fas fa-users text-4xl text-blue-300"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Postingan Terbuka</h3>
                    <p class="text-3xl font-bold text-green-600"><?php echo e($totalOpenPosts); ?></p>
                </div>
                <i class="fas fa-hand-holding-heart text-4xl text-green-300"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Butuh Bantuan</h3>
                    <p class="text-3xl font-bold text-red-600"><?php echo e($totalNeedHelpPosts); ?></p>
                </div>
                <i class="fas fa-question-circle text-4xl text-red-300"></i>
            </div>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Item Portfolio</h3>
                    <p class="text-3xl font-bold text-purple-600"><?php echo e($totalPortfolioItems); ?></p>
                </div>
                <i class="fas fa-briefcase text-4xl text-purple-300"></i>
            </div>

            
            <?php if(isset($totalWarnings)): ?>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Total Peringatan</h3>
                    <p class="text-3xl font-bold text-yellow-600"><?php echo e($totalWarnings); ?></p>
                </div>
                <i class="fas fa-exclamation-triangle text-4xl text-yellow-300"></i>
            </div>
            <?php endif; ?>

            <?php if(isset($pendingWarnings)): ?>
            <div class="bg-white rounded-lg shadow p-5 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Peringatan Menunggu Aksi</h3>
                    <p class="text-3xl font-bold text-orange-600"><?php echo e($pendingWarnings); ?></p>
                </div>
                <i class="fas fa-clock text-4xl text-orange-300"></i>
            </div>
            <?php endif; ?>
            

        </div>
    </div>

    
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Aksi Cepat Admin</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                <i class="fas fa-users mr-2"></i> Manajemen Pengguna
            </a>
            <a href="<?php echo e(route('admin.posts.index')); ?>" class="block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                <i class="fas fa-clipboard-list mr-2"></i> Manajemen Postingan
            </a>
            <a href="<?php echo e(route('admin.portfolios.index')); ?>" class="block bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                <i class="fas fa-briefcase mr-2"></i> Manajemen Portfolio
            </a>
            <a href="<?php echo e(route('admin.warnings.index')); ?>" class="block bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                <i class="fas fa-bell mr-2"></i> Manajemen Peringatan
            </a>
        </div>
    </div>


    
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Aktivitas Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Postingan Terbaru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>"<?php echo e(Str::limit($post->title, 30)); ?>" oleh <?php echo e($post->user->name); ?> (<?php echo e($post->created_at->diffForHumans()); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li>Tidak ada postingan terbaru.</li>
                    <?php endif; ?>
                </ul>
            </div>

            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Pengguna Baru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $latestUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li><?php echo e($userItem->name); ?> (<?php echo e($userItem->role); ?>) - <?php echo e($userItem->created_at->diffForHumans()); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li>Tidak ada pengguna baru.</li>
                    <?php endif; ?>
                </ul>
            </div>

            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Portfolio Terbaru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $latestPortfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>"<?php echo e(Str::limit($portfolio->title, 30)); ?>" oleh <?php echo e($portfolio->user->name); ?> (<?php echo e($portfolio->created_at->diffForHumans()); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li>Tidak ada portfolio terbaru.</li>
                    <?php endif; ?>
                </ul>
            </div>

            
            <?php if(isset($latestWarnings)): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Peringatan Terbaru</h3>
                <ul class="list-disc pl-5 space-y-2 text-gray-700">
                    <?php $__empty_1 = true; $__currentLoopData = $latestWarnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>"<?php echo e(Str::limit($warning->subject, 30)); ?>" untuk <?php echo e($warning->user->name); ?> (<?php echo e($warning->created_at->diffForHumans()); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li>Tidak ada peringatan terbaru.</li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
            

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TUBES_WAD\Bentar-ya\tubes_part3\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>