
<?php $__env->startSection('content2'); ?>
    <div class="dashboard-body-part">
        <div class="d-flex justify-content-end">
            <a href="<?php echo e(route('user.change.password')); ?>" class="btn main-btn mb-2">تغيير كلمة المرور</a>
        </div>
        <div class="card bg-second">
            <div class="card-body">
                <form action="<?php echo e(route('user.profileupdate')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-4 justify-content-center">
                            <div class="img-choose-div">
                                <label for="exampleInputEmail1"
                                    class="mb-1">صورة الملف الشخصي</label>
                                    <img class="file-id-preview" id="file-id-preview"
                                        src="<?php echo e(getFile('user', Auth::user()->image, true)); ?>" alt="pp">
                                <input type="file" name="image" id="imageUpload" class="upload"
                                    accept=".png, .jpg, .jpeg" hidden>
                                <label for="imageUpload"
                                    class="editImg btn main-btn w-100 mt-4">اختر ملفًا</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="update">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم الأول</label>
                                    <input type="text" class="form-control" name="fname"
                                        value="<?php echo e(Auth::user()->fname); ?>"
                                        placeholder="أدخل الاسم الأول">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">الاسم الأخير</label>
                                    <input type="text" class="form-control" name="lname"
                                        value="<?php echo e(Auth::user()->lname); ?>"
                                        placeholder="أدخل الاسم الأخير">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">رقم الحساب</label>
                                    <input type="text" class="form-control" name="account_number"
                                        value="<?php echo e(Auth::user()->account_number); ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">اسم المستخدم</label>
                                    <input type="text" class="form-control" name="username"
                                        value="<?php echo e(Auth::user()->username); ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">عنوان البريد الإلكتروني</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?php echo e(Auth::user()->email); ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">رقم الهاتف</label>
                                <input type="text" class="form-control" name="phone"
                                    value="<?php echo e(Auth::user()->phone); ?>" placeholder="رقم الهاتف">
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mb-3 ">
                                    <label>الدولة</label>
                                    <input type="text" name="country" class="form-control"
                                        value="<?php echo e(Auth::user()->address->country ?? ''); ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">المدينة</label>
                                    <input type="text" name="city" class="form-control form_control"
                                        value="<?php echo e(Auth::user()->address->city ?? ''); ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">الرمز البريدي</label>
                                    <input type="text" name="zip" class="form-control form_control"
                                        value="<?php echo e(Auth::user()->address->zip ?? ''); ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="">الولاية</label>
                                    <input type="text" name="state" class="form-control form_control"
                                        value="<?php echo e(Auth::user()->address->state ?? ''); ?>">
                                </div>
                            </div>
                            <button class="btn main-btn mt-2">تحديث الملف الشخصي</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        'use strict'
        document.getElementById("imageUpload").onchange = function() {
            show();
        };

        function show() {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-id-preview");
                preview.src = src;
                preview.style.display = "block";
                document.getElementById("file-id-preview").style.visibility = "visible";
            }
        }
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
<?php echo $__env->make(template().'layout.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/theme2/user/profile.blade.php ENDPATH**/ ?>