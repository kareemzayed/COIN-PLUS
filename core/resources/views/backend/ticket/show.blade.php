@extends('backend.layout.master')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header d-flex justify-content-between">
                <h1>مناقشة تذكرة الدعم الفني</h1>
                <a href="{{ route('admin.ticket.index') }}"><button class="btn btn-primary"><i class="fas fa-arrow-left">
                            الرجوع الي القائمة</i></button></a>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-wrapper">
                        <div class="card-header">

                            <div class="project-status-top">
                                <h6 class="project-status-heading"> العميل: {{ $ticket->user->fullname }}
                                </h6>
                                <h6 class="project-status-heading"> تذكره {{ $ticket->support_id }}</h6>
                                <h6 class="project-status-heading"> الموضوع: {{ $ticket->subject }}</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.ticket.reply', $ticket->id) }}" enctype="multipart/form-data"
                                method="post">
                                @csrf
                                <div class="row justify-content-md-between">
                                    <div class="col-md-3 mb-3">
                                        <div id="image-preview" class="image-preview">
                                            <label for="image-upload" id="image-label">اختر ملفًا</label>
                                            <input type="file" name="image" id="image-upload" />
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group ticket-comment-box">
                                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"
                                                placeholder="اكتب رسالتك او ردك هنا"></textarea>
                                        </div>
                                    </div>
                                    @if (checkPermission(40))
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <button type="submit"
                                                    class="btn cms-submit ticket-reply btn btn-primary"><i
                                                        class="fas fa-reply"> </i>رد</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-group">
                @foreach ($ticket_reply as $reply)
                    <div class="card">
                        <div class="card-header @if ($reply->admin_id) bg-primary @else bg-success @endif">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1 text-white">الرد من -
                                    @if (!$reply->admin_id)
                                        {{ $reply->ticket->user->fullname }}
                                    @endif
                                    @if ($reply->admin_id)
                                        {{ $reply->admin->name ?? 'الأدمن' }}
                                    @endif
                                </h5>
                                <small class="text-white">{{ $reply->created_at->format('m/d/Y h:i A') }}</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="mb-1">
                                {{ $reply->message }}
                            </p>
                            @if ($reply->file)
                                <div class="gallery">
                                    <div class="gallery-item" data-image="{{ getFile('Ticket', $reply->file, true) }}"
                                        data-title="Image 1">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection

@push('style-plugin')
    <link rel="stylesheet" href="{{ asset('asset/admin/css/chocolate.css') }}">
@endpush

@push('script-plugin')
    <script src="{{ asset('asset/admin/js/chocolate.js') }}"></script>
@endpush

@push('script')
    <script>
        $(function() {
            'use strict'

            $.uploadPreview({
                input_field: "#image-upload", // Default: .image-upload
                preview_box: "#image-preview", // Default: .image-preview
                label_field: "#image-label", // Default: .image-label
                label_default: "اختر ملفًا", // Default: Choose File
                label_selected: "تحميل صورة", // Default: Change File
                no_label: false, // Default: false
                success_callback: null // Default: null
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
@endpush
