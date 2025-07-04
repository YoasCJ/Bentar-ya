<?php $__env->startSection('title', 'Profile - Skill Exchange'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="text-center">
                    <div class="h-24 w-24 rounded-full bg-blue-500 flex items-center justify-center mx-auto mb-4 text-white text-2xl font-bold">
                        <?php echo e(substr($displayUser->name, 0, 1)); ?>

                    </div>
                    <h2 class="text-xl font-semibold text-gray-900"><?php echo e($displayUser->name); ?></h2>
                    <p class="text-gray-600"><?php echo e($displayUser->department); ?> • <?php echo e($displayUser->batch); ?></p>
                    <?php if($displayUser->description): ?>
                    <p class="mt-4 text-sm text-gray-700"><?php echo e($displayUser->description); ?></p>
                    <?php endif; ?>
                </div>
                
                <?php if($displayUser->id == auth()->id()): ?>
                <div class="mt-6">
                    <button onclick="openEditProfileModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profile
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Your Warnings</h3>
            <?php $__empty_1 = true; $__currentLoopData = $warnings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-pink-100 border-l-4 border-pink-500 text-pink-700 p-4 mb-2 rounded">
                    <p class="font-bold"><?php echo e($warning->subject); ?></p>
                    <p class="text-sm"><?php echo e($warning->description); ?></p>
                    <?php if($warning->admin): ?>
                        <p class="text-xs text-gray-600">Oleh Admin: <?php echo e($warning->admin->name); ?></p>
                    <?php endif; ?>
                    <?php if($warning->expires_at): ?>
                        <p class="text-xs text-gray-600">Kadaluarsa: <?php echo e($warning->expires_at->format('d M Y')); ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-gray-600">Status: <?php echo e(ucfirst($warning->status)); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="bg-gray-100 border-l-4 border-gray-500 text-gray-700 p-4 mb-2 rounded">
                    <p class="text-gray-500">Tidak ada peringatan untuk Anda.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Portfolio</h3>
                    <?php if($displayUser->id == auth()->id()): ?>
                    <button onclick="openCreatePortfolioModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Add Portfolio
                    </button>
                    <?php endif; ?>
                </div>
                
                <?php if($portfolios->count() > 0): ?>
                <div class="grid gap-6 md:grid-cols-2">
                    <?php $__currentLoopData = $portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $portfolio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-lg font-medium text-gray-900"><?php echo e($portfolio->title); ?></h4>
                            <?php if($displayUser->id == auth()->id()): ?>
                            <div class="flex space-x-2">
                                <button onclick="editPortfolio(<?php echo e($portfolio->id); ?>)" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deletePortfolio(<?php echo e($portfolio->id); ?>)" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-gray-700 text-sm mb-3"><?php echo e($portfolio->description); ?></p>
                        
                        <div class="flex flex-wrap gap-2 mb-3">
                            <?php $__currentLoopData = $portfolio->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo e($skill->name); ?>

                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                        <div class="flex space-x-3">
                            <?php if($portfolio->link): ?>
                            <a href="<?php echo e($portfolio->link); ?>" target="_blank" class="text-blue-600 hover:text-blue-900 text-sm">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                View Link
                            </a>
                            <?php endif; ?>
                            <?php if($portfolio->file_path): ?>
                            <a href="<?php echo e(Storage::url($portfolio->file_path)); ?>" target="_blank" class="text-green-600 hover:text-green-900 text-sm">
                                <i class="fas fa-file mr-1"></i>
                                View File
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <div class="text-center py-12">
                    <i class="fas fa-briefcase text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No portfolio items yet</h3>
                    <p class="text-gray-600 mb-6">
                        <?php if($displayUser->id == auth()->id()): ?>
                            Add your first portfolio item to showcase your work!
                        <?php else: ?>
                            <?php echo e($displayUser->name); ?> hasn't added any portfolio items yet.
                        <?php endif; ?>
                    </p>
                    <?php if($displayUser->id == auth()->id()): ?>
                    <button onclick="openCreatePortfolioModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Add Portfolio
                    </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if($displayUser->id == auth()->id()): ?>
<div id="editProfileModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Profile</h3>
                <button onclick="closeEditProfileModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label for="profileName" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="profileName" value="<?php echo e($displayUser->name); ?>" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="profileEmail" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="profileEmail" value="<?php echo e($displayUser->email); ?>" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="profileDepartment" class="block text-sm font-medium text-gray-700">Department</label>
                            <select name="department" id="profileDepartment" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Computer Science" <?php echo e($displayUser->department == 'Computer Science' ? 'selected' : ''); ?>>Computer Science</option>
                                <option value="Information Systems" <?php echo e($displayUser->department == 'Information Systems' ? 'selected' : ''); ?>>Information Systems</option>
                                <option value="Design" <?php echo e($displayUser->department == 'Design' ? 'selected' : ''); ?>>Design</option>
                                <option value="Business" <?php echo e($displayUser->department == 'Business' ? 'selected' : ''); ?>>Business</option>
                                <option value="Engineering" <?php echo e($displayUser->department == 'Engineering' ? 'selected' : ''); ?>>Engineering</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="profileBatch" class="block text-sm font-medium text-gray-700">Batch Year</label>
                            <select name="batch" id="profileBatch" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="2020" <?php echo e($displayUser->batch == '2020' ? 'selected' : ''); ?>>2020</option>
                                <option value="2021" <?php echo e($displayUser->batch == '2021' ? 'selected' : ''); ?>>2021</option>
                                <option value="2022" <?php echo e($displayUser->batch == '2022' ? 'selected' : ''); ?>>2022</option>
                                <option value="2023" <?php echo e($displayUser->batch == '2023' ? 'selected' : ''); ?>>2023</option>
                                <option value="2024" <?php echo e($displayUser->batch == '2024' ? 'selected' : ''); ?>>2024</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="profileDescription" class="block text-sm font-medium text-gray-700">About You</label>
                        <textarea name="description" id="profileDescription" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?php echo e($displayUser->description); ?></textarea>
                    </div>
                    
                    <div>
                        <label for="profilePassword" class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" id="profilePassword" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="profilePasswordConfirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="profilePasswordConfirmation" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditProfileModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="createPortfolioModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Add Portfolio Item</h3>
                <button onclick="closeCreatePortfolioModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="<?php echo e(route('portfolio.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label for="portfolioTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="portfolioTitle" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="portfolioDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="portfolioDescription" rows="3" required 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3">
                            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center">
                                <input type="checkbox" name="skills[]" value="<?php echo e($skill->id); ?>" class="mr-2">
                                <span class="text-sm"><?php echo e($skill->name); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <div>
                        <label for="portfolioLink" class="block text-sm font-medium text-gray-700">Link (optional)</label>
                        <input type="url" name="link" id="portfolioLink" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="https://example.com">
                    </div>
                    
                    <div>
                        <label for="portfolioFile" class="block text-sm font-medium text-gray-700">File (optional)</label>
                        <input type="file" name="file" id="portfolioFile" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (max 2MB)</p>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeCreatePortfolioModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Add Portfolio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editPortfolioModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Portfolio Item</h3>
                <button onclick="closeEditPortfolioModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editPortfolioForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label for="editPortfolioTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="editPortfolioTitle" required 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="editPortfolioDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="editPortfolioDescription" rows="3" required 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                        <div id="editPortfolioSkills" class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3">
                            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center">
                                <input type="checkbox" name="skills[]" value="<?php echo e($skill->id); ?>" class="mr-2">
                                <span class="text-sm"><?php echo e($skill->name); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <div>
                        <label for="editPortfolioLink" class="block text-sm font-medium text-gray-700">Link (optional)</label>
                        <input type="url" name="link" id="editPortfolioLink" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="editPortfolioFile" class="block text-sm font-medium text-gray-700">File (optional)</label>
                        <input type="file" name="file" id="editPortfolioFile" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-sm text-gray-500">Leave empty to keep current file</p>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditPortfolioModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Portfolio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deletePortfolioModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Portfolio Item</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this portfolio item? This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button onclick="closeDeletePortfolioModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <form id="deletePortfolioForm" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
    function openEditProfileModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }
    
    function closeEditProfileModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
    
    function openCreatePortfolioModal() {
        document.getElementById('createPortfolioModal').classList.remove('hidden');
    }
    
    function closeCreatePortfolioModal() {
        document.getElementById('createPortfolioModal').classList.add('hidden');
    }
    
    function closeEditPortfolioModal() {
        document.getElementById('editPortfolioModal').classList.add('hidden');
    }
    
    function closeDeletePortfolioModal() {
        document.getElementById('deletePortfolioModal').classList.add('hidden');
    }
    
    function editPortfolio(portfolioId) {
        document.getElementById('editPortfolioModal').classList.remove('hidden');
        document.getElementById('editPortfolioForm').action = '/portfolio/' + portfolioId;
    }
    
    function deletePortfolio(portfolioId) {
        document.getElementById('deletePortfolioModal').classList.remove('hidden');
        document.getElementById('deletePortfolioForm').action = '/portfolio/' + portfolioId;
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TUBES_WAD\Bentar-ya\tubes_part3\resources\views/profile.blade.php ENDPATH**/ ?>