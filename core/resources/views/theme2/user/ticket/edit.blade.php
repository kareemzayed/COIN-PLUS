@extends(template() . 'layout.master2')
@push('style')
    <style>
        .image-preview input,
        #callback-preview input {
            position: absolute;
            left: 0px;
            top: 0px;
            z-index: -1;
        }

        .image-preview {
            background: center;
            background-repeat: no-repeat;
            background-size: cover;
            width: 50%;
            height: 150px;
        }

        .image-preview label,
        #callback-preview label {
            background-color: #47494b;
            text-align: center;
            padding: 10px;
            width: 100%;
            cursor: pointer;
        }

        .image-preview,
        #callback-preview {
            width: 100%;
            height: 250px;
            border: 2px solid #212529;
            border-radius: 3px;
            position: relative;
            overflow: hidden;
            background-color: #212529;
        }
    </style>
@endpush
@section('content2')
    <div class="dashboard-body-part">
        <div class="project-status-top d-flex justify-content-end">
            <h4 class="project-status-heading">
                <a href="{{ route('user.ticket.index') }}"><button class="btn btn-main mt-2">
                        العودة إلى القائمة <i class="fas fa-arrow-left"></i>
                    </button>
                </a>
            </h4>
        </div>
        <div class="card card-wrapper">
            <form action="{{ route('user.ticket.update', $ticket->id) }}" class="p-3" enctype="multipart/form-data"
                method="post">
                @csrf
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="mb-2">الموضوع</label>
                            <input type="text" name="subject" class="form-control bg-dark" required="" placeholder=""
                                value="{{ $ticket->subject }}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="mb-2">الأولوية</label>
                            <select class="form-select selectric bg-dark" name="priority">
                                <option value="1" @if ($ticket->priority == 1) selected @endif>عالية
                                </option>
                                <option value="2" @if ($ticket->priority == 2) selected @endif>متوسطة
                                </option>
                                <option value="3" @if ($ticket->priority == 3) selected @endif>منخفضة
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" class="mb-2 mt-2">الرسالة</label>
                    <textarea class="form-control bg-dark" id="exampleFormControlTextarea1" rows="3" name="message">{{ $ticket_reply->message }}</textarea>
                </div>
                <div class="row">
                    <div class="custom-file mt-3 col-md-6">
                        <div id="image-preview" class="image-preview"
                            style="background-image: url({{ getFile('Ticket', $ticket_reply->file, true) }});">
                            <label class="mb-2" for="image-upload" id="image-label">اختر ملفًا</label>
                            <input type="file" class="form-control bg-dark" name="file" id="image-upload" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-main mt-2 cms-submit">تحديث</button>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            'use strict'

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_default: "اختر ملفًا",
                label_selected: "تحديث الصورة",
                no_label: false,
                success_callback: null
            });
        })
    </script>
@endpush
