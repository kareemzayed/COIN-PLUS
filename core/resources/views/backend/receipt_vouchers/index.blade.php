@extends('backend.layout.master')
@section('content')
    <div class="main-content">
        <div class="section">
            <div class="section-header pl-0 pb-3">
                <h3 class="pl-0">قائمة سندات القبض</h3>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>
                        @if (checkPermission(45))
                            <button class="btn btn-primary add"><i class="fa fa-plus"></i>
                                إنشاء سند قبض جديد</button>
                        @endif
                    </h4>
                    <div class="card-header-form">
                        <form method="GET" action="{{ route('admin.receipt.vouchers.search') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="رقم السند" name="receipt_number"
                                    value="{{ isset($search['receipt_number']) ? $search['receipt_number'] : '' }}">
                                <input type="text" class="form-control" placeholder="اسم العميل" name="customer_name"
                                    value="{{ isset($search['customer_name']) ? $search['customer_name'] : '' }}">
                                <input type="date" class="form-control" placeholder="تاريخ إنشاء السند" name="date"
                                    value="{{ isset($search['date']) ? $search['date'] : '' }}">
                                <select name="type" class="form-select form-control">
                                    <option disabled selected>طريقة استلام الأموال</option>
                                    <option value="">عرض الكل</option>
                                    <option value="1"
                                        {{ isset($search['type']) && $search['type'] == 1 ? 'selected' : '' }}>
                                        كاش (فوري)</option>
                                    <option value="2"
                                        {{ isset($search['type']) && $search['type'] == 2 ? 'selected' : '' }}>
                                        شيك</option>
                                </select>
                                <select name="currency_id" class="form-select form-control">
                                    <option disabled selected>عملة السند</option>
                                    <option value="">عرض الكل</option>
                                    @forelse($currencies as $currency)
                                        <option value="{{ $currency->id }}"
                                            {{ isset($search['currency_id']) && $search['currency_id'] == $currency->id ? 'selected' : '' }}>
                                            {{ $currency->code }}</option>
                                    @empty
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
                                    <th>رقم السند</th>
                                    <th>اسم العميل</th>
                                    <th>المبلغ</th>
                                    <th>طريقة استلام الأموال</th>
                                    <th>ذالك مقابل</th>
                                    <th>ملاحظة</th>
                                    <th>في</th>
                                    <th>إجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($receipt_vouchers as $key => $voucher)
                                    <tr>
                                        <td>{{ $key + $receipt_vouchers->firstItem() }}</td>
                                        <td>{{ $voucher->receipt_num }}</td>
                                        <td>{{ $voucher->customar_name }}</td>
                                        <td>
                                            {{ number_format($voucher->amount, 2) . ' ' . optional($voucher->currency)->code }}
                                        </td>
                                        <td>
                                            @if ($voucher->receipt_type == 1)
                                                كاش (فوري)
                                            @elseif($voucher->receipt_type == 2)
                                                شيك
                                            @endif
                                        </td>
                                        <td>{{ $voucher->exchange_for }}</td>
                                        <td>{{ $voucher->note }}</td>
                                        <td>
                                            {{ $voucher->created_at->format('m/d/Y h:i A') }}
                                        </td>
                                        <td style="width:14%">
                                            @if (checkPermission(26))
                                                <button
                                                    data-href="{{ route('admin.receipt.voucher.update', $voucher->id) }}"
                                                    data-voucher="{{ $voucher }}"
                                                    class="btn btn-md btn-info update"><i class="fa fa-pen"></i></button>
                                            @endif

                                            @if (checkPermission(27))
                                                <button
                                                    data-href="{{ route('admin.receipt.voucher.delete', $voucher->id) }}"
                                                    data-voucher="{{ $voucher }}"
                                                    class="btn btn-md btn-danger delete"><i
                                                        class="fa fa-trash"></i></button>
                                            @endif

                                            @if (checkPermission(52))
                                                <a href="{{ route('admin.receipt.voucher.print', $voucher->id) }}"
                                                    class="btn btn-md btn-warning pdf" target="_blank"
                                                    style="width:36px; height:36px"><i class="fa fa-print"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="100%">لم يتم العثور علي اي سندات قبض</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($receipt_vouchers->hasPages())
                        <div class="card-footer">
                            {{ $receipt_vouchers->links('backend.partial.paginate') }}
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
                        <!-- action input -->
                        <input type="hidden" id="clickedButtonValue" name="action" value="">

                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label for="customar_name">اسم العميل <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="customar_name" name="customar_name" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="currency_id">عملة السند <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="currency_id" id="currency_id">
                                    <option disabled selected value="0">اختر عملة السند</option>
                                    @forelse($currencies as $currency)
                                        <option value="{{ $currency->id }}" data-code="{{ $currency->code }}">
                                            {{ $currency->name . ' - ' . $currency->code }}
                                        </option>
                                    @empty
                                        <option disabled selected>لم يتم العثور علي عملات</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount">المبلغ
                                    <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="number" name="amount" id="amount" placeholder="0.00"
                                        class="form-control" step="any" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text receipt_currency">

                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="amount_in_words">المبلغ بالكلمات
                                    <span class="text-danger">*</span> </label>
                                <input type="text" name="amount_in_words" id="amount_in_words" class="form-control"
                                    required>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="receipt_type">طريقة استلام الأمول
                                    <span class="text-danger">*</span> </label>
                                <select name="receipt_type" id="receipt_type" class="form-control">
                                    <option value="0" disabled selected>اخنر الطريقة</option>
                                    <option value="1">كاش (فوري)</option>
                                    <option value="2">شيك</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="check_no">رقم الشيك <span class="text-danger">*</span></label>
                                <input type="text" name="check_no" id="check_no" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="bank">اسم البنك <span class="text-danger">*</span></label>
                                <input type="text" name="bank" id="bank" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="exchange_for">ذالك مقابل</label>
                                <textarea name="exchange_for" id="exchange_for" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="note">ملاحظة</label>
                                <textarea name="note" id="note" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">إغلاق</button>
                        <button type="submit" name="action" value="save" class="btn btn-primary">حفظ</button>
                        @if (checkPermission(52))
                            <button type="submit" name="action" value="saveAndPrint" class="btn btn-success">حفظ
                                وطباعة</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#receipt_type').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue == 1) { // Cash
                    $('#check_no, #bank').closest('.form-group').hide();
                } else if (selectedValue == 2) { // Check
                    $('#check_no, #bank').closest('.form-group').show();
                }
            });
        });
    </script>
    <script>
        $(function() {
            'use strict'

            $('.add').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("إنشاء سند قبض جديد")
                modal.find('input[name=customar_name]').val('')
                modal.find('input[name=amount]').val('')
                modal.find('input[name=amount_in_words]').val('')
                modal.find('input[name=cost]').val('')
                modal.find('select[name=receipt_type]').val('0')
                modal.find('select[name=currency_id]').val('0')
                $('#check_no, #bank').closest('.form-group').hide();
                $('.receipt_currency').text('');
                modal.find('input[name=check_no]').val('')
                modal.find('input[name=bank]').val('')
                modal.find('textarea[name=exchange_for]').text('')
                modal.find('textarea[name=note]').text('')
                modal.find('form').attr('action', '{{ route('admin.receipt.voucher.create') }}');
                modal.find('#submit').show();
                modal.modal('show');
            })

            $('.update').on('click', function() {
                const modal = $('#modelId');
                modal.find('.modal-title').text("تعديل سند القبض رقم" + ' ' + ($(this)
                    .data('voucher').receipt_num || ''));
                modal.find('input[name=customar_name]').val($(this).data('voucher').customar_name)
                modal.find('select[name=currency_id]').val($(this).data('voucher').currency_id)
                $('.receipt_currency').text($(this).data('voucher').currency.code)
                modal.find('input[name=amount]').val($(this).data('voucher').amount)
                modal.find('input[name=amount_in_words]').val($(this).data('voucher').amount_in_words)
                modal.find('input[name=cost]').val($(this).data('voucher').cost)
                modal.find('select[name=receipt_type]').val($(this).data('voucher').receipt_type)
                if ($(this).data('voucher').receipt_type == 1) { // Cash
                    $('#check_no, #bank').closest('.form-group').hide();
                } else if ($(this).data('voucher').receipt_type == 2) { // Check
                    $('#check_no, #bank').closest('.form-group').show();
                }
                modal.find('input[name=check_no]').val($(this).data('voucher').check_no)
                modal.find('input[name=bank]').val($(this).data('voucher').bank)
                modal.find('textarea[name=exchange_for]').text($(this).data('voucher').exchange_for)
                modal.find('textarea[name=note]').text($(this).data('voucher').note)
                modal.find('form').attr('action', $(this).data('href'));
                modal.find('#submit').show();
                modal.modal('show');
            })

            $('.delete').on('click', function() {
                const modal = $('#delete_modal')
                modal.find('.modal-title').text("حذف سند القبض رقم" + ' ' + ($(this)
                    .data('voucher').receipt_num || ''));
                modal.find('form').attr('action', $(this).data('href'))
                modal.modal('show');
            })
        });

        document.addEventListener('DOMContentLoaded', function() {
            const currencySelect = document.getElementById('currency_id');
            const receiptCurrencySpan = document.querySelector('.receipt_currency');

            function updateReceiptCurrency() {
                const selectedOption = currencySelect.options[currencySelect.selectedIndex];
                const currencyCode = selectedOption.getAttribute('data-code') || '';

                receiptCurrencySpan.textContent = currencyCode;
            }
            currencySelect.addEventListener('change', updateReceiptCurrency);
        });
    </script>
    <script>
        $(function() {
            'use strict';

            $('form').on('submit', function() {
                const clickedButton = $(document.activeElement);
                if (clickedButton.is(':submit')) {
                    $('#clickedButtonValue').val(clickedButton.val());
                    clickedButton.prop('disabled', true).html(
                        'جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush