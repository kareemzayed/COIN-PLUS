
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة الشيكات</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        <?php if(checkPermission(14)): ?>
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء شيك جديد</button>
                        <?php endif; ?>
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم الشيك" name="check_num"
                                    value="<?php echo e(isset($search['check_num']) ? $search['check_num'] : ''); ?>">
                                <input type="text" class="form-control" placeholder="اسم المستفيد"
                                    name="beneficiary_name"
                                    value="<?php echo e(isset($search['beneficiary_name']) ? $search['beneficiary_name'] : ''); ?>">
                                <input type="date" class="form-control" placeholder="تاريخ اصدار الشيك"
                                    name="issuance_date"
                                    value="<?php echo e(isset($search['issuance_date']) ? $search['issuance_date'] : ''); ?>">
                                <select class="form-control" name="status">
                                    <option disabled selected>حالة الشيك</option>
                                    <option value="">
                                        عرض الكل</option>
                                    <option value="1"
                                        <?php echo e(isset($search['status']) && $search['status'] == '1' ? 'selected' : ''); ?>>
                                        مدفوع</option>
                                    <option value="3"
                                        <?php echo e(isset($search['status']) && $search['status'] == '3' ? 'selected' : ''); ?>>
                                        غير مدفوع</option>
                                    <option value="2"
                                        <?php echo e(isset($search['status']) && $search['status'] == '2' ? 'selected' : ''); ?>>
                                        ملغي</option>
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
                                    <th>رقم الشيك</th>
                                    <th>تاريخ الإصدار</th>
                                    <th>اسم المستفيد</th>
                                    <th>بنك</th>
                                    <th>المبلغ</th>
                                    <th>تاريخ الإستحقاق</th>
                                    <th>حالة الشيك</th>
                                    <th>صورة الشيك</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $checks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($key + $checks->firstItem()); ?></td>
                                        <td><?php echo e($value->check_num); ?></td>
                                        <td><?php echo e(date('d/m/Y', strtotime($value->issuance_date))); ?></td>
                                        <td><?php echo e($value->beneficiary_name); ?></td>
                                        <td><?php echo e($value->bank_name); ?></td>
                                        <td><?php echo e(number_format($value->amount, 2) . ' ' . $value->currency); ?></td>
                                        <td>
                                            <?php echo e(date('d/m/Y', strtotime($value->due_date))); ?>

                                            <br>
                                            (<?php echo e(\Carbon\Carbon::parse($value->due_date)->diffForHumans()); ?>)
                                        </td>
                                        <td>
                                            <?php if($value->status == 3): ?>
                                                <span class="badge badge-warning">غير مدفوع</span>
                                            <?php elseif($value->status == 1): ?>
                                                <span class="badge badge-success">مدفوع</span>
                                            <?php elseif($value->status == 2): ?>
                                                <span class="badge badge-danger">ملغي</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($value->image): ?>
                                                <a href="<?php echo e(getFile('checks', $value->image, true)); ?>" download>
                                                    <img src='<?php echo e(getFile('checks', $value->image, true)); ?>'
                                                        style="width: 50px">
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width:11%">
                                            <?php if(checkPermission(15)): ?>
                                                <button data-href="<?php echo e(route('admin.checks.update', $value->id)); ?>"
                                                    data-check="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-primary update"><i class="fa fa-pen"></i></button>
                                            <?php endif; ?>

                                            <?php if(checkPermission(16)): ?>
                                                <button data-href="<?php echo e(route('admin.checks.delete', $value->id)); ?>"
                                                    data-check="<?php echo e($value); ?>"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي شيكات</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($checks->hasPages()): ?>
                        <div class="card-footer">
                            <?php echo e($checks->links('backend.partial.paginate')); ?>

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
                            <p>سيتم حذف كل ما يتعلق بهذا الشيك.
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
            <form action="" method="post" enctype="multipart/form-data">
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
                                <label for="check_num">رقم الشيك <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="check_num" name="check_num" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="issuance_date">تاريخ إصدار الشيك <span class="text-danger">*</span> </label>
                                <input type="date" name="issuance_date" id="issuance_date" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="beneficiary_name">اسم المستفيد <span class="text-danger">*</span> </label>
                                <input type="text" name="beneficiary_name" id="beneficiary_name" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="bank_name">اسم البنك <span class="text-danger">*</span> </label>
                                <input type="text" name="bank_name" id="bank_name" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="currency">عملة الشيك <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="currency" id="currency" class="form-control"
                                    placeholder="e.g: USD" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">مبلغ الشيك <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text set-currency"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="due_date">تاريخ إستحقاق الشيك <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="due_date" id="due_date" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="status">حالة الشيك <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="status" id="status">
                                    <option disabled selected value="">اختر حالة الشيك</option>
                                    <option value="1">مدفوع</option>
                                    <option value="3">غير مدفوع</option>
                                    <option value="2">ملغي</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-3">
                                <label class="col-form-label" for="image-upload">صورة الشيك</label>
                                <div id="image-preview" class="image-preview" style="">
                                    <label for="image-upload" id="image-label">اختر ملفًا</label>
                                    <input type="file" name="image" id="image-upload" />
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
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
        $(function() {
            'use strict'

            $(function() {
                $.uploadPreview({
                    input_field: "#image-upload",
                    preview_box: "#image-preview",
                    label_field: "#image-label",
                    label_default: "اختر ملفًا",
                    label_selected: "تحميل صورة",
                    no_label: false,
                    success_callback: null
                });
            })

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء شيك جديد")
                modal.find('input[name=check_num]').val('')
                modal.find('input[name=issuance_date]').val('')
                modal.find('input[name=beneficiary_name]').val('')
                modal.find('input[name=bank_name]').val('')
                modal.find('input[name=currency]').val('')
                modal.find('input[name=amount]').val('')
                modal.find('.set-currency').text('');
                modal.find('input[name=due_date]').val('')
                modal.find('input[name=image]').val('')
                modal.find('select[name=status]').val('')
                modal.find('textarea[name=note]').val('')
                modal.find('form').attr('action', "<?php echo e(route('admin.checks.create')); ?>");
                modal.find('#submit').show();
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("تعديل الشيك رقم" + ' ' + ($(this)
                    .data('check').check_num || ''));
                modal.find('input[name=check_num]').val($(this).data('check').check_num)
                modal.find('input[name=issuance_date]').val($(this).data('check').issuance_date)
                modal.find('input[name=beneficiary_name]').val($(this).data('check').beneficiary_name)
                modal.find('input[name=bank_name]').val($(this).data('check').bank_name)
                modal.find('input[name=currency]').val($(this).data('check').currency)
                modal.find('input[name=amount]').val($(this).data('check').amount)
                modal.find('input[name=due_date]').val($(this).data('check').due_date)
                modal.find('textarea[name=note]').val($(this).data('check').note)
                modal.find('.set-currency').text($(this).data('check').currency);
                modal.find('select[name=status]').val($(this).data('check').status)
                modal.find('form').attr('action', $(this).data('href'));
                modal.find('#submit').show();
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text(
                    "هل انت متأكد من حذف الشيك رقم" + ' ' + ($(this)
                        .data('check').check_num || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })

            $(document).ready(function() {
                $('#currency').on('input', function() {
                    var currencyValue = $(this).val();
                    $('.set-currency').text(currencyValue);
                });
            });
        })
    </script>
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
<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/checks/index.blade.php ENDPATH**/ ?>