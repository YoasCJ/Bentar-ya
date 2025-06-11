<?php $__env->startSection('title', 'Schedule - Skill Exchange'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Schedule</h1>
        <button onclick="openCreateScheduleModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            New Schedule
        </button>
    </div>

    <!-- Schedules Table -->
    <?php if($schedules->count() > 0): ?>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-blue-600 truncate">
                                    Session with <?php echo e($schedule->user1_id == auth()->id() ? $schedule->user2->name : $schedule->user1->name); ?>

                                </p>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                       <?php echo e($schedule->status == 'upcoming' ? 'bg-green-100 text-green-800' : 
                                          ($schedule->status == 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')); ?>">
                                        <?php echo e(ucfirst($schedule->status)); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?php echo e($schedule->scheduled_at->format('M d, Y')); ?>

                                    </p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo e($schedule->scheduled_at->format('H:i')); ?>

                                    </p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        <i class="fas fa-<?php echo e($schedule->method == 'online' ? 'video' : 'map-marker-alt'); ?> mr-1"></i>
                                        <?php echo e(ucfirst($schedule->method)); ?>

                                    </p>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                    <div class="flex space-x-2">
                                        <button onclick="editSchedule(<?php echo e($schedule->id); ?>)" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button onclick="deleteSchedule(<?php echo e($schedule->id); ?>)" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php if($schedule->notes): ?>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600"><?php echo e($schedule->notes); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        <?php echo e($schedules->links()); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-12">
        <i class="fas fa-calendar text-6xl text-gray-300 mb-4"></i>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No schedules yet</h3>
        <p class="text-gray-600 mb-6">Create your first schedule to start collaborating!</p>
        <button onclick="openCreateScheduleModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
            <i class="fas fa-plus mr-2"></i>
            Create Schedule
        </button>
    </div>
    <?php endif; ?>
</div>

<!-- Create Schedule Modal -->
<div id="createScheduleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create New Schedule</h3>
                <button onclick="closeCreateScheduleModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form action="<?php echo e(route('schedule.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label for="user2_id" class="block text-sm font-medium text-gray-700">Select User</label>
                        <select name="user2_id" id="user2_id" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose a user...</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->department); ?> - <?php echo e($user->batch); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="scheduled_date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="scheduled_date" id="scheduled_date" required 
                                   min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="scheduled_time" class="block text-sm font-medium text-gray-700">Time</label>
                            <input type="time" name="scheduled_time" id="scheduled_time" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label for="method" class="block text-sm font-medium text-gray-700">Method</label>
                        <select name="method" id="method" required 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Add any additional notes or agenda..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeCreateScheduleModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div id="editScheduleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Edit Schedule</h3>
                <button onclick="closeEditScheduleModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="editScheduleForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="editScheduledDate" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="scheduled_date" id="editScheduledDate" required 
                                   min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="editScheduledTime" class="block text-sm font-medium text-gray-700">Time</label>
                            <input type="time" name="scheduled_time" id="editScheduledTime" required 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="editMethod" class="block text-sm font-medium text-gray-700">Method</label>
                            <select name="method" id="editMethod" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="editStatus" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="editStatus" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="upcoming">Upcoming</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label for="editNotes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" id="editNotes" rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeEditScheduleModal()" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Schedule Modal -->
<div id="deleteScheduleModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Delete Schedule</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this schedule? This action cannot be undone.
                </p>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button onclick="closeDeleteScheduleModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <form id="deleteScheduleForm" method="POST" class="inline">
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
    // Schedule modal functions
    function openCreateScheduleModal() {
        document.getElementById('createScheduleModal').classList.remove('hidden');
    }
    
    function closeCreateScheduleModal() {
        document.getElementById('createScheduleModal').classList.add('hidden');
    }
    
    function closeEditScheduleModal() {
        document.getElementById('editScheduleModal').classList.add('hidden');
    }
    
    function closeDeleteScheduleModal() {
        document.getElementById('deleteScheduleModal').classList.add('hidden');
    }
    
    // Edit schedule
    function editSchedule(scheduleId) {
        document.getElementById('editScheduleModal').classList.remove('hidden');
        document.getElementById('editScheduleForm').action = '/schedule/' + scheduleId;
    }
    
    // Delete schedule
    function deleteSchedule(scheduleId) {
        document.getElementById('deleteScheduleModal').classList.remove('hidden');
        document.getElementById('deleteScheduleForm').action = '/schedule/' + scheduleId;
    }
    
    // Combine date and time for scheduled_at
    document.querySelector('#createScheduleModal form').addEventListener('submit', function(e) {
        const date = document.getElementById('scheduled_date').value;
        const time = document.getElementById('scheduled_time').value;
        
        if (date && time) {
            const scheduledAt = date + ' ' + time;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'scheduled_at';
            hiddenInput.value = scheduledAt;
            this.appendChild(hiddenInput);
        }
    });
    
    document.querySelector('#editScheduleModal form').addEventListener('submit', function(e) {
        const date = document.getElementById('editScheduledDate').value;
        const time = document.getElementById('editScheduledTime').value;
        
        if (date && time) {
            const scheduledAt = date + ' ' + time;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'scheduled_at';
            hiddenInput.value = scheduledAt;
            this.appendChild(hiddenInput);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\TUBES_WAD\Bentar-ya\tubes_part3\resources\views/schedule.blade.php ENDPATH**/ ?>