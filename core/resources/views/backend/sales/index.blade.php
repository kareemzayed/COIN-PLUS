@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة معاملات البيع المباشر</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        @if (checkPermission(44))
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء معاملة بيع جديدة</button>
                        @endif
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.sale.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم المعاملة" name="utr"
                                    value="{{ isset($search['utr']) ? $search['utr'] : '' }}">
                                <input type="text" class="form-control" placeholder="اسم العنصر" name="item_name"
                                    value="{{ isset($search['item_name']) ? $search['item_name'] : '' }}">
                                <input type="date" class="form-control" placeholder="تاريخ المعاملة" name="date"
                                    value="{{ isset($search['date']) ? $search['date'] : '' }}">
                                <select name="fund_id" class="form-select form-control">
                                    <option disabled selected>صندوق الشركة</option>
                                    <option value="">عرض الكل</option>
                                    @forelse($funds as $fund)
                                        <option value="{{ $fund->id }}"
                                            {{ isset($search['fund_id']) && $search['fund_id'] == $fund->id ? 'selected' : '' }}>
                                            {{ $fund->name }}</option>
                                    @empty
                                        <option disabled>لم يتم العثور علي صناديق</option>
                                    @endforelse
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
                                    <th>العنصر</th>
                                    <th>من صندوق</th>
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
                                @forelse ($sales as $key => $sale)
                                    <tr>
                                        <td>{{ $key + $sales->firstItem() }}</td>
                                        <td>{{ $sale->item_name }}</td>
                                        <td>
                                            {{ optional($sale->fund)->name }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.user.details', $sale->buyer->id) }}"
                                                style="text-decoration: none; font-size: 14px">
                                                {{ optional($sale->buyer)->fname . ' ' . optional($sale->buyer)->lname }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ number_format($sale->amount, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>
                                            {{ number_format($sale->charge, 2) . ' ' . $general->site_currency }}
                                        </td>
                                        <td>{{ $sale->note }}</td>
                                        <td>{{ $sale->utr }}</td>
                                        <td>
                                            {{ $sale->created_at->format('m/d/Y h:i A') }}
                                        </td>
                                        <td style="width:12%">
                                            @if (checkPermission(23))
                                                <button data-href="{{ route('admin.sale.update', $sale->id) }}"
                                                    data-sale="{{ $sale }}" class="btn btn-md btn-info update"><i
                                                        class="fa fa-pen"></i></button>
                                            @endif

                                            @if (checkPermission(24))
                                                <button data-href="{{ route('admin.sale.delete', $sale->id) }}"
                                                    data-sale="{{ $sale }}" class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي معاملات بيع</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($sales->hasPages())
                        <div class="card-footer">
                            {{ $sales->links('backend.partial.paginate') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Model -->
    <div class="modal fade" id="delete_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST">
                @csrf
                {{ method_field('DELETE') }}

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
                @csrf

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
                                    placeholder="العنصر التي تم بيعه" required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="fund_id">من صندوق الشركة
                                    <span class="text-danger">*</span> </label>
                                <select name="fund_id" id="fund_id" class="form-control">
                                    <option value="0" disabled selected>اختر الصندوق</option>
                                    @forelse($funds as $fund)
                                        <option value="{{ $fund->id }}">{{ $fund->name . ' - الرصيد الحالي: ' . number_format($fund->balance, 2) . ' ' . $general->site_currency }}</option>
                                    @empty
                                        <option disabled>لم يتم العثور علي صناديق</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="buyer_account_number">رقم حساب المشتري او العميل
                                    <span class="text-danger">*</span> </label>
                                <input id="buyer_account_number" name="buyer_account_number" type="text"
                                    list="buyer_list" class="form-control" placeholder="AC-xxxxx-99" required>
                                <datalist id="buyer_list">
                                    @if (!empty($users))
                                        @foreach ($users as $user)
                                            <option value="{{ $user->account_number }}">
                                                {{ $user->fullname . ' - ' . $user->email . ' - ' . 'Balance: ' . number_format($user->balance, 2) . ' ' . $general->site_currency }}</option>
                                        @endforeach
                                    @endif
                                </datalist>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">مبلغ البيع <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="sale_cost">تكلفة البيع الي العميل<span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="sale_cost" id="sale_cost" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label for="net_profits">صافي الربح من هذه المعاملة (للتوضيح فقط)</label>
                                <div class="input-group">
                                    <input type="text" name="net_profits" id="net_profits"
                                        placeholder="تكلفة البيع - مبلغ البيع" class="form-control" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $general->site_currency }}</span>
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
@endsection


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saleCost = document.getElementById('sale_cost');
            const saleAmount = document.getElementById('amount');
            const netProfitsInput = document.getElementById('net_profits');

            function updateNetProfits() {
                const sale_cost = parseFloat(saleCost.value) || 0;
                const sale_amount = parseFloat(saleAmount.value) || 0;

                const netProfits = sale_cost - sale_amount;
                netProfitsInput.value = netProfits.toFixed(2);
            }

            saleCost.addEventListener('input', updateNetProfits);
            saleAmount.addEventListener('input', updateNetProfits);
        });
    </script>

    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء معاملة بيع جديدة")
                const form = modal.find('form');
                form[0].reset();
                modal.find('form').attr('action', '{{ route('admin.sale.create') }}');
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                const form = modal.find('form');
                form[0].reset();
                modal.find('.modal-title').text("تعديل معاملة البيع رقم" + ' ' + ($(this)
                    .data('sale').utr || ''));
                modal.find('input[name=item_name]').val($(this).data('sale').item_name)
                modal.find('select[name=fund_id]').val($(this).data('sale').fund_id)
                modal.find('input[name=buyer_account_number]').val($(this).data('sale').buyer
                    .account_number)
                modal.find('input[name=amount]').val($(this).data('sale').amount)
                modal.find('input[name=sale_cost]').val($(this).data('sale').sales_cost)
                const saleCost = parseFloat($(this).data('sale').sales_cost) || 0;
                const saleAmount = parseFloat($(this).data('sale').amount) || 0;
                const netProfits = saleCost - saleAmount;
                modal.find('input[name=net_profits]').val(netProfits.toFixed(2));
                modal.find('textarea[name=note]').text($(this).data('sale').note)
                modal.find('form').attr('action', $(this).data('href'));
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف معاملة البيع رقم" + ' ' + ($(this)
                    .data('sale').utr || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
        })
    </script>
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    clickedButton.prop('disabled', true).html('جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush