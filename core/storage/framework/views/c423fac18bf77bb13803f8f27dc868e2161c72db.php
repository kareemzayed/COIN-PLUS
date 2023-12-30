

<?php $__env->startSection('content'); ?>
    <link rel="stylesheet"
        href="<?php echo e(asset('asset/admin/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css')); ?>" />
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>الأعدادات العامة</h1>
            </div>
            <div class="row">
                <div class="col-md-12 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="sitename">اسم الموقع</label>
                                        <input type="text" name="sitename" placeholder="اسم الموقع"
                                            class="form-control form_control" value="<?php echo e($general->sitename); ?>">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="site_currency">علمة الموقع</label>
                                        <input type="text" name="site_currency" class="form-control"
                                            placeholder="eg:- USD" value="<?php echo e($general->site_currency ?? ''); ?>">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="primary_color">اللون الأساسي للموقع</label>
                                        <div id="cp2" class="input-group" title="Using input value">
                                            <span class="input-group-append">
                                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                                            </span>
                                            <input type="text" name="primary_color_theme2" class="form-control input-lg"
                                                value="<?php echo e($general->primary_color_theme2); ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="signup_bonus">الرصيد الأفتتاحي عند إنشاء حساب جديد في الموقع</label>
                                        <input type="text" name="signup_bonus" placeholder="<?php echo app('translator')->get('Sign Up Bonus'); ?>"
                                            class="form-control form_control" value="<?php echo e($general->signup_bonus); ?>">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">Nexmo Key<a href="https://www.nexmo.com/" target="_blank">API
                                                Link</a></label>
                                        <input type="text" name="sms_username" class="form-control"
                                            placeholder="Sms API KEY" value="<?php echo e(env('NEXMO_KEY')); ?>">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">Nexmo Secret</label>
                                        <input type="text" name="sms_password" class="form-control"
                                            placeholder="Sms API Secret" value="<?php echo e(env('NEXMO_SECRET')); ?>">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="">السماع بالشاشة التمهيدية</label>
                                        <select name="preloader_status" id="" class="form-control">
                                            <option value="1" <?php echo e($general->preloader_status ? 'selected' : ''); ?>>
                                                نعم</option>
                                            <option value="0" <?php echo e($general->preloader_status ? '' : 'selected'); ?>>
                                                لا</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="sitename">نص حقوق النشر</label>
                                        <input type="text" name="copyright" class="form-control form_control"
                                            value="<?php echo e($general->copyright); ?>">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="" class="w-100">تفعيل التحقق عبر البريد الإلكتروني</label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="ev" type="checkbox"
                                                name="is_email_verification_on"
                                                <?php echo e($general->is_email_verification_on ? 'checked' : ''); ?>>
                                            <label class="custom-switch-btn" for="ev"></label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="" class="w-100">تفعيل التحقق عبر الرسائل القصيرة (SMS)</label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="sv" type="checkbox"
                                                name="is_sms_verification_on"
                                                <?php echo e($general->is_sms_verification_on ? 'checked' : ''); ?>>
                                            <label class="custom-switch-btn" for="sv"></label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="" class="w-100">تسجيل المستخدم</label>
                                        <div class="custom-switch custom-switch-label-onoff">
                                            <input class="custom-switch-input" id="ug_r" type="checkbox"
                                                name="user_reg" <?php echo e($general->user_reg ? 'checked' : ''); ?>>
                                            <label class="custom-switch-btn" for="ug_r"></label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">شعار الموقع</label>
                                        <div id="image-preview" class="image-preview"
                                            style="background-image:url(<?php echo e(getFile('logo', $general->logo, true)); ?>);">
                                            <label for="image-upload" id="image-label">اختر ملفًا</label>
                                            <input type="file" name="logo" id="image-upload" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">شعار الموقع الداكن</label>
                                        <div id="image-preview-dark" class="image-preview"
                                            style="background-image:url(<?php echo e(getFile('logo', $general->logo_dr, true)); ?>);">
                                            <label for="image-upload-dark" id="image-label-dark">اختر ملفًا</label>
                                            <input type="file" name="logo_dr" id="image-upload-dark" />
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">ايقونة الموقع</label>
                                        <div id="image-preview-icon" class="image-preview"
                                            style="background-image:url(<?php echo e(getFile('icon', $general->favicon, true)); ?>);">
                                            <label for="image-upload-icon" id="image-label-icon">اختر ملفًا</label>
                                            <input type="file" name="icon" id="image-upload-icon" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 mb-3">
                                        <label class="col-form-label">صورة تسجيل الدخول</label>
                                        <div id="image-preview-login" class="image-preview"
                                            style="background-image:url(<?php echo e(getFile('login', $general->login_image, true)); ?>);">
                                            <label for="image-upload-login" id="image-label-login">اختر ملفًا</label>
                                            <input type="file" name="login_image" id="image-upload-login" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary float-right">تحديث الأعدادات
                                            العامة</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .sp-replacer {
            padding: 0;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: 5px 0 0 5px;
            border-right: none;
        }

        .sp-preview {
            width: 100px;
            height: 46px;
            border: 0;
        }

        .sp-preview-inner {
            width: 110px;
        }

        .sp-dd {
            display: none;
        }

        .select2-container .select2-selection--single {
            height: 44px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 43px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 43px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('asset/admin/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')); ?>"></script>
    <script>
        $(function() {

            'use strict'

            $('#cp1').colorpicker();
            $('#cp2').colorpicker();

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label",
                label_default: "اختر ملفًا",
                label_selected: "تحميل صورة",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-dark",
                preview_box: "#image-preview-dark",
                label_field: "#image-label-dark",
                label_default: "اختر ملفًا",
                label_selected: "تحميل صورة",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-login",
                preview_box: "#image-preview-login",
                label_field: "#image-label-login",
                label_default: "اختر ملفًا",
                label_selected: "تحميل صورة",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-icon",
                preview_box: "#image-preview-icon",
                label_field: "#image-label-icon",
                label_default: "اختر ملفًا",
                label_selected: "تحميل صورة",
                no_label: false,
                success_callback: null
            });

            $.uploadPreview({
                input_field: "#image-upload-main",
                preview_box: "#image-preview-main",
                label_field: "#image-label-main",
                label_default: "اختر ملفًا",
                label_selected: "تحميل صورة",
                no_label: false,
                success_callback: null
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

<?php echo $__env->make('backend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\COIN_yas\core\resources\views/backend/setting/general_setting.blade.php ENDPATH**/ ?>