@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="card-header-form">
                    <form method="GET" action="{{ route('admin.profits') }}">
                        <div class="input-group">
                            <label style="font-size: 18px; margin: 15px 15px 20px 15px; font-weight: 700">الأرباح في
                                شهر:</label>
                            <input type="month" class="form-control" placeholder="date" name="date"
                                value="{{ $dateString }}">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-header pl-0">
                <h1 class="pl-0">{{ 'أرباح شهر' . ' ' . $dateString }}</h1>
            </div>
            <div class="row">
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-12 col-12 mb-4">
                    <div class="card-stat gr-bg-5">
                        <div class="icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="content">
                            <p class="caption" style="font-size: 15px">إجمالي الأرباح من جميع المعاملات</p>
                            <h4 class="card-stat-amount">
                                {{ number_format($totalProfits, 2) . ' ' . $general->site_currency }}<br />
                                {{ $totalTrans . ' ' . 'معاملة' }}
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(18) ? route('admin.purchase.index', $dateString) : '#' }}"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-1">
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="content" style="font-size: 15px">
                                <p class="caption">إجمالي الأرباح من معاملات الشراء من وسيط الي عميل</p>
                                <h4 class="card-stat-amount">
                                    @if (isset($groupedProfits['App\Models\Purchase']))
                                        {{ number_format($groupedProfits['App\Models\Purchase']['totalProfits'], 2) . ' ' . $general->site_currency }}<br />
                                        {{ $groupedProfits['App\Models\Purchase']['transactionCount'] . ' ' . 'معاملة' }}
                                    @else
                                        0.00 {{ $general->site_currency }}<br />
                                        0 {{ 'معاملة' }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(22) ? route('admin.sales.index', $dateString) : '#' }}"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-2">
                            <div class="icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي الأرباح من معاملات البيع المباشر
                                </p>
                                <h4 class="card-stat-amount">
                                    @if (isset($groupedProfits['App\Models\Sale']))
                                        {{ number_format($groupedProfits['App\Models\Sale']['totalProfits'], 2) . ' ' . $general->site_currency }}<br />
                                        {{ $groupedProfits['App\Models\Sale']['transactionCount'] . ' ' . 'معاملة' }}
                                    @else
                                        0.00 {{ $general->site_currency }}<br />
                                        0 {{ 'معاملة' }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(73) ? route('admin.direct.purchase.index', $dateString) : '#' }}"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-13">
                            <div class="icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي الأرباح من معاملات الشراء المباشر
                                </p>
                                <h4 class="card-stat-amount">
                                    @if (isset($groupedProfits['App\Models\DirectPurchase']))
                                        {{ number_format($groupedProfits['App\Models\DirectPurchase']['totalProfits'], 2) . ' ' . $general->site_currency }}<br />
                                        {{ $groupedProfits['App\Models\DirectPurchase']['transactionCount'] . ' ' . 'معاملة' }}
                                    @else
                                        0.00 {{ $general->site_currency }}<br />
                                        0 {{ 'معاملة' }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(54) ? route('admin.external.transactions.index', $dateString) : '#' }}"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-3">
                            <div class="icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي الأرباح من المعاملات الخارجية
                                </p>
                                <h4 class="card-stat-amount">
                                    @if (isset($groupedProfits['App\Models\ExternalTransaction']))
                                        {{ number_format($groupedProfits['App\Models\ExternalTransaction']['totalProfits'], 2) . ' ' . $general->site_currency }}<br />
                                        {{ $groupedProfits['App\Models\ExternalTransaction']['transactionCount'] . ' ' . 'معاملة' }}
                                    @else
                                        0.00 {{ $general->site_currency }}<br />
                                        0 {{ 'معاملة' }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(69) ? route('admin.trans.with.currency.index', $dateString) : '#' }}"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-11">
                            <div class="icon">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي الأرباح من المعاملات متعددة العملات
                                </p>
                                <h4 class="card-stat-amount">
                                    @if (isset($groupedProfits['App\Models\TransactionWithCurrency']))
                                        {{ number_format($groupedProfits['App\Models\TransactionWithCurrency']['totalProfits'], 2) . ' ' . $general->site_currency }}<br />
                                        {{ $groupedProfits['App\Models\TransactionWithCurrency']['transactionCount'] . ' ' . 'معاملة' }}
                                    @else
                                        0.00 {{ $general->site_currency }}<br />
                                        0 {{ 'معاملة' }}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(61) ? route('admin.expenses.index', $dateString) : '#' }}"
                        style="text-decoration: none">
                        <div class="card-stat gr-bg-12">
                            <div class="icon">
                                <i class="fas fa-money-bill-wave-alt"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">إجمالي المصروفات هذا الشهر
                                </p>
                                <h4 class="card-stat-amount">
                                    {{ number_format($totalAmountOfExpenses, 2) . ' ' . $general->site_currency }}<br />
                                    {{ $totalExpenses . ' ' . 'مصروف' }}
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <a href="{{ checkPermission(39) ? route('admin.transaction', $dateString) : '#' }}" style="text-decoration: none">
                        <div class="card-stat gr-bg-8">
                            <div class="icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="content">
                                <p class="caption" style="font-size: 15px">صافي الربح هذا الشهر
                                </p>
                                <h4 class="card-stat-amount">
                                    {{ number_format($totalNetProfits, 2) . ' ' . $general->site_currency }}<br />
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
