
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pb-3">
                <h3>قائمة معاملات الشراء من وسيط الي عميل</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        <?php if(checkPermission(19)): ?>
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء معاملة شراء جديدة</button>
                        <?php endif; ?>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="<?php echo e(route('admin.purchase.search')); ?>">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="<?php echo e(isset($search['utr']) ? $search['utr'] : ''); ?>">
                                <input type="text" class="form-control" placeholder="اسم العنصر" name="item"
                                    value="<?php echo e(isset($search['item']) ? $search['item'] : ''); ?>">
                                <input type="date" class="form-control" placeholder="تاريخ الشراء" name="date"
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
                                    <th>العنصر</th>
                                    <th>البائع (الوسيط)</th>
                                    <th>المشتري (العميل)</th>
                                    <th>المبلغ</th>
                                    <th>صافي الربح</th>
                                    <th>ملاحظة</th>
                                    <th>رقم المعاملة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $purchases->firstItem()); ?></td>
                                        <td><?php echo e($purchase->item_name); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.details', $purchase->seller->id)); ?>"
                                                style="text-decoration: none; font-size: 14px">
                                                <?php echo e(optional($purchase->seller)->fname . ' ' . optional($purchase->seller)->lname); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.details', $purchase->buyer->id)); ?>"
                                                style="text-decoration: none; font-size: 14px">
                                                <?php echo e(optional($purchase->buyer)->fname . ' ' . optional($purchase->buyer)->lname); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php echo e(number_format($purchase->amount, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td>
                                            <?php echo e(number_format($purchase->charge, 2) . ' ' . $general->site_currency); ?>

                                        </td>
                                        <td><?php echo e($purchase->note); ?></td>
                                        <td><?php echo e($purchase->utr); ?></td>
                                        <td>
                                            <?php echo e($purchase->created_at->format('m/d/Y h:i A')); ?>

                                        </td>
                                        <td style="width:12%">
                                            <?php if(checkPermission(20)): ?>
                                                <button data-href="<?php echo e(route('admin.purchase.update', $purchase->id)); ?>"
                                                    data-purchase="<?php echo e($purchase); ?>"
                                                    class="btn btn-md btn-info update"><i class="fa fa-pen"></i></button>
                                            <?php endif; ?>

                                            <?php if(checkPermission(21)): ?>
                                                <button data-href="<?php echo e(route('admin.purchase.delete', $purchase->id)); ?>"
                                                    data-purchase="<?php echo e($purchase); ?>"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات شراء</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($purchases->hasPages()): ?>
                        <div class="card-footer">
                            <?php echo e($purchases->links('backend.partial.paginate')); ?>

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
                                <label for="item_name">العنصر <span class="text-danger">*</span> </label>
                                <input type="text" id="item_name" name="item_name" class="form-control" placeholder="العنصر التي تم شرائه" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="seller_account_number">رقم حساب البائع او الوسيط
                                    <span class="text-danger">*</span> </label>
                                <input id="seller_account_number" name="seller_account_number" type="text"
                                    list="seller_list" class="form-control" placeholder="AC-xxxxx-99">
                                <datalist id="seller_list">
                                    <?php if(!empty($users)): ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->account_number); ?>">
                                                <?php echo e($user->fullname . ' - ' . $user->email . ' - ' . 'Balance: ' . number_format($user->balance, 2) . ' ' . $general->site_currency); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">مبلغ العنصر التي تم شرائة من التاجر <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="purchase_cost">تكلفة الشراء من التاجر<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="purchase_cost" id="purchase_cost" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="buyer_account_number">رقم حساب المشتري او العميل
                                    <span class="text-danger">*</span> </label>
                                <input id="buyer_account_number" name="buyer_account_number" type="text"
                                    list="buyer_list" class="form-control" placeholder="AC-xxxxx-99" required>
                                <datalist id="buyer_list">
                                    <?php if(!empty($users)): ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->account_number); ?>">
                                                <?php echo e($user->fullname . ' - ' . $user->email . ' - ' . 'Balance: ' . number_format($user->balance, 2) . ' ' . $general->site_currency); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="sale_invoice">تكلفة البيع او فاتورة البيع <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number" name="sale_invoice" id="sale_invoice" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="net_profits">صافي الربح من هذه المعاملة (للتوضيح فقط)</label>
                                <div class="input-group">
                                    <input type="text" name="net_profits" id="net_profits" placeholder="تكلفة البيع - تكلفة الشراء"
                                        class="form-control" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><?php echo e($general->site_currency); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="note">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
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
        document.addEventListener('DOMContentLoaded', function() {
            const purchaseCostInput = document.getElementById('purchase_cost');
            const saleInvoiceInput = document.getElementById('sale_invoice');
            const netProfitsInput = document.getElementById('net_profits');

            function updateNetProfits() {
                const purchaseCost = parseFloat(purchaseCostInput.value) || 0;
                const saleInvoice = parseFloat(saleInvoiceInput.value) || 0;

                const netProfits = saleInvoice - purchaseCost;
                netProfitsInput.value = netProfits.toFixed(2);
            }

            purchaseCostInput.addEventListener('input', updateNetProfits);
            saleInvoiceInput.addEventListener('input', updateNetProfits);
        });
    </script>

    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء معاملة شراء جديدة")
                const form = modal.find('form');
                form[0].reset();
                modal.find('form').attr('action', '<?php echo e(route('admin.purchase.create')); ?>');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                const form = modal.find('form');
                form[0].reset();

                modal.find('.modal-title').text("تعديل معاملة الشراء رقم" + ' ' + ($(this)
                    .data('purchase').utr || ''));
                modal.find('input[name=item_name]').val($(this).data('purchase').item_name)
                modal.find('input[name=buyer_account_number]').val($(this).data('purchase').buyer
                    .account_number)
                modal.find('input[name=amount]').val($(this).data('purchase').amount)
                modal.find('input[name=purchase_cost]').val($(this).data('purchase').purchase_cost)
                modal.find('input[name=seller_account_number]').val($(this).data('purchase').seller
                    .account_number)
                modal.find('input[name=sale_invoice]').val($(this).data('purchase').sales_cost)
                const purchaseCost = parseFloat($(this).data('purchase').purchase_cost) || 0;
                const saleInvoice = parseFloat($(this).data('purchase').sales_cost) || 0;
                const netProfits = saleInvoice - purchaseCost;
                modal.find('input[name=net_profits]').val(netProfits.toFixed(2));
                modal.find('textarea[name=note]').text($(this).data('purchase').note)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف معاملة الشراء رقم" + ' ' + ($(this)
                    .data('purchase').utr || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
        })
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/purchases/index.blade.php ENDPATH**/ ?>