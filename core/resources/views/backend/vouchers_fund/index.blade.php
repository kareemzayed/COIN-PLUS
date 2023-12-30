@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="card-header-form">
                    <form method="GET" action="">
                        <div class="input-group">
                            <label style="font-size: 18px; margin: 15px 15px 20px 15px; font-weight: 700">شهر:</label>
                            <input type="month" class="form-control" placeholder="date" name="date"
                                value="{{ isset($search['date']) ? $search['date'] : '' }}">
                            <div class="input-group-btn">
                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="section-header pl-0">
                <h1 class="pl-0">صندوق السندات</h1>
            </div>
            <div class="row">
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card-stat gr-bg-1">
                        <div class="icon">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="content" style="font-size: 15px">
                            <p class="caption">الإيداعات (سندات القبض)</p>
                        </div>
                        @forelse($formattedResultsDeposits as $key => $value)
                            <a href="{{ route('admin.receipt.vouchers.index', ['currency_id' => $value['currency_id'], 'date' => $search['date']]) }}"
                                class="content mb-4 mt-2" style="text-decoration: none">
                                <p class="caption" style="font-size: 22px">
                                    {{ $key . ' (' . $value['count'] . ' سندات' . ') ' }}</p>
                                <h4 class="card-stat-amount">
                                    {{ number_format($value['totalAmount'], 2) . ' ' . $value['currency_code'] }}
                                </h4>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
                <div class="custom-xxxl-3 custom-xxl-6 col-md-6 col-sm-6 col-12 mb-4">
                    <div class="card-stat gr-bg-2">
                        <div class="icon">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="content" style="font-size: 15px">
                            <p class="caption">السحوبات (سندات الصرف)</p>
                        </div>
                        @forelse($formattedResultsWithdrawals as $key => $value)
                            <a href="{{ route('admin.payment.vouchers.index', ['currency_id' => $value['currency_id'], 'date' => $search['date']]) }}"
                                class="content mb-4 mt-2" style="text-decoration: none">
                                <p class="caption" style="font-size: 22px">
                                    {{ $key . ' (' . $value['count'] . ' سندات' . ') ' }}</p>
                                <h4 class="card-stat-amount">
                                    {{ number_format($value['totalAmount'], 2) . ' ' . $value['currency_code'] }}
                                </h4>
                            </a>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection