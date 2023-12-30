
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pb-3">
                <h3>قائمة معاملات الشراء المباشر</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        <?php if(checkPermission(74)): ?>
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء معاملة شراء مباشر جديدة</button>
                        <?php endif; ?>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="<?php echo e(route('admin.direct.purchase.search')); ?>">
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
                                    <th>العنصر التي تم شرائه</th>
                                    <th>من</th>
                                    <th>الي صندوق</th>
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
                                            <?php if($purchase->seller): ?>
                                                <a href="<?php echo e(route('admin.user.details', $purchase->seller->id)); ?>"
                                                    style="text-decoration: none; font-size: 14px">
                                                    <?php echo e(optional($purchase->seller)->fullname); ?>

                                                </a>
                                            <?php else: ?>
                                                <?php echo e($purchase->seller_on_way_name . ' (ONWAY) '); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.funds.index', ['name' => $purchase->fund->name])); ?>"
                                                style="text-decoration: none; font-size: 14px">
                                                <?php echo e(optional($purchase->fund)->name); ?>

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
                                            <?php if(checkPermission(75)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.direct.purchase.update', $purchase->id)); ?>"
                                                    data-purchase="<?php echo e($purchase); ?>"
                                                    class="btn btn-md btn-info update"><i class="fa fa-pen"></i></button>
                                            <?php endif; ?>
                                            <?php if(checkPermission(76)): ?>
                                                <button
                                                    data-href="<?php echo e(route('admin.direct.purchase.delete', $purchase->id)); ?>"
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
                                <input type="text" id="item_name" name="item_name" class="form-control"
                                    placeholder="العنصر التي تم شرائه" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="seller_type">نوع الشخص البائع <span class="text-danger">*</span> </label>
                                <select class="form-control" name="seller_type" id="seller_type" required>
                                    <option value="0" disabled selected>اختر نوع البائع</option>
                                    <option value="1">مسجل في النظام</option>
                                    <option value="2">غير مسجل في النظام (ONWAY)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12" id="sellerAccountNumberContainer"
                                style="display: none;">
                                <label for="seller_account_number">رقم حساب البائع
                                    <span class="text-danger">*</span> </label>
                                <input id="seller_account_number" name="seller_account_number" type="text"
                                    list="seller_list" class="form-control" placeholder="AC-xxxxx-99">
                                <datalist id="seller_list">
                                    <?php if(!empty($users)): ?>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($user->account_number); ?>">
                                                <?php echo e($user->fullname . ' - ' . $user->email . ' - ' . 'Balance: ' . number_format($user->balance, 2) . ' ' . $general->site_currency); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-6 col-12" id="sellerNameContainer" style="display: none;">
                                <label for="seller_name">اسم البائع <span class="text-danger">*</span> </label>
                                <input type="text" id="seller_name" name="seller_name" class="form-control"
                                    placeholder="اسم البائع">
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
                                <label for="fund_id">الي صندوق <span class="text-danger">*</span> </label>
                                <select class="form-control" name="fund_id" id="fund_id" required>
                                    <option value="0" disabled selected>اختر الصندوق</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $funds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($fund->id); ?>"><?php echo e($fund->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option disabled>لم يتم العثور علي اي صناديق</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="net_profits">صافي الربح من هذه المعاملة (للتوضيح فقط)</label>
                                <div class="input-group">
                                    <input type="text" name="net_profits" id="net_profits"
                                        placeholder="مبلغ الشراء - تكلفة الشراء" class="form-control" disabled>
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
        $(document).ready(function() {
            function toggleInputs(selectedOption) {
                $('#sellerAccountNumberContainer, #sellerNameContainer').hide();
                if (selectedOption === '1') {
                    $('#sellerAccountNumberContainer').show();
                } else if (selectedOption === '2') {
                    $('#sellerNameContainer').show();
                }
            }
            $('#seller_type').change(function() {
                var selectedOption = $(this).val();
                toggleInputs(selectedOption);
            });
            var defaultOption = $('#seller_type').val();
            toggleInputs(defaultOption);

            $(function() {
                'use strict'

                $('.add').on('click', function() {
                    const modal = $('#modelId');
                    modal.find('.modal-title').text("إنشاء معاملة شراء مباشر جديدة")
                    const form = modal.find('form');
                    form[0].reset();
                    modal.find('input[name=item_name]').val('')
                    modal.find('select[name=seller_type]').val("0")
                    toggleInputs(0);
                    modal.find('input[name=seller_account_number]').val('')
                    modal.find('input[name=seller_name]').val('')
                    modal.find('input[name=amount]').val('')
                    modal.find('input[name=purchase_cost]').val('')
                    modal.find('select[name=fund_id]').val("0")
                    modal.find('input[name=net_profits]').val('')

                    modal.find('form').attr('action',
                        '<?php echo e(route('admin.direct.purchase.create')); ?>');
                    modal.modal('show');
                })

                $('.update').on('click', function() {
                    const modal = $('#modelId');
                    const form = modal.find('form');
                    form[0].reset();

                    const purchaseData = $(this).data('purchase');
                    modal.find('.modal-title').text("تعديل معاملة الشراء المباشر رقم" + ' ' + (
                        purchaseData.utr || ''));
                    modal.find('input[name=item_name]').val(purchaseData.item_name);
                    modal.find('select[name=seller_type]').val(purchaseData.seller_type);
                    if (purchaseData.seller_type == 1) {
                        $('#sellerAccountNumberContainer').show();
                        modal.find('input[name=seller_account_number]').val(purchaseData
                            .seller.account_number);
                    } else if (purchaseData.seller_type == 2) {
                        $('#sellerNameContainer').show();
                        modal.find('input[name=seller_name]').val(purchaseData.seller_on_way_name);
                    }
                    modal.find('input[name=amount]').val(purchaseData.amount);
                    modal.find('input[name=purchase_cost]').val(purchaseData.purchase_cost);
                    modal.find('select[name=fund_id]').val(purchaseData.fund_id);
                    modal.find('input[name=net_profits]').val(purchaseData.charge);
                    modal.find('textarea[name=note]').val(purchaseData.note);
                    modal.find('form').attr('action', $(this).data('href'));
                    modal.modal('show');
                })

                $('.delete').on('click', function() {
                    const modal = $('#delete_modal')
                    modal.find('.modal-title').text("حذف معاملة الشراء المباشر رقم" + ' ' + ($(this)
                        .data('purchase').utr || ''));
                    modal.find('form').attr('action', $(this).data('href'))
                    modal.modal('show');
                })
            })
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const purchaseCostInput = document.getElementById('purchase_cost');
            const amount = document.getElementById('amount');
            const netProfitsInput = document.getElementById('net_profits');

            function updateNetProfits() {
                const purchaseCost = parseFloat(purchaseCostInput.value) || 0;
                const saleInvoice = parseFloat(amount.value) || 0;

                const netProfits = saleInvoice - purchaseCost;
                netProfitsInput.value = netProfits.toFixed(2);
            }

            purchaseCostInput.addEventListener('input', updateNetProfits);
            amount.addEventListener('input', updateNetProfits);
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/direct_purchases/index.blade.php ENDPATH**/ ?>