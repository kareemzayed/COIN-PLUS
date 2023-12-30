

<?php $__env->startSection('content2'); ?>
    <div class="dashboard-body-part">
        <div class="row">
            <div class="col-md-8 text-md-start text-center">
                <div class="d-flex align-items-center">
                    <h4><?php echo e($ticket->support_id); ?> - <?php echo e($ticket->subject); ?> </h4>
                </div>
            </div>
            <div class="col-md-4  text-md-end text-center">
                <a href="<?php echo e(route('user.ticket.index')); ?>" class="btn main-btn"> العودة إلى القائمة <i class="fas fa-arrow-left"></i></a>
            </div>
        </div>

        <div class="mt-4">
            <form action="<?php echo e(route('user.ticket.reply', $ticket->id)); ?>" enctype="multipart/form-data"
                method="post">
                <?php echo csrf_field(); ?>
                <div class="row justify-content-md-between">
                    <div class="col-md-12">
                        <div class="form-group ticket-comment-box">
                            <input type="hidden" name="ticket_id" value="<?php echo e($ticket->id); ?>">
                            <label for="exampleFormControlTextarea1">الرسالة</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="message"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mt-3">
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">اختر ملفًا</label>
                            <input type="file" name="file" id="image-upload" class="form-control" />
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn main-btn ticket-reply"><i
                                    class="fas fa-reply"></i>
                                رد
                            </button>
                    </div>
                </div>
            </form>
            <div class="ticket-reply-area mt-5">
                <?php $__empty_1 = true; $__currentLoopData = $ticket_reply; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="single-reply <?php echo e($ticket->admin_id != null ? 'admin-reply' : ''); ?>">
                        <span class="text-small text-secondary mb-2">رد في <?php echo e($ticket->created_at->format('d/m/Y g:i A')); ?></span>
                        <p>
                            <?php echo e($ticket->message); ?>

                        </p>
                        <?php if($ticket->file): ?>
                            <p class="mb-0 mt-2">
                                <a class="color-change" href="<?php echo e(route('user.ticket.download', $ticket->id)); ?>"> <i class="fas fa-cloud-download-alt"></i> عرض المرفقات</a>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    clickedButton.prop('disabled', true).html(
                        'جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make(template().'layout.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/theme2/user/ticket/show.blade.php ENDPATH**/ ?>