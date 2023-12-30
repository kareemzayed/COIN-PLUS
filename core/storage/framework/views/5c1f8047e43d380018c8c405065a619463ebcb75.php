
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">المعاملات التي تمت علي صناديق الشركة</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-form">
                        <form method="GET" action="<?php echo e(route('admin.funds.transactions.search')); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="<?php echo e(isset($search['utr']) ? $search['utr'] : ''); ?>">
                                <input type="date" class="form-control" placeholder="تاريخ المعاملة" name="date"
                                    value="<?php echo e(isset($search['date']) ? $search['date'] : ''); ?>">
                                <select class="form-control" name="type">
                                    <option disabled selected value="">نوع المعاملة</option>
                                    <option value="add balance"
                                        <?php echo e(isset($search['type']) && $search['type'] == 'add balance' ? 'selected' : ''); ?>>
                                        إيداع رصيد</option>
                                    <option value="subtract balance"
                                        <?php echo e(isset($search['type']) && $search['type'] == 'subtract balance' ? 'selected' : ''); ?>>
                                        سحب رصيد</option>
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
                                    <th>اسم الصندوق</th>
                                    <th>نوع المعاملة</th>
                                    <th>المبلغ</th>
                                    <th>ملاحظة</th>
                                    <th>رقم المعاملة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $fund_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $fund_transactions->firstItem()); ?></td>
                                        <td><?php echo e(optional($value->fund)->name); ?></td>
                                        <td>
                                            <?php if($value->type == 'add balance'): ?>
                                                <span class="text-success">إيداع رصيد</span>
                                            <?php else: ?>
                                                <span class="text-danger">سحب رصيد</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e(number_format($value->amount, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td>
                                            <?php echo e($value->note ?? 'N/A'); ?>

                                        </td>
                                        <td>
                                            <?php echo e($value->utr); ?>

                                        </td>
                                        <td>
                                            <?php echo e($value->created_at->format('m/d/Y h:i A')); ?>

                                        </td>
                                        <td style="width: 11%">
                                            <?php if(checkPermission(42)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.fund.update.transaction', $value->id)); ?>"
                                                    data-trans="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-primary update"><i class="fa fa-pen"></i></button>
                                            <?php endif; ?>

                                            <?php if(checkPermission(43)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.fund.delete.transaction', $value->id)); ?>"
                                                    data-trans="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($fund_transactions->hasPages()): ?>
                        <div class="card-footer">
                            <?php echo e($fund_transactions->links('backend.partial.paginate')); ?>

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

    <!-- Update Add Balance Modal -->
    <div class="modal fade" id="updateAddBalanceModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
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
                                <label for="">المبلغ <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="text" name="amount" placeholder="0.00" class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="">ملاحظة</label>
                                <textarea name="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Sub Balance Modal -->
    <div class="modal fade" id="UpdateSubBalanceModel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
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
                                <label for="">المبلغ <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="text" name="amount" placeholder="0.00" class="form-control"
                                        required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="">ملاحظة</label>
                                <textarea name="note" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
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

            $('.update').on('click', function() {
                const transType = $(this).data('trans').type;
                const modal = transType === 'add balance' ? $('#updateAddBalanceModel') : $(
                    '#UpdateSubBalanceModel');

                modal.find('.modal-title').text("تعديل معاملة الصندوق رقم" + ' ' + ($(
                    this).data('trans').utr || ''));
                modal.find('input[name=amount]').val($(this).data('trans').amount)
                modal.find('input[name=cost]').val($(this).data('trans').cost)
                modal.find('textarea[name=note]').text($(this).data('trans').note)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف معاملة الصندوق رقم" + ' ' + ($(this)
                    .data('trans').utr || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
        })
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\CryptoPay\core\resources\views/backend/funds/funds_transactions.blade.php ENDPATH**/ ?>