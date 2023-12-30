<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> <?php echo e(__('Account Statement')); ?> <?php echo e($user->fullname); ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(getFile('icon', $general->favicon, true)); ?>">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(255, 243, 243);
            margin: 0;
            padding: 0;
        }

        html,
        body {
            width: 100%;
        }

        @page  {
            margin: 0;
        }

        .nav {
            width: 100%;
            height: 15px;
            background-color: #363653;
        }

        .invoice-box {
            max-width: 100%;
            margin: auto;
            padding: 40px;
            font-size: 16px;
            line-height: 24px;
            color: #555;
            background-color: rgb(255, 243, 243);
        }

        .no-print {
            width: 50%;
            margin: 0 auto;
            position: fixed;
            bottom: 20px;
            left: 25%;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 12px;
        }

        .no-print:hover {
            background-color: #45a049;
        }

        @media  print {
            .no-print {
                display: none;
            }
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box .trans-table td {
            padding: 5px;
            vertical-align: middle;
            border: 1px solid #363653;
            text-align: center;
        }

        .invoice-box table tr.heading td {
            background: #363653;
            border-bottom: 1px solid #363653;
            font-weight: bold;
            font-size: 12px;
            color: white;
        }

        .invoice-box .info-table {
            font-size: 13px;
        }

        .invoice-box .info-table td {
            vertical-align: middle;
            text-align: center;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #363653;
            font-size: 12px;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #363653;
            font-weight: bold;
        }

        /** RTL **/
        body.rtl {
            direction: rtl;
        }
    </style>
</head>

<body class="rtl">
    <div class="nav"></div>
    <div class="invoice-box">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; align-content: flex-start;">
            <a style="display: inline-block;">
                <img src="<?php echo e(getFile('logo', $general->logo_dr, true)); ?>" style="width: 150px;" />
            </a>
        </div>

        <div style="text-align: center; padding-top: 30px; padding-bottom: 10px;">
            <div>
                <span style="font-weight: 800; font-size:20px"> كشف حساب</span>
            </div>
        </div>

        <table style="margin-top: 20px; margin-bottom: 30px" class="info-table" border="0">
            <tr class="information">
                <td colspan="2">
                    <table border="0" style="border: none; width: 100%;">
                        <tr>
                            <td style="width: 60%; border: none;">
                                <?php echo e($user->fullname); ?><br />
                                هاتف العميل ( <?php echo e($user->phone); ?> )<br />
                                رقم حساب العميل ( <?php echo e($user->account_number); ?> )<br />
                            </td>
                            <td style="border: none;">
                                <?php if(isset($dates[0])): ?>
                                    تاريخ إصدار الكشف <?php echo e($dates[0]->format('Y/m/d')); ?><br />
                                <?php endif; ?>
                                <?php if(isset($dates[1])): ?>
                                    حتي تاريخ <?php echo e($dates[1]->format('Y/m/d')); ?><br />
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="trans-table">
            <tr class="heading">
                <td style="width: 20%;">التاريخ</td>
                <td>رقم المعاملة</td>
                <td>العنصر</td>
                <td>نوع المعاملة</td>
                <td>إيداع</td>
                <td>سحب</td>
                <td>الرصيد المتحرك</td>
            </tr>

            <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="item">
                    <td><?php echo e(date('Y/m/d', strtotime($value->created_at))); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.transaction.details', $value->id)); ?>"
                            style="text-decoration: none; color: #555" target="_blank">
                            <?php echo e($value->transactional->utr ?? __('N/A')); ?>

                        </a>
                    </td>
                    <td>
                        <?php if(
                            $value->transactional_type == 'App\Models\Purchase' ||
                                $value->transactional_type == 'App\Models\Sale' ||
                                $value->transactional_type == 'App\Models\DirectPurchase'): ?>
                            <?php echo e(optional($value->transactional)->item_name ?? 'N/A'); ?>

                        <?php elseif(
                            $value->transactional_type == 'App\Models\UpdateUsersBalance' ||
                                $value->transactional_type == 'App\Models\FundsTransaction' ||
                                $value->transactional_type == 'App\Models\ExternalTransaction'): ?>
                            <?php echo e('N/A'); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($value->transactional_type == 'App\Models\UpdateUsersBalance' && $value->transactional->type == 'add'): ?>
                            إيداع إداري
                        <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance' && $value->transactional->type == 'minus'): ?>
                            سحب إداري
                        <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->buyer == $user): ?>
                            شراء من تاجر
                        <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->seller == $user): ?>
                            بيع الي تاجر
                        <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                            بيع مباشر الي عميل
                        <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                            شراء مباشر
                        <?php endif; ?>
                    </td>

                    <?php if($value->transactional_type == 'App\Models\UpdateUsersBalance' && $value->transactional->type == 'add'): ?>
                        <td><?php echo e(number_format($value->amount, 2)); ?> <?php echo e($general->site_currency); ?></td>
                        <td></td>
                    <?php elseif($value->transactional_type == 'App\Models\UpdateUsersBalance' && $value->transactional->type == 'minus'): ?>
                        <td></td>
                        <td><?php echo e(number_format($value->amount, 2)); ?> <?php echo e($general->site_currency); ?></td>
                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->buyer == $user): ?>
                        <td></td>
                        <td><?php echo e(number_format($value->transactional->sales_cost, 2)); ?> <?php echo e($general->site_currency); ?>

                        </td>
                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->seller == $user): ?>
                        <td><?php echo e(number_format($value->transactional->purchase_cost, 2)); ?> <?php echo e($general->site_currency); ?>

                        </td>
                        <td></td>
                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                        <td></td>
                        <td><?php echo e(number_format($value->transactional->sales_cost, 2)); ?> <?php echo e($general->site_currency); ?>

                        </td>
                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                        <td><?php echo e(number_format($value->transactional->purchase_cost, 2)); ?> <?php echo e($general->site_currency); ?></td>
                        <td></td>
                    <?php endif; ?>

                    <?php if($value->transactional_type == 'App\Models\UpdateUsersBalance'): ?>
                        <td><?php echo e(number_format($value->transactional->floating_balance, 2)); ?>

                            <?php echo e($general->site_currency); ?></td>
                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->buyer == $user): ?>
                        <td><?php echo e(number_format($value->transactional->buyer_floating_balance, 2)); ?>

                            <?php echo e($general->site_currency); ?></td>
                    <?php elseif($value->transactional_type == 'App\Models\Purchase' && $value->transactional->seller == $user): ?>
                        <td><?php echo e(number_format($value->transactional->seller_floating_balance, 2)); ?>

                            <?php echo e($general->site_currency); ?></td>
                    <?php elseif($value->transactional_type == 'App\Models\Sale'): ?>
                        <td><?php echo e(number_format($value->transactional->buyer_floating_balance, 2)); ?>

                            <?php echo e($general->site_currency); ?></td>
                    <?php elseif($value->transactional_type == 'App\Models\DirectPurchase'): ?>
                        <td><?php echo e(number_format($value->transactional->seller_floating_balance, 2)); ?>

                            <?php echo e($general->site_currency); ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
    <button class="no-print" onclick="printDocument()">طباعة</button>
    <script>
        function printDocument() {
            window.print();
        }
    </script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\COIN+\core\resources\views/backend/users/account_statement_pdf.blade.php ENDPATH**/ ?>