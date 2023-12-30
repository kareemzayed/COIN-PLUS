
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة المعاملات الخارجية</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        <?php if(checkPermission(55)): ?>
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء معاملة خارجية جديدة</button>
                        <?php endif; ?>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="<?php echo e(route('admin.external.transactions.search')); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="<?php echo e(isset($search['utr']) ? $search['utr'] : ''); ?>">
                                <input type="text" class="form-control" placeholder="اسم العميل" name="customar_name"
                                    value="<?php echo e(isset($search['customar_name']) ? $search['customar_name'] : ''); ?>">
                                <input type="date" class="form-control" placeholder="تاريخ المعاملة" name="date"
                                    value="<?php echo e(isset($search['date']) ? $search['date'] : ''); ?>">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>تفاصيل المعاملة</th>
                                    <th>المبلغ</th>
                                    <th>صافي الربح</th>
                                    <th>رقم المعاملة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $external_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $external_transactions->firstItem()); ?></td>
                                        <td><?php echo e($value->customar_name); ?></td>
                                        <td><?php echo e($value->details); ?></td>
                                        <td>
                                            <?php echo e(number_format($value->amount, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td>
                                            <?php echo e(number_format($value->charge, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td><?php echo e($value->utr); ?></td>
                                        <td>
                                            <?php echo e($value->created_at->format('m/d/Y h:i A')); ?>

                                        </td>
                                        <td style="width:12%">
                                            <?php if(checkPermission(57)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.external.transaction.update', $value->id)); ?>"
                                                    data-transaction="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-info update"><i class="fa fa-pen"></i></button>
                                            <?php endif; ?>
                                            <?php if(checkPermission(56)): ?>
                                                <button data-href="<?php echo e(route('admin.external.transaction.delete', $value->id)); ?>" data-transaction="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات خارجية</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($external_transactions->hasPages()): ?>
                        <div class="card-footer">
                            <?php echo e($external_transactions->links('backend.partial.paginate')); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Model -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo e(method_field('DELETE')); ?>


                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row col-md-12">
                            <p>هل أنت متأكد أنك تريد حذف هذه المعاملة؟ سيؤدي حذفها إلى استرجاع الأموال وإلغاء المعاملة بشكل
                                كامل.
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-danger" type="submit">حذف</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!------------------>

    <!-- Create And Update Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="post">
                <?php echo csrf_field(); ?>

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label for="customar_name">اسم العميل <span class="text-danger">*</span> </label>
                                <input type="text" id="customar_name" name="customar_name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">مبلغ المعاملة <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="charge">صافي الربح من هذه المعاملة <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="charge" id="charge" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="details">تفاصيل المعاملة</label>
                                <textarea name="details" id="details" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" id="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء معاملة خارجية جديدة")
                modal.find('input[name=customar_name]').val('')
                modal.find('input[name=amount]').val('')
                modal.find('input[name=charge]').val('')
                modal.find('textarea[name=details]').text('')
                modal.find('form').attr('action', '<?php echo e(route('admin.external.transaction.create')); ?>');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                const form = modal.find('form');
                form[0].reset();
                modal.find('.modal-title').text("تعديل المعاملة الخارجية رقم" + ' ' + ($(this)
                    .data('transaction').utr || ''));
                modal.find('input[name=customar_name]').val($(this).data('transaction').customar_name)
                modal.find('input[name=amount]').val($(this).data('transaction').amount)
                modal.find('input[name=charge]').val($(this).data('transaction').charge)
                modal.find('textarea[name=details]').text($(this).data('transaction').details)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف المعاملة الخارجية رقم" + ' ' + ($(this)
                    .data('transaction').utr || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/external_transaction/index.blade.php ENDPATH**/ ?>