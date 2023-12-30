<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FundsController;
use App\Http\Controllers\Admin\ProfitsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DepositsAndWithdraws;
use App\Http\Controllers\Admin\ManageUserController;
use App\Http\Controllers\Admin\FundVoucherController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\PaymentVoucherController;
use App\Http\Controllers\Admin\ReceiptVoucherController;
use App\Http\Controllers\Admin\RolesPermissionController;
use App\Http\Controllers\Admin\ChecksManagementController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\TransactionReportsController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\DirectPurchaseController;
use App\Http\Controllers\Admin\ExternalTransactionController;
use App\Http\Controllers\Admin\TransactionsWithCurrencyController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Auth\ForgotPasswordController as AuthForgotPasswordController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    /* ADMIN AUTH */
    Route::get('login', [LoginController::class, 'loginPage'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
    Route::post('password/reset', [ForgotPasswordController::class, 'sendResetCodeEmail']);
    Route::post('password/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify.code');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset/change', [ResetPasswordController::class, 'reset'])->name('password.change');

    Route::middleware(['admin', 'auth:admin'])->group(function () {

        /* ADMIN */
        Route::get('dashboard', [HomeController::class, 'dashboard'])->name('home');
        Route::get('transaction-log/{date?}', [HomeController::class, 'transaction'])->name('transaction')->middleware('module:39');
        Route::get('/mark-as-read', [HomeController::class, 'markNotification'])->name('markNotification');

        /* TICKETS MANAGEMENT BY ADMIN */
        Route::get('pendingList', [AdminTicketController::class, 'pendingList'])->name('ticket.pendingList')->middleware('module:9');
        Route::post('ticket/reply', [AdminTicketController::class, 'reply'])->name('ticket.reply')->middleware('module:40');
        Route::resource('ticket', AdminTicketController::class);

        /* CURRENCIES MANAGEMENT BY ADMIN */
        Route::get('currencies', [CurrencyController::class, 'index'])->name('currency.index')->middleware('module:65');
        Route::get('currencies/search', [CurrencyController::class, 'index'])->name('currency.search')->middleware('module:65');
        Route::post('currencies/add', [CurrencyController::class, 'add'])->name('currency.add')->middleware('module:68');
        Route::post('currencies/update/{id}', [CurrencyController::class, 'update'])->name('currency.update')->middleware('module:66');

        /* FUNDS MANAGEMENT BY ADMIN */
        Route::get('funds', [FundsController::class, 'index'])->name('funds.index')->middleware('module:34');
        Route::post('fund/create', [FundsController::class, 'create'])->name('fund.create')->middleware('module:41');
        Route::post('fund/edit/{fund}', [FundsController::class, 'update'])->name('fund.update')->middleware('module:35');
        Route::post('fund/add-balance/{fund}', [FundsController::class, 'addBalance'])->name('fund.add.balance')->middleware('module:36');
        Route::post('fund/subtract-balance/{fund}', [FundsController::class, 'subtractBalance'])->name('fund.subtract.balance')->middleware('module:37');
        Route::get('fund-transactions/{id}', [FundsController::class, 'getFundTransactions'])->name('fund.transactions')->middleware('module:38');
        Route::get('funds-transactions/{date?}', [FundsController::class, 'fundsTransactions'])->name('funds.transactions')->middleware('module:38');
        Route::get('funds-transactions/search', [FundsController::class, 'fundsTransactions'])->name('funds.transactions.search')->middleware('module:38');
        Route::post('fund-transaction/update/{trans_id}', [FundsController::class, 'updateTransaction'])->name('fund.update.transaction')->middleware('module:42');
        Route::delete('fund-transaction/delete/{trans_id}', [FundsController::class, 'delete'])->name('fund.delete.transaction')->middleware('module:43');

        /* PURCHASE MANAGEMENT BY ADMIN */
        Route::get('purchase/{date?}', [PurchaseController::class, 'index'])->name('purchase.index')->middleware('module:18');
        Route::get('purchases/search', [PurchaseController::class, 'index'])->name('purchase.search')->middleware('module:18');
        Route::post('purchase/create', [PurchaseController::class, 'create'])->name('purchase.create')->middleware('module:19');
        Route::post('purchase/update/{id}', [PurchaseController::class, 'update'])->name('purchase.update')->middleware('module:20');
        Route::delete('purchase/delete/{id}', [PurchaseController::class, 'delete'])->name('purchase.delete')->middleware('module:21');

        /* DIRECT SALES MANAGEMENT BY ADMIN */
        Route::get('sales/{date?}', [SaleController::class, 'index'])->name('sales.index')->middleware('module:22');
        Route::get('sales/search', [SaleController::class, 'index'])->name('sale.search')->middleware('module:22');
        Route::post('sale/create', [SaleController::class, 'create'])->name('sale.create')->middleware('module:44');
        Route::delete('sale/delete/{id}', [SaleController::class, 'delete'])->name('sale.delete')->middleware('module:24');
        Route::post('sale/update/{id}', [SaleController::class, 'update'])->name('sale.update')->middleware('module:23');

        /* DIRECT BURCHASE MANAGEMENT BY ADMIN */
        Route::get('direct-purchase/{date?}', [DirectPurchaseController::class, 'index'])->name('direct.purchase.index')->middleware('module:73');
        Route::get('direct-purchase/search', [DirectPurchaseController::class, 'index'])->name('direct.purchase.search')->middleware('module:73');
        Route::post('direct-purchase/create', [DirectPurchaseController::class, 'create'])->name('direct.purchase.create')->middleware('module:74');
        Route::delete('direct-purchase/delete/{id}', [DirectPurchaseController::class, 'delete'])->name('direct.purchase.delete')->middleware('module:76');
        Route::post('direct-purchase/update/{id}', [DirectPurchaseController::class, 'update'])->name('direct.purchase.update')->middleware('module:75');

        /* RECEIPT VOUCHER MANAGEMENT BY ADMIN */
        Route::get('receipt-vouchers/{date?}', [ReceiptVoucherController::class, 'index'])->name('receipt.vouchers.index')->middleware('module:25');
        Route::get('receipt-vouchers/search', [ReceiptVoucherController::class, 'index'])->name('receipt.vouchers.search')->middleware('module:25');
        Route::post('receipt-voucher/create', [ReceiptVoucherController::class, 'create'])->name('receipt.voucher.create')->middleware('module:45');
        Route::post('receipt-voucher/update/{id}', [ReceiptVoucherController::class, 'update'])->name('receipt.voucher.update')->middleware('module:26');
        Route::delete('receipt-voucher/delete/{id}', [ReceiptVoucherController::class, 'delete'])->name('receipt.voucher.delete')->middleware('module:27');
        Route::get('receipt-voucher/print/{voucher}', [ReceiptVoucherController::class, 'print'])->name('receipt.voucher.print')->middleware('module:52');

        /* EXTERNAL TRANSACTIONS MANAGEMENT BY ADMIN */
        Route::get('external-transactions/{date?}', [ExternalTransactionController::class, 'index'])->name('external.transactions.index')->middleware('module:54');
        Route::get('external-transactions/search', [ExternalTransactionController::class, 'index'])->name('external.transactions.search')->middleware('module:54');
        Route::post('external-transaction/create', [ExternalTransactionController::class, 'create'])->name('external.transaction.create')->middleware('module:55');
        Route::post('external-transaction/update/{id}', [ExternalTransactionController::class, 'update'])->name('external.transaction.update')->middleware('module:57');
        Route::delete('external-transaction/delete/{id}', [ExternalTransactionController::class, 'delete'])->name('external.transaction.delete')->middleware('module:56');
       
        /* DEPOSITS AND WITHDRAWS MANAGEMENT BY ADMIN */
        Route::get('deposits-withdraws', [DepositsAndWithdraws::class, 'index'])->name('deposits.withdraws.index')->middleware('module:58');
        Route::get('deposits-withdraws/search', [DepositsAndWithdraws::class, 'index'])->name('deposits.withdraws.search')->middleware('module:58');
        Route::post('deposits-withdraws/update/{id}', [DepositsAndWithdraws::class, 'update'])->name('deposits.withdraws.update')->middleware('module:59');
        Route::delete('deposits-withdraws/delete/{id}', [DepositsAndWithdraws::class, 'delete'])->name('deposits.withdraws.delete')->middleware('module:60');

        /* PAYMENT VOUCHER MANAGEMENT BY ADMIN */
        Route::get('payment-vouchers/{date?}', [PaymentVoucherController::class, 'index'])->name('payment.vouchers.index')->middleware('module:29');
        Route::get('payment-vouchers/search', [PaymentVoucherController::class, 'index'])->name('payment.vouchers.search')->middleware('module:29');
        Route::post('payment-voucher/create', [PaymentVoucherController::class, 'create'])->name('payment.voucher.create')->middleware('module:46');
        Route::post('payment-voucher/update/{id}', [PaymentVoucherController::class, 'update'])->name('payment.voucher.update')->middleware('module:30');
        Route::delete('payment-voucher/delete/{id}', [PaymentVoucherController::class, 'delete'])->name('payment.voucher.delete')->middleware('module:31');
        Route::get('payment-voucher/print/{voucher}', [PaymentVoucherController::class, 'print'])->name('payment.voucher.print')->middleware('module:53');
        
        /* EXPENSES MANAGEMENT BY ADMIN */
        Route::get('expenses/{date?}', [ExpensesController::class, 'index'])->name('expenses.index')->middleware('module:61');
        Route::get('expenses/search', [ExpensesController::class, 'index'])->name('expenses.search')->middleware('module:61');
        Route::post('expenses/create', [ExpensesController::class, 'create'])->name('expenses.create')->middleware('module:64');
        Route::post('expenses/update/{id}', [ExpensesController::class, 'update'])->name('expenses.update')->middleware('module:62');
        Route::delete('expenses/delete/{id}', [ExpensesController::class, 'delete'])->name('expenses.delete')->middleware('module:63');

        /* TRANSACTION BY CURRENCIES MANAGEMENT BY ADMIN */
        Route::get('transactions-with-currencies/{date?}', [TransactionsWithCurrencyController::class, 'index'])->name('trans.with.currency.index')->middleware('module:69');
        Route::get('transactions-with-currencies/search', [TransactionsWithCurrencyController::class, 'index'])->name('trans.with.currency.search')->middleware('module:69');
        Route::post('transactions-with-currencies/create', [TransactionsWithCurrencyController::class, 'create'])->name('trans.with.currency.create')->middleware('module:70');
        Route::post('transactions-with-currencies/update/{id}', [TransactionsWithCurrencyController::class, 'update'])->name('trans.with.currency.update')->middleware('module:71');
        Route::delete('transactions-with-currencies/delete/{id}', [TransactionsWithCurrencyController::class, 'delete'])->name('trans.with.currency.delete')->middleware('module:72');

        /* VOUCHER FUND MANAGEMENT BY ADMIN */
        Route::get('vouchers-fund', [FundVoucherController::class, 'index'])->name('vouchers.fund')->middleware('module:11');

        /* TRANSACTION REPORTS MANAGEMENT BY ADMIN */
        Route::get('transaction-reports', [TransactionReportsController::class, 'index'])->name('transactions.reports.index')->middleware('module:7');
        Route::post('transaction-reports-reply/{id}', [TransactionReportsController::class, 'reply'])->name('transactions.reports.reply')->middleware('module:8');

        /* PROFITS LOG MANAGEMENT BY ADMIN */
        Route::get('profits', [ProfitsController::class, 'profits'])->name('profits')->middleware('module:12');

        /* USER MANAGEMENT BY ADMIN */
        Route::get('users', [ManageUserController::class, 'index'])->name('user')->middleware('module:2');
        Route::get('users/details/{user}', [ManageUserController::class, 'userDetails'])->name('user.details')->middleware('module:47');
        Route::post('users/update/{user}', [ManageUserController::class, 'userUpdate'])->name('user.update')->middleware('module:4');
        Route::post('users/balance/{user}', [ManageUserController::class, 'userBalanceUpdate'])->name('user.balance.update')->middleware('module:48');
        Route::post('users/mail/{user}', [ManageUserController::class, 'sendUserMail'])->name('user.mail')->middleware('module:49');
        Route::get('users/search', [ManageUserController::class, 'index'])->name('user.search')->middleware('module:2');
        Route::get('users/disabled', [ManageUserController::class, 'disabled'])->name('user.disabled')->middleware('module:2');
        Route::get('user/{status}', [ManageUserController::class, 'userStatusWiseFilter'])->name('user.filter')->middleware('module:2');
        Route::get('user-account-statement/{user}', [ManageUserController::class, 'userAccountStatement'])->name('user.account.statement')->middleware('module:3');
        Route::get('account-statement-pdf/{user}/{dates?}', [ManageUserController::class, 'userAccountStatementPDF'])->name('account.statement.pdf')->middleware('module:3');
        Route::get('login/user/{id}', [ManageUserController::class, 'loginAsUser'])->name('login.user')->middleware('module:5');

        /* CHECKS MANAGEMENT BY ADMIN */
        Route::get('checks', [ChecksManagementController::class, 'index'])->name('checks.index')->middleware('module:13');
        Route::post('check-create', [ChecksManagementController::class, 'create'])->name('checks.create')->middleware('module:14');
        Route::post('check-update/{id}', [ChecksManagementController::class, 'update'])->name('checks.update')->middleware('module:15');
        Route::delete('check-delete/{id}', [ChecksManagementController::class, 'delete'])->name('checks.delete')->middleware('module:16');

        /* PROFILE MANAGEMENT BY ADMIN */
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('profile', [AdminController::class, 'profileUpdate'])->name('profile.update');
        Route::post('change/password', [AdminController::class, 'changePassword'])->name('change.password');

        Route::middleware('module:17')->group(function () {
            /* LANGUAGE MANAGEMENT BY ADMIN */
            Route::get('language', [LanguageController::class, 'index'])->name('language.index');
            Route::post('language', [LanguageController::class, 'store']);
            Route::post('language/edit/{id}', [LanguageController::class, 'update'])->name('language.edit');
            Route::post('language/delete/{id}', [LanguageController::class, 'delete'])->name('language.delete');
            Route::get('language/translator/{lang}', [LanguageController::class, 'transalate'])->name('language.translator');
            Route::post('language/translator/{lang}', [LanguageController::class, 'transalateUpate']);
            Route::get('language/import', [LanguageController::class, 'import'])->name('language.import');
            Route::get('export/{lang}', [LanguageController::class, 'export'])->name('export');
            Route::post('import/{lang}', [LanguageController::class, 'import'])->name('import');
            Route::get('changeLang', [LanguageController::class, 'changeLang'])->name('changeLang');

            /* GENERAL SETTING BY ADMIN */
            Route::get('general/setting', [GeneralSettingController::class, 'index'])->name('general.setting');
            Route::post('general/setting', [GeneralSettingController::class, 'generalSettingUpdate']);
            Route::get('general/cookie/consent', [GeneralSettingController::class, 'cookieConsent'])->name('general.cookie');
            Route::post('general/cookie/consent', [GeneralSettingController::class, 'cookieConsentUpdate']);
            Route::get('general/google/recaptcha', [GeneralSettingController::class, 'recaptcha'])->name('general.recaptcha');
            Route::post('general/google/recaptcha', [GeneralSettingController::class, 'recaptchaUpdate']);
            Route::get('general/seo/manage', [GeneralSettingController::class, 'seoManage'])->name('general.seo');
            Route::post('general/seo/manage', [GeneralSettingController::class, 'seoManageUpdate']);
            Route::get('cacheclear', [GeneralSettingController::class, 'cacheClear'])->name('general.cacheclear');

            /* PERMISSIONS MANAGEMENT BY ADMIN */
            Route::get('availble-roles', [RolesPermissionController::class, 'index'])->name('availble.roles');
            Route::post('create-role', [RolesPermissionController::class, 'createRole'])->name('role.create');
            Route::post('update-role/{id}', [RolesPermissionController::class, 'updateRole'])->name('role.update');
            Route::delete('delete-role/{id}', [RolesPermissionController::class, 'roleDelete'])->name('role.delete');
            Route::get('staffs', [RolesPermissionController::class, 'staffList'])->name('staffs.list');
            Route::post('create-staff', [RolesPermissionController::class, 'createStaff'])->name('staff.create');
            Route::post('update-staff/{id}', [RolesPermissionController::class, 'updateStaff'])->name('staff.update');
            Route::get('login/staff/{id}', [RolesPermissionController::class, 'loginAsStaff'])->name('login.staff');
        });
    });
});


Route::name('user.')->group(function () {
    Route::middleware('guest')->group(function () {

        /* USER AUTH */
        Route::get('register', [RegisterController::class, 'index'])->name('register')->middleware('reg_off');
        Route::post('register', [RegisterController::class, 'register'])->middleware('reg_off');
        Route::get('login', [AuthLoginController::class, 'index'])->name('login');
        Route::post('login', [AuthLoginController::class, 'login']);
        Route::get('forgot/password', [AuthForgotPasswordController::class, 'index'])->name('forgot.password');
        Route::post('forgot/password', [AuthForgotPasswordController::class, 'sendVerification']);
        Route::get('verify/code', [AuthForgotPasswordController::class, 'verify'])->name('auth.verify');
        Route::post('verify/code', [AuthForgotPasswordController::class, 'verifyCode']);
        Route::get('reset/password', [AuthForgotPasswordController::class, 'reset'])->name('reset.password');
        Route::post('reset/password', [AuthForgotPasswordController::class, 'resetPassword']);
        Route::get('verify/email', [AuthLoginController::class, 'emailVerify'])->name('email.verify');
        Route::post('verify/email', [AuthLoginController::class, 'emailVerifyConfirm'])->name('email.verify');
    });

    Route::middleware(['auth', 'inactive', 'is_email_verified'])->group(function () {

        /* PROFILE SETTING BY USER */
        Route::get('profile/setting', [UserController::class, 'profile'])->name('profile');
        Route::post('profile/setting', [UserController::class, 'profileUpdate'])->name('profileupdate');
        Route::get('profile/change/password', [UserController::class, 'changePassword'])->name('change.password');
        Route::post('profile/change/password', [UserController::class, 'updatePassword'])->name('update.password');
        Route::get('logout', [RegisterController::class, 'signOut'])->name('logout');

        /* AUTH VERIFY BY USER */
        Route::get('authentication-verify', [AuthForgotPasswordController::class, 'verifyAuth'])->name('authentication.verify')->withoutMiddleware('is_email_verified');
        Route::post('authentication-verify/email', [AuthForgotPasswordController::class, 'verifyEmailAuth'])->name('authentication.verify.email')->withoutMiddleware('is_email_verified');
        Route::post('authentication-verify/sms', [AuthForgotPasswordController::class, 'verifySmsAuth'])->name('authentication.verify.sms')->withoutMiddleware('is_email_verified');

        /* TRANSACTIONS MANAGEMENT BY USER */
        Route::get('transaction/log', [UserController::class, 'transactionLog'])->name('transaction.log');
        Route::post('user/report-transaction/{transaction}', [UserController::class, 'reportTransaction'])->name('report.transaction');

        /* TICHETS MANAGEMENT BY USER */
        Route::resource('ticket', TicketController::class);
        Route::post('ticket/reply', [TicketController::class, 'reply'])->name('ticket.reply');
        Route::post('ticket/reply/status/change/{id}', [TicketController::class, 'statusChange'])->name('ticket.status-change');
        Route::get('ticket/status/{status}', [TicketController::class, 'ticketStatus'])->name('ticket.status');
        Route::get('ticket/attachement/{id}', [TicketController::class, 'ticketDownload'])->name('ticket.download');

        /* NOTIFICATION MANAGEMENT BY USER */
        Route::get('notificaitons', [UserController::class, 'notifications'])->name('notifications');
        Route::post('/mark-as-read', [UserController::class, 'markNotification'])->name('markNotification');
    });
});

Route::get('transaction-details/{id}', [ManageUserController::class, 'transactionDetails'])->name('admin.transaction.details');
Route::get('/', [SiteController::class, 'index'])->name('home');
Route::get('changeLang', [SiteController::class, 'changeLang'])->name('user.changeLang');
Route::post('subscribe', [DashboardController::class, 'subscribe'])->name('subscribe');