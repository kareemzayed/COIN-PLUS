
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة سندات الصرف</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        <?php if(checkPermission(46)): ?>
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء سند صرف جديد</button>
                        <?php endif; ?>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="<?php echo e(route('admin.payment.vouchers.search')); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم السند" name="receipt_number"
                                    value="<?php echo e(isset($search['receipt_number']) ? $search['receipt_number'] : ''); ?>">
                                <input type="text" class="form-control" placeholder="اسم العميل" name="customer_name"
                                    value="<?php echo e(isset($search['customer_name']) ? $search['customer_name'] : ''); ?>">
                                <input type="date" class="form-control" placeholder="Date" name="date"
                                    value="<?php echo e(isset($search['date']) ? $search['date'] : ''); ?>">
                                <select name="type" class="form-select form-control">
                                    <option disabled selected value="">طريقة استلام الأموال</option>
                                    <option value="1"
                                        <?php echo e(isset($search['type']) && $search['type'] == 1 ? 'selected' : ''); ?>>
                                        كاش (فوري)</option>
                                    <option value="2"
                                        <?php echo e(isset($search['type']) && $search['type'] == 2 ? 'selected' : ''); ?>>
                                        شيك</option>
                                </select>
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
                                    <th>رقم السند</th>
                                    <th>اسم العميل</th>
                                    <th>المبلغ</th>
                                    <th>طريقة استلام الأموال</th>
                                    <th>ذالك مقابل</th>
                                    <th>ملاحظة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $payment_vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $payment_vouchers->firstItem()); ?></td>
                                        <td><?php echo e($voucher->receipt_num); ?></td>
                                        <td><?php echo e($voucher->customar_name); ?></td>
                                        <td>
                                            <?php echo e(number_format($voucher->amount, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td>
                                            <?php if($voucher->receipt_type == 1): ?>
                                                كاش (فوري)
                                            <?php elseif($voucher->receipt_type == 2): ?>
                                                شيك
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($voucher->exchange_for); ?></td>
                                        <td><?php echo e($voucher->note); ?></td>
                                        <td>
                                            <?php echo e($voucher->created_at->format('m/d/Y h:i A')); ?>

                                        </td>
                                        <td style="width:14%">
                                            <?php if(checkPermission(30)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.payment.voucher.update', $voucher->id)); ?>"
                                                    data-voucher="<?php echo e($voucher); ?>"
                                                    class="btn btn-md btn-info update"><i class="fa fa-pen"></i></button>
                                            <?php endif; ?>

                                            <?php if(checkPermission(31)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.payment.voucher.delete', $voucher->id)); ?>"
                                                    data-voucher="<?php echo e($voucher); ?>"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php endif; ?>

                                            <?php if(checkPermission(53)): ?>
                                                <a href="<?php echo e(route('admin.payment.voucher.print', $voucher->id)); ?>"
                                                    class="btn btn-md btn-warning pdf" target="_blank"
                                                    style="width:36px; height:36px"><i class="fa fa-print"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي سندات صرف</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($payment_vouchers->hasPages()): ?>
                        <div class="card-footer">
                            <?php echo e($payment_vouchers->links('backend.partial.paginate')); ?>

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
                            <div class="form-group col-md-6 col-12">
                                <label for="customar_name">اسم العميل <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="customar_name" name="customar_name" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">المبلغ
                                    <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount_in_words">المبلغ بالكلمات
                                    <span class="text-danger">*</span> </label>
                                <input type="text" name="amount_in_words" id="amount_in_words" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="receipt_type">اختر طريقة استلام الأموال
                                    <span class="text-danger">*</span> </label>
                                <select name="receipt_type" id="receipt_type" class="form-control">
                                    <option value="0" disabled selected>اختر الطريقة</option>
                                    <option value="1">كاش (فوري)</option>
                                    <option value="2">شيك</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="check_no">رقم الشيك <span class="text-danger">*</span></label>
                                <input type="text" name="check_no" id="check_no" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="bank">اسم البنك <span class="text-danger">*</span></label> 
                                <input type="text" name="bank" id="bank" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="exchange_for">ذالك مقابل</label>
                                <textarea name="exchange_for" id="exchange_for" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="note">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" name="action" value="save" class="btn btn-primary">حفظ</button>
                        <?php if(checkPermission(53)): ?>
                            <button type="submit" name="action" value="saveAndPrint" class="btn btn-success">حفظ
                                وطباعة</button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        $(document).ready(function() {
            $('#receipt_type').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue == 1) { // Cash
                    $('#check_no, #bank').closest('.form-group').hide();
                } else if (selectedValue == 2) { // Check
                    $('#check_no, #bank').closest('.form-group').show();
                }
            });
        });
    </script>
    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء سند صرف جديد")
                modal.find('input[name=customar_name]').val('')
                modal.find('input[name=amount]').val('')
                modal.find('input[name=amount_in_words]').val('')
                modal.find('select[name=receipt_type]').val('0')
                $('#check_no, #bank').closest('.form-group').hide();
                modal.find('input[name=check_no]').val('')
                modal.find('input[name=bank]').val('')
                modal.find('textarea[name=exchange_for]').text('')
                modal.find('textarea[name=note]').text('')
                modal.find('form').attr('action', '<?php echo e(route('admin.payment.voucher.create')); ?>');
                modal.find('#submit').show();
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("تعديل سند الصرف رقم" + ' ' + ($(this)
                    .data('voucher').receipt_num || ''));
                modal.find('input[name=customar_name]').val($(this).data('voucher').customar_name)
                modal.find('input[name=amount]').val($(this).data('voucher').amount)
                modal.find('input[name=amount_in_words]').val($(this).data('voucher').amount_in_words)
                modal.find('select[name=receipt_type]').val($(this).data('voucher').receipt_type)
                if ($(this).data('voucher').receipt_type == 1) { // Cash
                    $('#check_no, #bank').closest('.form-group').hide();
                } else if ($(this).data('voucher').receipt_type == 2) { // Check
                    $('#check_no, #bank').closest('.form-group').show();
                }
                modal.find('input[name=check_no]').val($(this).data('voucher').check_no)
                modal.find('input[name=bank]').val($(this).data('voucher').bank)
                modal.find('textarea[name=exchange_for]').text($(this).data('voucher').exchange_for)
                modal.find('textarea[name=note]').text($(this).data('voucher').note)
                modal.find('form').attr('action', $(this).data('href'));
                modal.find('#submit').show();
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف سند الصرف رقم" + ' ' + ($(this)
                    .data('voucher').receipt_num || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/payment_vouchers/index.blade.php ENDPATH**/ ?>