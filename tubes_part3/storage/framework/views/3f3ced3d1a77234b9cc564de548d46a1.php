<?php $__env->startSection('title', 'Dashboard - Skill Exchange'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Create Post
        </button>
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <form method="GET" action="<?php echo e(route('dashboard')); ?>" class="flex-1">
            <div class="relative">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                        placeholder="Search posts..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </form>
        <form method="GET" action="<?php echo e(route('dashboard')); ?>">
            <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
            <select name="type" onchange="this.form.submit()" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="all" <?php echo e(request('type') == 'all' ? 'selected' : ''); ?>>All Posts</option>
                <option value="open" <?php echo e(request('type') == 'open' ? 'selected' : ''); ?>>Open for Help</option>
                <option value="need" <?php echo e(request('type') == 'need' ? 'selected' : ''); ?>>Need Help</option>
            </select>
        </form>
    </div>

    <?php if($posts->count() > 0): ?>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($post->title); ?></h3>
                    <p class="text-sm text-gray-600">
                        Posted by <?php echo e($post->user->name); ?> • <?php echo e($post->user->department); ?> • <?php echo e($post->user->batch); ?>

                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($post->type == 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                        <?php echo e($post->type == 'open' ? 'Open for Help' : 'Need Help'); ?>

                    </span>
                    <?php if($post->user_id == auth()->id()): ?>
                    <div class="relative">
                        <button onclick="togglePostMenu(<?php echo e($post->id); ?>)" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div id="postMenu<?php echo e($post->id); ?>" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <button onclick="editPost(<?php echo e($post->id); ?>)" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                            <button onclick="deletePost(<?php echo e($post->id); ?>)" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fas fa-trash mr-2"></i>Delete
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <p class="text-gray-700 mb-4"><?php echo e(Str::limit($post->description, 100)); ?></p>
            
            <div class="flex flex-wrap gap-2 mb-4">
                <?php $__currentLoopData = $post->skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    <?php echo e($skill->name); ?>

                </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="flex justify-between items-center border-t pt-4">
                <span class="text-sm text-gray-500">
                    <i class="fas fa-calendar mr-1"></i>
                    Deadline: <?php echo e($post->deadline->format('M d, Y')); ?>

                </span>
                <?php if($post->user_id != auth()->id()): ?> 
                    <a href="mailto:<?php echo e($post->user->email); ?>" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm inline-flex items-center">
                        <i class="fas fa-envelope mr-2"></i> <?php echo e($post->type == 'open' ? 'Contact' : 'Offer Help'); ?>

                    </a>
                <?php else: ?>
                    <span class="text-sm text-gray-500">Your Post</span>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="mt-8">
        <?php echo e($posts->links()); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-12">
        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No posts found</h3>
        <p class="text-gray-600 mb-6">
            <?php if(request('search')): ?>
                Try adjusting your search or filter to find what you're looking for.
            <?php else: ?>
                Create your first post to get started!
            <?php endif; ?>
        </p>
        <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
            <i class="fas fa-plus mr-2"></i>
            Create Post
        </button>
    </div>
    <?php endif; ?>
</div>

<div id="createModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create New Post</h3>
                <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="<?php echo e(route('posts.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="type" value="open" class="mr-2" checked>
                                <span>Open for Help</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="type" value="need" class="mr-2">
                                <span>Need Help</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="title" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" required 
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
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="date" name="deadline" id="deadline" required 
                                    min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="preference" class="block text-sm font-medium text-gray-700">Preference</label>
                            <select name="preference" id="preference" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeCreateModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Post</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Post Type</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="type" value="open" class="mr-2" id="editTypeOpen">
                                <span>Open for Help</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="type" value="need" class="mr-2" id="editTypeNeed">
                                <span>Need Help</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="editTitle" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" name="title" id="editTitle" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label for="editDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="editDescription" rows="4" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                        <div id="editSkills" class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded-md p-3">
                            <?php $__currentLoopData = $skills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="flex items-center">
                                <input type="checkbox" name="skills[]" value="<?php echo e($skill->id); ?>" class="mr-2">
                                <span class="text-sm"><?php echo e($skill->name); ?></span>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="editDeadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                            <input type="date" name="deadline" id="editDeadline" required 
                                    min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="editPreference" class="block text-sm font-medium text-gray-700">Preference</label>
                            <select name="preference" id="editPreference" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Post
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Post</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this post? This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="inline">
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

<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }
    
    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    function togglePostMenu(postId) {
        const menu = document.getElementById('postMenu' + postId);
        menu.classList.toggle('hidden');
    }
    
    function editPost(postId) {
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editForm').action = '/posts/' + postId;
    }
    
    function deletePost(postId) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = '/posts/' + postId;
    }
    
    window.onclick = function(event) {
        if (!event.target.matches('.fa-ellipsis-v')) {
            const menus = document.querySelectorAll('[id^="postMenu"]');
            menus.forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TUBES_WAD\Bentar-ya\tubes_part3\resources\views/dashboard.blade.php ENDPATH**/ ?>