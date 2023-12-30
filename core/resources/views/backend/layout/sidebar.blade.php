<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.home') }}">
                <img src="{{ getFile('logo', $general->logo, true) }}" alt="شعار" style="width:50px">
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown {{ menuActive('admin.home') }}">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i data-feather="home" style="margin-left: 10px; margin-right: 0px"></i><span>لوحة التحكم</span></a>
            </li>

            @if (checkPermission(2))
                <li class="sidebar-menu-caption">إدارة المستخدمين</li>
                <li
                    class="nav-item dropdown {{ menuActive(['admin.user', 'admin.user.details', 'admin.user.update', 'admin.user.balance.update', 'admin.user.mail', 'admin.user.search', 'admin.user.disabled', 'admin.user.filter', 'admin.user.account.statement']) }}">
                    <a href="{{ route('admin.user') }}" class="nav-link "><i data-feather="users"
                            style="margin-left: 10px; margin-right: 0px"></i>
                        <span>قائمة المستخدمين</span></a>
                </li>
            @endif

            @if (checkPermission(7) || checkPermission(9))
                <li class="sidebar-menu-caption">الدعم الفني</li>
                @if (checkPermission(7))
                    <li class="nav-item dropdown {{ menuActive(['admin.transactions.reports.index']) }}">
                        <a href="{{ route('admin.transactions.reports.index') }}" class="nav-link "><i
                                data-feather="alert-circle" style="margin-left: 10px; margin-right: 0px"></i>
                            <span>بلاغات المعاملات</span>
                            @if ($pendingReports > 0)
                                <span class="badge badge-danger mr-2">{{ $pendingReports ?? 0 }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                @if (checkPermission(9))
                    <li class="nav-item dropdown {{ menuActive('admin.ticket.index') }}">
                        <a href="{{ route('admin.ticket.index') }}" class="nav-link ">
                            <i data-feather="inbox" style="margin-left: 10px; margin-right: 0px"></i><span>الدعم
                                الفني</span>
                            @if ($numOfPendingTickets > 0)
                                <span class="badge badge-danger mr-2">{{ $numOfPendingTickets ?? 0 }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endif

            @if (checkPermission(12) || checkPermission(11))
                <li class="sidebar-menu-caption">تقارير</li>
                @if (checkPermission(11))
                    <li class="nav-item dropdown {{ menuActive(['admin.vouchers.fund']) }}">
                        <a href="{{ route('admin.vouchers.fund') }}" class="nav-link ">
                            <i data-feather="archive" style="margin-left: 10px; margin-right: 0px"></i><span>صندوق
                                السندات</span></a>
                    </li>
                @endif
                @if (checkPermission(12))
                    <li class="nav-item dropdown {{ menuActive(['admin.profits']) }}">
                        <a href="{{ route('admin.profits') }}" class="nav-link ">
                            <i data-feather="gift"
                                style="margin-left: 10px; margin-right: 0px"></i><span>الأرباح</span></a>
                    </li>
                @endif
            @endif

            @if (checkPermission(61))
                <li class="sidebar-menu-caption">إدارة المصروفات</li>
                <li
                    class="nav-item dropdown {{ menuActive(['admin.expenses.index', 'admin.expenses.search', 'admin.expenses.create', 'admin.expenses.update', 'admin.expenses.delete']) }}">
                    <a href="{{ route('admin.expenses.index') }}" class="nav-link "><i data-feather="dollar-sign"
                            style="margin-left: 10px; margin-right: 0px"></i>
                        <span>قائمة المصروفات</span></a>
                </li>
            @endif

            @if (checkPermission(13))
                <li class="sidebar-menu-caption">إدارة الشيكات</li>
                <li
                    class="nav-item dropdown {{ menuActive(['admin.checks.index', 'admin.checks.create', 'admin.checks.update', 'admin.checks.delete']) }}">
                    <a href="{{ route('admin.checks.index') }}" class="nav-link "><i data-feather="file-text"
                            style="margin-left: 10px; margin-right: 0px"></i>
                        <span>قائمة الشيكات</span></a>
                </li>
            @endif

            @if (checkPermission(65))
                <li class="sidebar-menu-caption">إدارة العملات</li>
                <li
                    class="nav-item dropdown {{ menuActive(['admin.currency.index', 'admin.currency.search', 'admin.currency.add', 'admin.currency.update']) }}">
                    <a href="{{ route('admin.currency.index') }}" class="nav-link "><i data-feather="command"
                            style="margin-left: 10px; margin-right: 0px"></i>
                        <span>قائمة العملات</span></a>
                </li>
            @endif

            @if (checkPermission(17))
                <li class="sidebar-menu-caption">إعدادات النظام</li>
                <li class="nav-item dropdown {{ $navGeneralSettingsActiveClass ?? '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="settings" style="margin-left: 10px; margin-right: 0px"></i>
                        <span>إعدادات عامة</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ $subNavGeneralSettingsActiveClass ?? '' }}">
                            <a class="nav-link" href="{{ route('admin.general.setting') }}">إعدادات عامة</a>
                        </li>
                        <li class="{{ $subNavCookieActiveClass ?? '' }}">
                            <a class="nav-link" href="{{ route('admin.general.cookie') }}">موافقة الكوكيز</a>
                        </li>
                        <li class="{{ $subNavRecaptchaActiveClass ?? '' }}">
                            <a class="nav-link" href="{{ route('admin.general.recaptcha') }}">المستخدم ليس روبوت</a>
                        </li>
                        <li class="{{ $subNavSEOManagerActiveClass ?? '' }}">
                            <a class="nav-link" href="{{ route('admin.general.seo') }}">مدير SEO العالمي</a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('admin.general.cacheclear') }}">مسح ذاكرة التخزين
                                المؤقت</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown {{ $permissionsActiveClass ?? '' }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i data-feather="lock" style="margin-left: 10px; margin-right: 0px"></i>
                        <span>الصلاحيات</span></a>
                    <ul class="dropdown-menu">
                        <li class="{{ $availavleRolesActiveClass ?? '' }}">
                            <a class="nav-link" href="{{ route('admin.availble.roles') }}">الأدوار المتاحة</a>
                        </li>
                        <li class="{{ $manageStaffsActiveClass ?? '' }}"><a class="nav-link"
                                href="{{ route('admin.staffs.list') }}">إدارة فريق العمل</a>
                        </li>
                    </ul>
                </li>
            @endif

            {{-- <li
                class="nav-item dropdown {{ menuActive(['admin.funds.index', 'admin.fund.create', 'admin.fund.update', 'admin.fund.add.balance', 'admin.fund.subtract.balance', 'admin.fund.update.transaction', 'admin.fund.delete.transaction', 'admin.fund.transactions']) }}">
                <a href="{{ route('admin.funds.index') }}" class="nav-link ">
                    <i data-feather="package"></i><span>{{ __('List Of Funds') }}</span></a>
            </li> --}}

            {{-- <li class="nav-item dropdown {{ menuActive(['admin.purchase.index', 'admin.purchase.search']) }}">
                <a href="{{ route('admin.purchase.index') }}" class="nav-link ">
                    <i data-feather="dollar-sign"></i><span>{{ __('Purchase') }}</span></a>
            </li> --}}

            {{-- <li
                class="nav-item dropdown {{ menuActive(['admin.sales.index', 'admin.sale.search', 'admin.sale.create']) }}">
                <a href="{{ route('admin.sales.index') }}" class="nav-link ">
                    <i data-feather="shopping-bag"></i><span>{{ __('Sales') }}</span></a>
            </li> --}}

            {{-- <li class="nav-item dropdown {{ menuActive(['admin.receipt.vouchers.index', 'receipt.voucher.create']) }}">
                <a href="{{ route('admin.receipt.vouchers.index') }}" class="nav-link ">
                    <i data-feather="credit-card"></i><span>{{ __('Receipt Voucher') }}</span></a>
            </li> --}}

            {{-- <li
                class="nav-item dropdown {{ menuActive(['admin.payment.vouchers.index', 'admin.payment.voucher.create', 'admin.payment.voucher.print']) }}">
                <a href="{{ route('admin.payment.vouchers.index') }}" class="nav-link ">
                    <i data-feather="credit-card"></i><span>{{ __('Payment Voucher') }}</span></a>
            </li> --}}

            {{-- <li class="nav-item dropdown {{ menuActive(['admin.transaction']) }}">
                <a href="{{ route('admin.transaction') }}" class="nav-link "><i
                        data-feather="list"></i><span>{{ __('Transactions Log') }}</span></a>
            </li> --}}

        </ul>
    </aside>
</div>
