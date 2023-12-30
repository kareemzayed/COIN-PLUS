@extends(template() . 'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row gy-4">
            <div class="col-md-8 text-md-start text-center">
                <div class="tab-btn-group">
                    <a href="{{ route('user.ticket.index') }}"
                        class="tab-btn {{ request()->status == '' ? 'active' : '' }}"><i class="fa fa-inbox fa-lg"
                            aria-hidden="true"></i>
                            كل التذاكر <span class="num">{{ $tickets_all }}</span>
                    </a>
                    <a href="{{ route('user.ticket.status', 'answered') }}"
                        class="tab-btn {{ request()->status == 'answered' ? 'active' : '' }}">تم الرد
                        <span class="num">{{ $tickets_answered }}</span>
                    </a>
                    <a href="{{ route('user.ticket.status', 'pending') }}"
                        class="tab-btn {{ request()->status == 'pending' ? 'active' : '' }}">
                        قيد الانتظار <span class="num">{{ $tickets_pending }}</span>
                    </a>
                    <a href="{{ route('user.ticket.status', 'closed') }}"
                        class="tab-btn {{ request()->status == 'closed' ? 'active' : '' }}">
                        مغلق <span class="num">{{ $tickets_closed }}</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4  text-md-end text-center">
                <button id="new-ticket" class="btn main-btn btn-sm">إنشاء تذكرة جديدة <i class="fa fa-envelope"
                        aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="mt-5">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table site-table">
                        <thead>
                            <tr>
                                <th>رقم التذكرة</th>
                                <th>الموضوع</th>
                                <th>إجمالي الردود</th>
                                <th>الحالة</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                                <tr>
                                    <td data-caption="رقم التذكرة">{{ $ticket->support_id }}</td>
                                    <td data-caption="الموضوع">{{ $ticket->subject }}</td>

                                    <td data-caption="إجمالي الردود">({{ $ticket->ticketReplies->count() }})
                                    </td>
                                    <td data-caption="الحالة">
                                        @if ($ticket->status == 1)
                                            <span class="badge badge-danger"> مغلق </span>
                                        @endif
                                        @if ($ticket->status == 2)
                                            <span class="badge badge-warning"> قيد الانتظار </span>
                                        @endif
                                        @if ($ticket->status == 3)
                                            <span class="badge badge-success"> تم الرد </span>
                                        @endif
                                    </td>
                                    <td data-caption="إجراء">
                                        <button data-route="{{ route('user.ticket.update', $ticket->id) }}"
                                            data-ticket="{{ $ticket }}"
                                            data-message="{{ $ticket->ticketReplies()->where('ticket_id', $ticket->id)->first() }}"
                                            class="view-btn view-btn-primary edit-modal"><i class="fas fa-pen"></i></button>

                                        <a href="{{ route('user.ticket.show', $ticket->id) }}"
                                            class="view-btn view-btn-info"><i class="fas fa-eye"></i></a>

                                        <a data-route="{{ route('user.ticket.status-change', $ticket->id) }}"
                                            class="view-btn view-btn-danger delete" title="إغلاق التذكرة"><i
                                                class="fas fa-times"></i> </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">
                                        لم يتم العثور على بيانات
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade " id="add" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('user.ticket.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white">إنشاء تذكرة</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>الموضوع</label>
                                    <input type="text" name="subject" class="form-control" required=""
                                        placeholder="الموضوع هنا" value="{{ old('subject') }}">
                                </div>

                            </div>
                            <div class="row align-items-center mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group ticket-comment-box">
                                        <label for="exampleFormControlTextarea1">الرسالة</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="30" name="message"
                                            placeholder="الرسالة">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label"
                                            class="text-white">اختر ملفًا</label>
                                        <input type="file" name="file" id="image-upload" class="form-control" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-sm main-btn">إنشاء التذكرة</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade " id="edit_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" enctype="multipart/form-data" method="post">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white">تعديل التذكرة</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>الموضوع هنا</label>
                                    <input type="text" name="subject" class="form-control" required=""
                                        placeholder="الموضوع هنا" value="{{ old('subject') }}">
                                </div>

                            </div>
                            <div class="row align-items-center mt-2">
                                <div class="col-lg-12">
                                    <div class="form-group ticket-comment-box">
                                        <label for="exampleFormControlTextarea1">الرسالة</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" cols="30" name="message"
                                            placeholder="الرسالة">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div id="image-preview" class="image-preview">
                                        <label for="image-upload" id="image-label"
                                            class="text-white">اختر ملفًا</label>
                                        <input type="file" name="file" id="image-upload" class="form-control" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-sm main-btn">تعديل التذكرة</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" tabindex="-3" id="delete" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white">إغلاق التذكرة</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من إغلاق هذه التذكرة؟</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm main-btn">إغلاق</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            'use strict'
            $('#new-ticket').on('click', function() {
                const modal = $('#add');
                modal.modal('show');
            })

            $('.edit-modal').on('click', function(e) {
                e.preventDefault();
                const modal = $('#edit_modal');
                modal.find('form').attr('action', $(this).data('route'));
                modal.find('input[name=subject]').val($(this).data('ticket').subject)
                modal.find('textarea[name=message]').val($(this).data('message').message)
                modal.modal('show');
            })

            $('.delete').on('click', function(e) {
                e.preventDefault();
                const modal = $('#delete');
                modal.find('form').attr('action', $(this).data('route'));
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
                    clickedButton.prop('disabled', true).html(
                        'جاري ... <i class="fa fa-spinner fa-spin"></i>');
                    $(':submit', this).not(clickedButton).prop('disabled', true);
                }
            });
        });
    </script>
@endpush