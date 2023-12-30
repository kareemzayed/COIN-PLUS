

<?php $__env->startSection('content2'); ?>
    <div class="dashboard-body-part">
        <div class="row gy-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><?php echo e($pageTitle); ?></h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table site-table text-center">
                                <thead>
                                    <tr>
                                        <th class="col-1" scope="col">الإشعار</th>
                                        <th class="col-1" scope="col">التاريخ</th>
                                        <th class="col-1" scope="col">
                                            <a href="#" id="mark-all">
                                                تعليم الكل كمقروء
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="alert">
                                            <td data-caption="الإشعار" class="text-center"><?php echo e($noti->data['message']); ?></td>
                                            <td data-caption="التاريخ"><?php echo e($noti->created_at->format('d/m/Y g:i A')); ?></td>
                                            <td data-caption="تعليم الكل كمقروء">
                                                <a href="#" class="mark-as-read" data-id="<?php echo e($noti->id); ?>">
                                                    تعليم كمقروء
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور على إشعارات</td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        function sendMarkRequest(id = null) {
            return $.ajax("<?php echo e(route('user.markNotification')); ?>", {
                method: 'POST',
                data: {
                    _token : "<?php echo e(csrf_token()); ?>",
                    id
                }
            });
        }
        $(function() {
            $('.mark-as-read').click(function() {
                let request = sendMarkRequest($(this).data('id'),);
                request.done(() => {
                    $(this).parents('tr.alert').fadeOut(400, function(){
                        $(this).remove();
                    });
                });
            });
            $('#mark-all').click(function() {
                let request = sendMarkRequest();
                request.done(() => {
                    $('tr.alert').fadeOut(400 , function(){
                        $(this).remove();
                    });
                })
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(template().'layout.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/theme2/user/notifications.blade.php ENDPATH**/ ?>