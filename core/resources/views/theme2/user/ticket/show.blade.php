@extends(template().'layout.master2')

@section('content2')
    <div class="dashboard-body-part">
        <div class="row">
            <div class="col-md-8 text-md-start text-center">
                <div class="d-flex align-items-center">
                    <h4>{{ $ticket->support_id }} - {{ $ticket->subject }} </h4>
                </div>
            </div>
            <div class="col-md-4  text-md-end text-center">
                <a href="{{ route('user.ticket.index') }}" class="btn main-btn"> العودة إلى القائمة <i class="fas fa-arrow-left"></i></a>
            </div>
        </div>

        <div class="mt-4">
            <form action="{{ route('user.ticket.reply', $ticket->id) }}" enctype="multipart/form-data"
                method="post">
                @csrf
                <div class="row justify-content-md-between">
                    <div class="col-md-12">
                        <div class="form-group ticket-comment-box">
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <label for="exampleFormControlTextarea1">الرسالة</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                name="message"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 form-group mt-3">
                        <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label">اختر ملفًا</label>
                            <input type="file" name="file" id="image-upload" class="form-control" />
                        </div>
                    </div>

                    <div class="col-lg-12 mt-3 text-end">
                            <button type="submit" class="btn main-btn ticket-reply"><i
                                    class="fas fa-reply"></i>
                                رد
                            </button>
                    </div>
                </div>
            </form>
            <div class="ticket-reply-area mt-5">
                @forelse($ticket_reply as $ticket)
                    <div class="single-reply {{$ticket->admin_id != null ? 'admin-reply' : ''}}">
                        <span class="text-small text-secondary mb-2">رد في {{ $ticket->created_at->format('d/m/Y g:i A') }}</span>
                        <p>
                            {{ $ticket->message }}
                        </p>
                        @if ($ticket->file)
                            <p class="mb-0 mt-2">
                                <a class="color-change" href="{{ route('user.ticket.download', $ticket->id) }}"> <i class="fas fa-cloud-download-alt"></i> عرض المرفقات</a>
                            </p>
                        @endif
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
@endsection
@push('script')
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