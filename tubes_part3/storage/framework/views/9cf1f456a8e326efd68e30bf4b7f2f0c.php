 

<?php $__env->startSection('title', 'Admin - Manajemen Peringatan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Manajemen Peringatan</h1>
        
        
        <?php if(Route::has('admin.warnings.create')): ?>
            <a href="<?php echo e(route('admin.warnings.create')); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-300">
                <i class="fas fa-plus mr-2"></i> Buat Peringatan Baru
            </a>
        <?php endif; ?>
    </div>

    
    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo e(session('error')); ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Untuk Pengguna
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Oleh Admin
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipe Peringatan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subjek
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dibuat Pada
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $warnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($warning->id); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($warning->user->name ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($warning->admin->name ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e($warning->level ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(Str::limit($warning->title ?? '', 40)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo e(ucfirst($warning->status ?? 'N/A')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($warning->created_at->format('d M Y H:i') ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                            <?php if(Route::has('admin.warnings.show')): ?>
                                <a href="<?php echo e(route('admin.warnings.show', $warning->id)); ?>" class="text-blue-600 hover:text-blue-900 mr-2">Lihat</a>
                            <?php endif; ?>

                            <?php if(Route::has('admin.warnings.edit')): ?>
                                <a href="<?php echo e(route('admin.warnings.edit', $warning->id)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <?php endif; ?>

                            <?php if(Route::has('admin.warnings.destroy')): ?>
                                <form action="<?php echo e(route('admin.warnings.destroy', $warning->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peringatan ini? Aksi ini tidak dapat dibatalkan!');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Tidak ada peringatan yang ditemukan.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        
        <div class="p-4">
            <?php echo e($warnings->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TUBES_WAD\Bentar-ya\tubes_part3\resources\views/admin/warnings/index.blade.php ENDPATH**/ ?>